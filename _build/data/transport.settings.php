<?php
$settings = array();
$tmp = array(
    'response' => array(
        'xtype' => 'textfield',
        'value' => 'private',
        'area' => PKG_NAME_LOWER . '.main',
    ),
    'maxage' => array(
        'xtype' => 'textfield',
        'value' => '3600',
        'area' => PKG_NAME_LOWER . '.main',
    ),
    'expires' => array(
        'xtype' => 'textfield',
        'value' => '3600',
        'area' => PKG_NAME_LOWER . '.main',
    ),
    'update_parent' => array(
        'xtype' => 'combo-boolean',
        'value' => false,
        'area' => PKG_NAME_LOWER . '.main',
    ),
    'update_level' => array(
        'xtype' => 'textfield',
        'value' => '1',
        'area' => PKG_NAME_LOWER . '.main',
    ),
);

foreach ($tmp as $k => $v) {
    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => PKG_NAME_LOWER . '.' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;