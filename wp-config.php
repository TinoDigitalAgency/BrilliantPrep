<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'briliant' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'briliant' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'briliant' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Sa-yms/Cs$4-|D_mZ6 `oH@yU?L1,3.<9CVOYdrY+cAd?V[JZ{[- &{,Jv=n|nH[' );
define( 'SECURE_AUTH_KEY',  'MHrKsu&y6I[/`[2@;D(6q,]%.G4);IR(Is_{/(|Kt6xD=r>?`cmijNAHX&n?&.?m' );
define( 'LOGGED_IN_KEY',    'P9-(}9?k@RAw)n!Y?AOD^ rx:Q5_&|ZGX/pTs[sZD/aqPu~+*dpM.rykdi(ZIe5J' );
define( 'NONCE_KEY',        '9t]8+sbK>1bp1j-D1=# /7[/y!VsPW7W[ 6AV8knF!J*/+h$/8K)4JO%-H.Br]Dn' );
define( 'AUTH_SALT',        '>DOaI*Z_T*<t>!U+SaeKq~!#d;I@EDI,hfmZ.)tUoQ P hcv%S(EOL|EcaNM2? 5' );
define( 'SECURE_AUTH_SALT', 'YOq|}_S+V+0x$xdBvckSS4dZe*mejVyP=e?_!12xqIcw6R]xxbZ[@gV[&a8Oh .|' );
define( 'LOGGED_IN_SALT',   '[;]1j,F@TMAUr%Ki-_c$-uh>56^;6D+%#e}JvA?$;A-::?|._nMVWf;kA1@=I/q]' );
define( 'NONCE_SALT',       'I~I_?LB%/h=YfPdW*0}udtnysAP$(rV3N~u=Qs0qc*@uFaLBP0u)aZ-4gpsm0IQ8' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

define('ALLOW_UNFILTERED_UPLOADS', true);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
