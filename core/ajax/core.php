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

    if ($_SESSION['M']['user']) {

        /**
         * Get Page Logs
         */
        function getAllLogs()
        {
            $columns = array(
              array('db' => 'id', 'dt' => 0),
              array('db' => 'call_path', 'dt' => 1),
              array('db' => 'class_act', 'dt' => 2),
              array(
                'db' => 'user',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    return getUsernameByID($d);
                }
              ),
              array('db' => 'act', 'dt' => 4),
              array(
                'db' => 'data',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    if ($d) {
                        $data = "data-logdata='$d'";
                        return '<button class="btn btn-outline-info btn-xs doM-logdata float-right"' . $data . '>Console</button>';
                    } else {
                        return null;
                    }
                }
              ),
              array('db' => 'rel', 'dt' => 6),
              array(
                'db' => 'status',
                'dt' => 7,
                'formatter' => function ($d, $row) {
                    $status = ($d) ? 'text-success">OK' : 'text-danger">Error';
                    return '<small class="' . $status . '</small>';
                }
              ),
              array('db' => 'timestamp', 'dt' => 8)
            );
            $dataTable = new DataTable($columns, null);
            echo $dataTable->gen();
        }

        /**
         * Get Page Logs
         */
        function getPathLogs()
        {
            global $call_path;
            $where = "call_path='$call_path'";
            $columns = array(
              array('db' => 'id', 'dt' => 0),
              array(
                'db' => 'user',
                'dt' => 1,
                'formatter' => function ($d, $row) {
                    return getUsernameByID($d);
                }
              ),
              array('db' => 'act', 'dt' => 2),
              array(
                'db' => 'data',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    if ($d) {
                        $data = "data-logdata='$d'";
                        return '<button class="btn btn-outline-info btn-xs doM-logdata float-right"' . $data . '>Console</button>';
                    } else {
                        return null;
                    }
                }
              ),
              array('db' => 'rel', 'dt' => 4),
              array(
                'db' => 'status',
                'dt' => 5,
                'formatter' => function ($d, $row) {
                    $status = ($d) ? 'text-success">OK' : 'text-danger">Error';
                    return '<small class="' . $status . '</small>';
                }
              ),
              array('db' => 'timestamp', 'dt' => 6)
            );
            $dataTable = new DataTable($columns, $where);
            echo $dataTable->gen();
        }

        /**
         * Insert to database
         */
        function dbInsert()
        {
            $table = array_shift($_POST);
            $db = new MySQL(DB_INFO, $table);
            $res = $db->insert($_POST);
            $output = new stdClass();
            $output->e = ($res) ? false : true;
            $output->res = ($res) ?? false;
            global $actlog;
            $actlog->add("Add Item to ($table)", $_POST, ($res) ?? null, (isset($res)) ? 1 : 0);
            echo json_encode($output);
        }

        /**
         * Delete from database
         */
        function dbDelete()
        {
            $table = array_shift($_POST);
            $id = array_shift($_POST) ?? false;
            $db = new MySQL(DB_INFO, $table);
            $res = $db->deleteId($id);
            $output = new stdClass();
            $output->e = ($res) ? false : true;
            $output->res = ($res) ?? false;
            global $actlog;
            $actlog->add("Delete Item from ($table)", null, ($id) ?? null, (isset($res)) ? 1 : 0);
            echo json_encode($output);
        }

    }