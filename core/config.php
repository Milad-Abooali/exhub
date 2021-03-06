<?php
/**
 * Config
 *
 * Mahan | Configuration
 *
 * @package    App\Core
 * @author     Milad Abooali <m.abooali@hotmail.com>
 * @copyright  2012 - 2020 Codebox
 * @license    http://codebox.ir/license/1_0.txt  Codebox License 1.0
 * @version    1.0.0
 */

    namespace App\Core;

    if (!defined('START')) die('__ You just find me! 😹 . . . <a href="javascript:history.back()">Go Back</a>');

    /**
 * Debug
 */
    error_reporting(E_ALL);
    define("LOGGER", true);  // Active Logger
    define("LOG", [
      "core"          => true,
      "loader"        => false,
      "database"      => true,
      "language"      => false,
      "view"          => false
    ]);
    define("LOG_FORCE", false);  // 1 Force to Show Log - 0: Need add '&mLog' to URL

/**
 * App Settings
 */
    define("APP_POR", "http://");
    define("APP_URL", APP_POR."localhost/git/ex/");
    define("APP_ROOT", $_SERVER['DOCUMENT_ROOT'].'git/ex/');

/**
 * Static files - CDN
 */
    define("SITE", [
      "lang"      => "FA", // null (IP Base) - Lang 2 char
      "them"      => "termeh"
    ]);

/**
 * Static files - CDN
 */
    define("CDN", APP_URL."cdn/");
    define("CSS", CDN."css/");
    define("IMG", CDN."img/");
    define("JS", CDN."js/");
    define("ICO", CDN."ico/");

/**
 * Database information
 */
    define("DB_INFO", [
      "hostname"  => "localhost",
      "port"      => 3306,
      "name"      => "ex_1",
      "prefix"    => '',
      "username"  => "root",
      "password"  => "root"
    ]);

/**
 * CSRF token & session expiration
 */
define('SESSION_TIMEOUT', 1800); // Seconds

/**
 * Cache settings
 */
    define("CACHE", [
      "enable"    => 0, // 0 (Off) - 1 (On)
      "minify"    => 1, // 0 (Yes) - 1 (No)
      "expire"    => 3600 // Seconds
    ]);

