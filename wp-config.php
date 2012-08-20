<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'bitarov');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
//define('DB_HOST', '192.168.0.7');
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`PM[M3d9G0JZS|<(ui8=z?1gRRQaZ$)a aTD@QbJQCOhK[Qip2+cWb(fO+c1/;c7');
define('SECURE_AUTH_KEY',  ';+`ehB[BSd=qYK7KFaqloI>jSoq0SErWW@^WW!+uFi615?+>M$1P#Co|a:nwD8j|');
define('LOGGED_IN_KEY',    '?<SojEh=_(4tH$(W-m|DBvp%um!r9U3`q{6[zF:TZVl~U(=o/x}dv:-|]~z)LotI');
define('NONCE_KEY',        'OpQ ZVK9erW[{m{0jq+_hCzNJA^8Ubz$BDSMIn*6f#N`{hp|Wn%}Gq;3&SdpS;*f');
define('AUTH_SALT',        ']g+n/X!7.#0W~B0&oYhgb&emHcgsXf6t?UY.K+^@}?R5yEp.)~nha[+5I)%nz0 ^');
define('SECURE_AUTH_SALT', 'GKn[m]F;<4/S?n_rI[bP_j&hla)]]2pF[zPVG%bclxEgG?qWKX1E>evfB*pIJCNI');
define('LOGGED_IN_SALT',   'Pl4Qj@aq}:8o0*?(LzJDj>H+HOQ&9H)>{X!ci!XqU#GfIr2NC9o7TBR-&Qqwa?b)');
define('NONCE_SALT',       'ic:rd)]yWxU@G-2?_>Rx(nP~p^)uv07UJ</fEuh`r+&YqguV.(b2PiR4^f(4t7[A');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Язык локализации WordPress, по умолчанию английский.
 *
 * Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
 * для выбранного языка должен быть установлен в wp-content/languages. Например,
 * чтобы включить поддержку русского языка, скопируйте ru_RU.mo в wp-content/languages
 * и присвойте WPLANG значение 'ru_RU'.
 */
define('WPLANG', 'ru_RU');

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
