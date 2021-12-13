<?php
$_lang['area_lastmodified.main'] = 'Main';

$_lang['setting_lastmodified.response'] = 'Cache-control response';
$_lang['setting_lastmodified.response_desc'] = 'Specifies a value of Cache-control response directive. Available values: "private", "public".';
$_lang['setting_lastmodified.maxage'] = 'Cache-control max-age';
$_lang['setting_lastmodified.maxage_desc'] = 'Specifies a value of Cache-control max-age directive in seconds. Default is 3600.';
$_lang['setting_lastmodified.expires'] = 'Expires offset';
$_lang['setting_lastmodified.expires_desc'] = 'Specifies a value of Expires header current time offset in seconds. Default is 3600.';
$_lang['setting_lastmodified.update_parent'] = 'Update parent';
$_lang['setting_lastmodified.update_parent_desc'] = 'Updates the last editing date of the parent resource to show that it has been updated too. Default false.';
$_lang['setting_lastmodified.update_level'] = 'Update nesting level';
$_lang['setting_lastmodified.update_level_desc'] = 'Sets a nested level from the current resource and up to update the last editing date. Default 1.';
$_lang['setting_lastmodified.update_start'] = 'Update start page';
$_lang['setting_lastmodified.update_start_desc'] = 'Updates the last editing date of the start page on a resource change. Default false.';
$_lang['setting_lastmodified.prevent_authorized'] = 'Prevent authorized';
$_lang['setting_lastmodified.prevent_authorized_desc'] = 'Prevents If-Modified-Since header handling for authorized users. Default true.';
$_lang['setting_lastmodified.prevent_session'] = 'Prevent in session';
$_lang['setting_lastmodified.prevent_session_desc'] = 'Prevents If-Modified-Since header handling when any of the values (comma-separated list) occur in session names. Default minishop2';
$_lang['setting_lastmodified.exclude'] = 'Exclude from processing by id';
$_lang['setting_lastmodified.exclude_desc'] = 'Prevents If-Modified-Since header handling for any of listed document ids (comma-separated list). Empty by default';
