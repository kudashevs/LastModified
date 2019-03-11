<?php
/**
 * MODx Revolution plugin which handle request If-Modified-Since
 *
 * @package lastmodified
 * @var modX $modx MODX instance
 * @var integer $dtm Value of last update time of document
 * @var integer $ltm Value of HTTP_IF_MODIFIED_SINCE from request
 * @var string $rule Cache-control directive (public, private)
 * @var integer $maxage Cache max age in seconds
 * @var integer $expire Cache expire in seconds
 */
if ($modx->event->name == 'OnWebPagePrerender') {
    if ($modx->getOption('lastmodified.prevent_authorized') && ($modx->user->get('username') !== '(anonymous)')) {
        return '';
    }

    $dtm = $modx->resource->get('editedon') ? strtotime($modx->resource->get('editedon')) : strtotime($modx->resource->get('createdon'));
    if (empty($dtm)) {
        return '';
    }

    $rule = trim($modx->getOption('lastmodified.response'));

    if (!in_array($rule, ['private', 'public'])) { // 'no-cache'
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: wrong response directive value. Check configuration.');
        return '';
    }

    $maxage = ((int)$modx->getOption('lastmodified.maxage') > 0) ? (int)$modx->getOption('lastmodified.maxage') : 3600;
    $expire = ((int)$modx->getOption('lastmodified.expires') > 0) ? (int)$modx->getOption('lastmodified.expires') : 3600;

    if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        $ltm = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
        if ($dtm <= $ltm) {
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
            header($protocol . ' 304 Not Modified');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $dtm) . ' GMT');
            header('Cache-control: ' . $rule . ', max-age=' . $maxage);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expire));
            exit();
        }
    }
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $dtm) . ' GMT');
    header('Cache-control: ' . $rule . ', max-age=' . $maxage);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expire));
    return '';
}

/**
 * Update parent editedon field
 *
 * @var modX $modx MODX instance
 * @var int $id The id of document for saving available for OnDooFormSave event
 * @var modResource $parent Parent resource object
 */
if ($modx->event->name == 'OnDocFormSave') {

    if ($modx->getOption('lastmodified.update_start')) {

        $mainId = $modx->getOption('site_start');

        if ($mainId > 0 && $mainId !== $id) {

            $main = $modx->getObject('modResource', $mainId);

            if (!$main instanceof modResource) {
                $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: get wrong modResource instance for main page with id ' . $mainId . ' for document ' . $id. '.');
                return '';
            }

            $main->set('editedon', time());
            $main->save();

            unset($main);
        }

        unset($mainId);
    }

    if ($modx->getOption('lastmodified.update_parent')) {
        $level = ((int)$modx->getOption('lastmodified.update_level') > 0) ? (int)$modx->getOption('lastmodified.update_level') : 1;

        $parentIds = $modx->getParentIds($id, $level, ['context' => 'web']);

        foreach ($parentIds as $parentId) {
            if ($parentId === 0) {
                continue;
            }

            $parent = $modx->getObject('modResource', $parentId);

            if (!$parent instanceof modResource) {
                $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: get wrong modResource instance for parent with id ' . $parentId . ' for document ' . $id. '.');
                return '';
            }

            $parent->set('editedon', time());
            $parent->save();

            unset($parent);
        }

        return '';
    }
}