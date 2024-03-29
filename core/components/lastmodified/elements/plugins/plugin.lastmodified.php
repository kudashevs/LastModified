<?php
/**
 * A part of LastModified plugin which handles the If-Modified-Since request header.
 *
 * @var modX $modx MODX instance
 * @var array $preventValues Prevent handling list
 * @var integer $lastUpdateTime Document last update time
 * @var integer $lastDownloadTime Document last download time (HTTP_IF_MODIFIED_SINCE)
 * @var string $cacheControl Cache-control directive (public, private)
 * @var integer $cacheMaxAge Cache max age in seconds
 * @var integer $cacheExpires Cache expires in seconds
 */
if ($modx->event->name == 'OnWebPagePrerender') {
    if ($modx->getOption('lastmodified.prevent_authorized') && ($modx->user->get('username') !== $modx->getOption('default_username'))) {
        return '';
    }

    if (!empty($modx->getOption('lastmodified.exclude'))) {
        $excludeOptionValues = explode(',', $modx->getOption('lastmodified.exclude'));

        $excludeIds = array_map(function ($value) {
            return (int)$value;
        }, $excludeOptionValues);

        if (in_array($modx->resource->id, $excludeIds, false)) {
            return '';
        }
    }

    if (!empty($modx->getOption('lastmodified.prevent_session'))) {
        $preventOptionValues = explode(',', $modx->getOption('lastmodified.prevent_session'));

        $preventValues = array_map(function ($value) {
            return strtolower(trim($value));
        }, $preventOptionValues);

        $sessionKeys = array_map(function ($value) {
            return strtolower(trim($value));
        }, array_keys($_SESSION));

        if (count(array_intersect($preventValues, $sessionKeys)) > 0) {
            return '';
        }
    }

    $lastUpdateTime = $modx->resource->get('editedon')
        ? strtotime($modx->resource->get('editedon'))
        : strtotime($modx->resource->get('createdon'));

    if (empty($lastUpdateTime)) {
        return '';
    }

    $cacheControl = trim($modx->getOption('lastmodified.response'));

    if (!in_array($cacheControl, ['private', 'public'])) { // 'no-cache'
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: wrong ' . $cacheControl . ' response value. Check configuration.');
        return '';
    }

    $cacheMaxAge = ((int)$modx->getOption('lastmodified.maxage') > 0) ? (int)$modx->getOption('lastmodified.maxage') : 3600;
    $cacheExpires = ((int)$modx->getOption('lastmodified.expires') > 0) ? (int)$modx->getOption('lastmodified.expires') : 3600;

    if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) { // browser has sent If-Modified-Since request header
        $lastDownloadTime = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
        if ($lastUpdateTime <= $lastDownloadTime) {
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
            header($protocol . ' 304 Not Modified');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastUpdateTime) . ' GMT');
            header('Cache-control: ' . $cacheControl . ', max-age=' . $cacheMaxAge);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheExpires));
            exit();
        }
    }
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastUpdateTime) . ' GMT');
    header('Cache-control: ' . $cacheControl . ', max-age=' . $cacheMaxAge);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cacheExpires));

    return '';
}

/**
 * A part of LastModified plugin which updates the editedon field of dependent resources.
 *
 * @var modX $modx MODX instance
 * @var int $id id of saved document (available on OnDocFormSave)
 * @var int $startId Site start id
 * @var modResource $start Site start object
 * @var int $nesting Nesting level option value
 * @var array $parentIds current page parents
 * @var modResource $parent Parent resource object
 */
if ($modx->event->name == 'OnDocFormSave') {

    if ($modx->getOption('lastmodified.update_start')) {

        $startId = (int)$modx->getOption('site_start');

        if ($startId > 0 && $startId !== $id) {

            $start = $modx->getObject('modResource', $startId);

            if (!$start instanceof modResource) {
                $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: get wrong modResource instance for site start with id ' . $startId . ' for document ' . $id . '.');
                return '';
            }

            $start->set('editedon', time());
            $start->clearCache($resource->context_key);
            $start->save();

            unset($start);
        }

        unset($startId);
    }

    if ($modx->getOption('lastmodified.update_parent')) {
        $nesting = (($level = (int)$modx->getOption('lastmodified.update_level')) > 0) ? $level : 1;

        $parentIds = $modx->getParentIds($id, $nesting, ['context' => $resource->context_key]);

        if (empty($parentIds)) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: get empty ParentIds array. Possible context violation.');
            return '';
        }

        foreach ($parentIds as $parentId) {
            if ($parentId === 0) {
                break;
            }

            $parent = $modx->getObject('modResource', $parentId);

            if (!$parent instanceof modResource) {
                $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: get wrong modResource instance for parent with id ' . $parentId . ' for document ' . $id . '.');
                return '';
            }

            $parent->set('editedon', time());
            $parent->clearCache($resource->context_key);
            $parent->save();

            unset($parent);
        }

        unset($parentIds);

        return '';
    }
}
