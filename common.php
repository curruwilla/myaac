<?php

if (version_compare(phpversion(), '7.4', '<')) {
    die('PHP version 7.4 or higher is required.');
}

const MYAAC = true;
const MYAAC_VERSION = '0.8.6';
const DATABASE_VERSION = 32;
const TABLE_PREFIX = 'myaac_';

define('START_TIME', microtime(true));
define('MYAAC_OS', stripos(PHP_OS, 'WIN') === 0 ? 'WINDOWS' : (strtoupper(PHP_OS) === 'DARWIN' ? 'MAC' : 'LINUX'));
define('IS_CLI', in_array(php_sapi_name(), ['cli', 'phpdb']));

// account flags
const FLAG_ADMIN = 1;
const FLAG_SUPER_ADMIN = 2;
const FLAG_CONTENT_PAGES = 4;
const FLAG_CONTENT_MAILER = 8;
const FLAG_CONTENT_NEWS = 16;
const FLAG_CONTENT_FORUM = 32;
const FLAG_CONTENT_COMMANDS = 64;
const FLAG_CONTENT_SPELLS = 128;
const FLAG_CONTENT_MONSTERS = 256;
const FLAG_CONTENT_GALLERY = 512;
const FLAG_CONTENT_VIDEOS = 1024;
const FLAG_CONTENT_FAQ = 2048;
const FLAG_CONTENT_MENUS = 4096;
const FLAG_CONTENT_PLAYERS = 8192;

// news
const NEWS = 1;
const TICKER = 2;
const ARTICLE = 3;

// directories
const BASE = __DIR__ . '/';
const ADMIN = BASE . 'admin/';
const SYSTEM = BASE . 'system/';
const CACHE = SYSTEM . 'cache/';
const LOCALE = SYSTEM . 'locale/';
const LIBS = SYSTEM . 'libs/';
const LOGS = SYSTEM . 'logs/';
const PAGES = SYSTEM . 'pages/';
const PLUGINS = BASE . 'plugins/';
const TEMPLATES = BASE . 'templates/';
const TOOLS = BASE . 'tools/';

// menu categories
const MENU_CATEGORY_NEWS = 1;
const MENU_CATEGORY_ACCOUNT = 2;
const MENU_CATEGORY_COMMUNITY = 3;
const MENU_CATEGORY_FORUM = 4;
const MENU_CATEGORY_LIBRARY = 5;
const MENU_CATEGORY_SHOP = 6;
const MENU_CATEGORY_CHARBAAZAR = 7;

// otserv versions
const OTSERV = 1;
const OTSERV_06 = 2;
const OTSERV_FIRST = OTSERV;
const OTSERV_LAST = OTSERV_06;
const TFS_02 = 3;
const TFS_03 = 4;
const TFS_FIRST = TFS_02;
const TFS_LAST = TFS_03;

session_save_path(SYSTEM . 'php_sessions');
session_start();

// basedir
$basedir = '';
$tmp = explode('/', $_SERVER['SCRIPT_NAME']);
$size = count($tmp) - 1;
for ($i = 1; $i < $size; $i++) {
    $basedir .= '/' . $tmp[$i];
}

$basedir = str_replace(array('/admin', '/install'), '', $basedir);
define('BASE_DIR', $basedir);

if (!IS_CLI) {
    if (isset($_SERVER['HTTP_HOST'][0])) {
        $baseHost = $_SERVER['HTTP_HOST'];
    } else {
        if (isset($_SERVER['SERVER_NAME'][0])) {
            $baseHost = $_SERVER['SERVER_NAME'];
        } else {
            $baseHost = $_SERVER['SERVER_ADDR'];
        }
    }
    
    define('SERVER_URL', 'http' . (isset($_SERVER['HTTPS'][0]) && strtolower($_SERVER['HTTPS']) === 'on' ? 's' : '') . '://' . $baseHost);
    define('BASE_URL', SERVER_URL . BASE_DIR . '/');
    define('ADMIN_URL', SERVER_URL . BASE_DIR . '/admin/');
    
    require SYSTEM . 'exception.php';
}

require SYSTEM . 'autoload.php';
