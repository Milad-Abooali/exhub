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

    $page['upon']   = 'core';
    /** @var array $page */
    switch ($page['vid']) {

        case "login":
            $page['view']   = "login";
            break;

        case "ipt":
            (USER_ACCESS['ipt']) ?: die ('Access Denid !');
            $page['vid']  = 'ipt/'.array_shift($page['data']);
            switch ($page['vid']) {
                case "ipt/servers":
                    (USER_ACCESS['staff']) ?: die ('Access Denid !');
                    $page['inc']    = 'ipt/servers';
                    $page['view']   = "ipt/servers";
                    break;
                case "ipt/networks":
                    (USER_ACCESS['staff']) ?: die ('Access Denid !');
                    $page['inc']    = 'ipt/networks';
                    $page['view']   = "ipt/networks";
                    break;
                case "ipt/ips":
                    (USER_ACCESS['staff']) ?: die ('Access Denid !');
                    $page['inc']    = 'ipt/ips';
                    $page['view']   = "ipt/ips";
                    break;
                case "ipt/rVPS":
                    (USER_ACCESS['staff']) ?: die ('Access Denid !');
                    $page['inc']    = 'ipt/rvps';
                    $page['view']   = "ipt/rvps";
                    break;
                case "ipt/vps":
                    (USER_ACCESS['staff']) ?: die ('Access Denid !');
                    $page['inc']    = 'ipt/vps';
                    $page['view']   = "ipt/vps";
                    break;
                case "ipt/":
                default:
                    $page['view']   = "404";
            }
            break;
        case "seo":
            (USER_ACCESS['seo']) ?: die ('Access Denid !');
            $page['vid']  = 'seo/'.array_shift($page['data']);
            switch ($page['vid']) {
                case "seo/keywords":
                    (USER_ACCESS['admin']) ?: die ('Access Denid !');
                    $page['inc']    = 'seo/keywords';
                    $page['view']   = "seo/keywords";
                    break;
                case "seo/fis":
                    $page['inc']    = 'seo/fis';
                    $page['view']   = "seo/fis";
                    break;
                case "seo/":
                default:
                    $page['view']   = "404";
            }
            break;
        case "admin":
            (USER_ACCESS['admin']) ?: die ('Access Denid !');
            $page['vid']  = 'admin/'.array_shift($page['data']);
            switch ($page['vid']) {
                case "admin/logs":
                    $page['inc']    = 'admin/logs';
                    $page['view']   = "admin/logs";
                    break;
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