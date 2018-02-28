<?php
/**
 * MODx Revolution plugin which handle request If-Modified-Since
 *
 * @package lastmodified
 * @var string $dtm Last update document time
 */
if ($modx->event->name == 'OnWebPagePrerender') {
    $dtm = ($modx->resource->get('editedon')) ? strtotime($modx->resource->get('editedon')) : strtotime($modx->resource->get('createdon'));
    if (empty($dtm)) {
        return '';
    }

    $maxage = ((int)$modx->getOption('lastmodified.maxage') > 0) ? (int)$modx->getOption('lastmodified.maxage') : 3600;
    $expire = ((int)$modx->getOption('lastmodified.expires') > 0) ? (int)$modx->getOption('lastmodified.expires') : 3600;

    if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        $ltm = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
        if ($dtm <= $ltm) {
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
            header($protocol . ' 304 Not Modified');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $dtm) . ' GMT');
            header('Cache-control: private, max-age=' . $maxage);
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expire));
            exit();
        }
    }
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $dtm) . ' GMT');
    header('Cache-control: private, max-age=' . $maxage);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expire));
    return '';
}