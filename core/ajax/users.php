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
     * set User Groups
     */
    function setGroups() {
        global $user;
        $output = new stdClass();
        $id = $_POST['rid'];
        $groups['admin']= ($_POST['admin'] ?? 0) ? 1 : 0;
        $groups['staff']= ($_POST['staff'] ?? 0) ? 1 : 0;
        $groups['ipt']  = ($_POST['ipt'] ?? 0) ? 1 : 0;
        $groups['fis']  = ($_POST['fis'] ?? 0) ? 1 : 0;
        $res = $user->setGroups($id,$groups);
        $output->e = ($res) ? false : true;
        $output->res = $user->ERROR;
        global $actlog;
        $actlog->add("Set groups [".json_encode($groups)."] for user ($id)", $id,($res)?1:0);
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
        $output->res = $user->ERROR ?? $res[0];
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
        global $actlog;
        $actlog->add("Set status [".$update['status']."] for user ($id)", $id,($res)?1:0);
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
        global $actlog;
        $actlog->add("Reset password for user ($id)", $id, ($res)?1:0);
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
        global $actlog;
        $actlog->add("Add new user ($res)", $res, ($res)?1:0);
        echo json_encode($output);
    }


    /**
     * Login User
     */
    function login () {
        global $user;
        $output = new stdClass();
        $res = $user->login($_POST['username'],$_POST['password']);
        $output->e = ($res) ? false : true;
        $output->res = false;
        global $actlog;
        $actlog->add("Login [".json_encode($_POST)."]", $_SESSION['M']['user']['id'] ?? null, ($res)?1:0);
        echo json_encode($output);
    }

    /**
    * Logout User
    */
    function logout () {
        global $user
        global $actlog;
        $actlog->add("Logout user (".$_SESSION['M']['user']['id'].")", $_SESSION['M']['user']['id'], ($res)?1:0);
        $output = new stdClass();
        $res = $user->logout();
        $output->e = ($res) ? false : true;
        $output->res = false;
        echo json_encode($output);
    }
