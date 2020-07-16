<?php
/**
 * Routing
 *
 * Mahan |  Router
 *
 * @package    App\Core
 * @author     Milad Abooali <m.abooali@hotmail.com>
 * @copyright  2012 - 2020 Codebox
 * @license    http://codebox.ir/license/1_0.txt  Codebox License 1.0
 * @version    1.0.0
 */

    namespace App\Core;

    if (!defined('START')) die('__ You just find me! 😹 . . . <a href="javascript:history.back()">Go Back</a>');

    /** @var array $page */
    switch ($page['vid']) {

        case "admin":
            $page['vid']  = 'admin/'.array_shift($page['data']);
            $page['upon']   = 'admin';
            switch ($page['vid']) {
                case "admin/users":
                    $page['inc']    = 'admin/users';
                    $page['view']   = "admin/users";
                    break;
                case "admin/dashboard":
                case "admin/":
                default:
                $page['inc']    = 'admin';
                $page['view']   = "admin/dashboard";
            }
            break;

        case null:
        case "":    // Site Index/root
            $page['cache']  = false;
            $page['vid']    = 'home';
            $page['inc']    = 'home';
            $page['view']   = 'home';
            break;

        default:    // Not Found
            $page['cache']      = false;        // Page Cache Overwrite
            $page['vid']        = false;        // Page View ID/Name
            $page['upon']       = null;         // Page Upon File
            $page['inc']        = null;         // Page Inc File
            $page['view']       = 'error/404';  // Page View File
    }