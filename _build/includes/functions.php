<?php

/**
 * @param $filename
 * @return string
 */
function getPhpFileContent($filename)
{
    $file = trim(file_get_contents($filename));
    preg_match('#\<\?php(.*)#is', $file, $data);

    return rtrim(rtrim(trim($data[1]), '?>'));
}
