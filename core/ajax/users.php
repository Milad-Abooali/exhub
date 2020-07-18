<?php
    /**
     * Ajax users
     *
     * Mahan | Ajax users
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
     * get User Groups
     */
    function getGroups() {
        global $user;
        $output = new stdClass();
        $id = ($_POST['rid']) ?? die();
        $res = $user->getGroups($id);
        $output->e = ($res) ? false : true;
        $output->res = $user->ERROR ?? $res;
        echo json_encode($output);
    }

    /**
     * Update User
     */
    function updateStatus() {
        global $user;
        $output = new stdClass();
        $id = ($_POST['rid']) ?? die();
        $update['status'] = ($_POST['status']) ? 1 : 0;
        $res = $user->update($id, $update);
        $output->e = ($res) ? false : true;
        $output->res = $user->ERROR ?? true;
        echo json_encode($output);
    }

    /**
     * Update User Password
     */
    function resetPass() {
        global $user;
        $output = new stdClass();
        $id = ($_POST['rid']) ?? die();
        $seed = str_split('abdefghjmnqrty'
                                .'ABDEFGHJLMNQRTY'
                                .'123456789!@#$%^&*()');
        shuffle($seed);
        $password = '';
        foreach (array_rand($seed, 7) as $k) $password .= $seed[$k];
        $res = $user->updatePass($id, $password);
        $output->e = ($res) ? false : true;
        $output->res = $user->ERROR ?? $password;
        echo json_encode($output);
    }

    /**
     * Add New User
     */
    function add () {
        global $user;
        $output = new stdClass();
        $res = $user->add($_POST);
        $output->e = ($res) ? false : true;
        $output->res = $user->ERROR;
        echo json_encode($output);
    }