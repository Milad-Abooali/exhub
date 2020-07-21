<?php
/**
 * Class Core
 *
 * Mahan | Ajax Class Core
 *
 * @package    App\Core
 * @author     Milad Abooali <m.abooali@hotmail.com>
 * @copyright  2012 - 2020 Codebox
 * @license    http://codebox.ir/license/1_0.txt  Codebox License 1.0
 * @version    1.0.0
 */

    namespace App\Core;

    if (!defined('START')) die('__ You just find me! 😹 . . . <a href="javascript:history.back()">Go Back</a>');

    use stdClass;

    function def () {
        $output = new stdClass();
        $output->e = false;
        $output->res = $_POST;
        echo json_encode($output);
    }

    /**
     * Insert to database
     */
    function dbInsert () {
        $table = array_shift($_POST);
        $db = new MySQL(DB_INFO,$table);
        $res = $db->insert($_POST);
        $output = new stdClass();
        $output->e = ($res) ? false : true;
        $output->res = ($res) ?? false;
        global $actlog;
        $actlog->add("Add Item to ($table)",$_POST,($res) ?? null,(isset($res))?1:0);
        echo json_encode($output);
    }