<?php
/**
 * MODx Revolution plugin which handle request If-Modified-Since
 *
 * @package lastmodified
 * @var string $dtm Last update document date
 */
if ($modx->event->name == 'OnWebPagePrerender') {
    $dtm = ($modx->resource->get('editedon')) ? strtotime($modx->resource->get('editedon')) : strtotime($modx->resource->get('createdon'));
    if (empty($dtm)) {
        return '';
    }

    if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        $ltm = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
        if ($dtm <= $ltm) {
            header('HTTP/1.0 304 Not Modified');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $dtm) . ' GMT');
            header('Cache-control: private, max-age=3600');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600));
            exit();
        }
    }
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $dtm) . ' GMT');
    header('Cache-control: private, max-age=3600');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600));
    return '';
}