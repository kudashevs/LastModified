<?php

$settings = [];

$tmp = [
    'response' => [
        'xtype' => 'textfield',
        'value' => 'private',
        'area' => PKG_NAME_LOWER . '.main',
    ],
    'maxage' => [
        'xtype' => 'textfield',
        'value' => '3600',
        'area' => PKG_NAME_LOWER . '.main',
    ],
    'expires' => [
        'xtype' => 'textfield',
        'value' => '3600',
        'area' => PKG_NAME_LOWER . '.main',
    ],
    'update_parent' => [
        'xtype' => 'combo-boolean',
        'value' => false,
        'area' => PKG_NAME_LOWER . '.main',
    ],
    'update_level' => [
        'xtype' => 'textfield',
        'value' => '1',
        'area' => PKG_NAME_LOWER . '.main',
    ],
    'update_start' => [
        'xtype' => 'combo-boolean',
        'value' => false,
        'area' => PKG_NAME_LOWER . '.main',
    ],
   'prevent_authorized' => [
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => PKG_NAME_LOWER . '.main',
   ],
    'prevent_session' => [
        'xtype' => 'textfield',
        'value' => 'minishop2',
        'area' => PKG_NAME_LOWER . '.main',
    ],
    'exclude' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => PKG_NAME_LOWER . '.main',
    ],
];

foreach ($tmp as $k => $v) {
    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge([
        'key' => PKG_NAME_LOWER . '.' . $k,
        'namespace' => PKG_NAME_LOWER,
    ], $v), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
