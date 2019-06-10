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
define( 'DB_NAME', 'promom00_test' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'promom00_test' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'Dd!46G~cv4' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'promom00.mysql.tools' );

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
define( 'AUTH_KEY',         'XtB/pBc@Sdi/`.kr3gYz:9XZyfwn2w3JHSd8|McBKEk?*XxRmg1hp;>[:`:V7o|P' );
define( 'SECURE_AUTH_KEY',  'txz(JSt}{RPheN1;e8<PICU%UWK+&Yde!-d+IG m*M@Y5#+P=6e58$iXah|H]%?U' );
define( 'LOGGED_IN_KEY',    'Btdj8!!iqLj9j+AOH)8fNH>$knx0EKpISmL!SVe} Ayh!IxswQiYWX$(&vH 5cz9' );
define( 'NONCE_KEY',        'fZb~,j9dCNAf6jXR!ZUYam^[Kx`mlz#m|P]ppJRYMz0vM9m4uc0P$JT@`Jnt/i-p' );
define( 'AUTH_SALT',        '$f}AbyUzxXNl;]2B$Cg:bhq);PKr]Tl(eDvp:AVh9N%H-z2a#|?wn-uR6<l+#_eQ' );
define( 'SECURE_AUTH_SALT', 'IzSlhFnKs+m1CS{E1$@ez/$u+];r^n [q9CkIm^$ZwZp!~4:<E0<SUS@I||8_:x7' );
define( 'LOGGED_IN_SALT',   ';M7R7lTwbI +fqztI/d_E?W:y|-6x,T7$St6u U6JA >)*=|@0 ;Xm<n8+u/5bLF' );
define( 'NONCE_SALT',       'jG>dE|2dF*k+uEjfE_>@ft7-z4&k+pl`nzAJB|.22jucScp1H1R@=[8Z.jSY(`=&' );

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

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
