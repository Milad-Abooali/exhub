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

    if ($_SESSION['M']['user'] ?? false) {

        /**
         * Set keywords priority
         */
        function setPrio()
        {
            $db = new MySQL(DB_INFO, 'seo_keywords');
            $output = new stdClass();
            $id = ($_POST['rid']) ?? die();
            $update['priority'] = ($_POST['prio']) ?? 0;
            $res = $db->updateId($id, $update);
            $output->e = ($res) ? false : true;
            $output->res = $user->ERROR ?? true;
            global $actlog;
            $actlog->add("Set Priority for keyword ($id)", $update['priority'], $id, ($output->res) ? 1 : 0);
            echo json_encode($output);
        }

        /**
         * Set keywords fis
         */
        function setFis()
        {
            $db = new MySQL(DB_INFO, 'seo_keywords');
            $output = new stdClass();
            $id = ($_POST['rid']) ?? die();
            $update['fis'] = ($_POST['fis']) ? 1 : 0;
            $res = $db->updateId($id, $update);
            $output->e = ($res) ? false : true;
            $output->res = $user->ERROR ?? true;
            global $actlog;
            $actlog->add("Set Fis for keyword ($id)", $update['fis'], $id, ($output->res) ? 1 : 0);
            echo json_encode($output);
        }

        /**
         * Set Add fis
         */
        function addFis()
        {
            $db = new MySQL(DB_INFO, 'seo_fis');
            $_POST['user_id'] = $_SESSION['M']['user']['id'];
            $res = $db->insert($_POST);
            $output = new stdClass();
            $output->e = ($res) ? false : true;
            $output->res = ($res) ?? false;
            global $actlog;
            $actlog->add("Fis on " . $_POST['engin'], null, ($_POST['keyword_id']) ?? null, ($output->res) ? 1 : 0);
            echo json_encode($output);
        }

    }