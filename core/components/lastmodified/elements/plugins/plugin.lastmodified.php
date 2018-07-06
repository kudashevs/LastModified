<?php
/**
 * MODx Revolution plugin which handle request If-Modified-Since
 *
 * @package lastmodified
 * @var integer $dtm Value of last update time of document
 * @var integer $ltm Value of HTTP_IF_MODIFIED_SINCE from request
 * @var string $rule Cache-control directive (public, private)
 * @var integer $maxage Cache max age in seconds
 * @var integer $expire Cache expire in seconds
 */
if ($modx->event->name == 'OnWebPagePrerender') {
    $dtm = ($modx->resource->get('editedon')) ? strtotime($modx->resource->get('editedon')) : strtotime($modx->resource->get('createdon'));
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
 * @var modResource $resource Current resource object
 * @var modResource $parent Parent resource object
 */
if ($modx->event->name == 'OnDocFormSave') {
    if ($modx->getOption('lastmodified.update_parent')) {
        $resource = $modx->getObject('modResource', $id);
        $parentId = $resource->get('parent');

        if ($parentId < 1) {
            return '';
        }

        $parent = $modx->getObject('modResource', $resource->get('parent'));

        if (!$parent instanceof modResource) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'LastModified: get wrong parent object [' . $parent. '] with id ' . $parentId . ' for document ' . $id. '.');
            return '';
        }

        $parent->set('editedon', time());
        $parent->save();
        return '';
    }
}