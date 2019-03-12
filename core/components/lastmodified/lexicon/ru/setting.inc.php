<?php
$_lang['area_lastmodified.main'] = 'Основные';

$_lang['setting_lastmodified.response'] = 'Cache-control ответ';
$_lang['setting_lastmodified.response_desc'] = 'Устанавливает значение ответа для Cache-control заголовка. Доступные значения: "private", "public".';
$_lang['setting_lastmodified.maxage'] = 'Cache-control max-age';
$_lang['setting_lastmodified.maxage_desc'] = 'Устанавливает значение max-age для Cache-control заголовка в секундах. По умолчанию 3600.';
$_lang['setting_lastmodified.expires'] = 'Expires смещение';
$_lang['setting_lastmodified.expires_desc'] = 'Устанавливает смещение от текущего времени для Expires заголовка в секундах. По умолчанию 3600.';
$_lang['setting_lastmodified.update_parent'] = 'Обновление родителя';
$_lang['setting_lastmodified.update_parent_desc'] = 'Обновляет дату последнего редактирования родительского ресурса для переполучения его контента. По умолчанию false.';
$_lang['setting_lastmodified.update_level'] = 'Уровень вложенности обновления';
$_lang['setting_lastmodified.update_level_desc'] = 'Определяет уровень вложенности от текущего ресурса и выше для обновления дат родительских ресурсов. По умолчанию 1.';
$_lang['setting_lastmodified.update_start'] = 'Обновление главной';
$_lang['setting_lastmodified.update_start_desc'] = 'Обновляет так же даты последнего редактирования для главной страницы. По умолчанию false.';
$_lang['setting_lastmodified.prevent_authorized'] = 'Не обрабатывать авторизованных';
$_lang['setting_lastmodified.prevent_authorized_desc'] = 'Предотвращать обработку If-Modified-Since для авторизованных пользователей. По умолчанию true.';
$_lang['setting_lastmodified.prevent_session'] = 'Не обрабатывать если в сессии';
$_lang['setting_lastmodified.prevent_session_desc'] = 'Предотвращать обработку If-Modified-Since любое из перечисленных значений (через запятую) было найдено в именах переменных сессии. По умолчанию minishop2.';