<?php
/**
 * Class Simple User
 *
 * Mahan | Core simple user management
 *
 * @package    App\Core
 * @author     Milad Abooali <m.abooali@hotmail.com>
 * @copyright  2012 - 2020 Codebox
 * @license    http://codebox.ir/license/1_0.txt  Codebox License 1.0
 * @version    1.0.0
 */

    namespace App\Core;

    if (!defined('START')) die('__ You just find me! 😹 . . . <a href="javascript:history.back()">Go Back</a>');

    class SimpleUser
    {

        public $user_id;
        private $db,$user=array();

        /**
         * SimpleUser constructor.
         */
        function __construct() {
            $this->db = new MySQL(DB_INFO,'user_list');
        }

        /**
         * Check username
         * @param string $username
         * @return bool
         */
        public function getUser($username) {
            $this->user = $this->db->selectRow("username='$username'");
            return ($this->user) ? true : false;
        }

        /**
         * Check Password
         * @param $password
         * @param $username
         * @return bool
         */
        public function checkPass($password) {
            return (password_verify($password,$this->user['password'])) ? true : false;
        }

        /**
         * Login user
         * @param $password
         * @param $username
         * @return bool
         */
        public function login($username, $password) {
            if ($this->getUser($username)) {
                if ($this->checkPass($password)) {
                    $_SESSION['M']['user'] = $this->user;
                    return true;
                } else {
                    $_SESSION['M']['user'] = array();
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Logout user
         * @return bool
         */
        public function logout() {
            $_SESSION['M']['user'] = array();
            session_unset();
            session_destroy();
            return true;
        }

        /**
         * Register user
         * @param array $data
         * @return bool|int|\mysqli_result|string
         */
        public function add($data) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ["cost" => 8]);
            $data['group_id'] = $data['group_id'] ?? 0;
            $data['data']     = json_encode($data['data'] ?? array());
            $result = $this->db->insert($data);
            if ($result) {
                M::aLog('SimpleUser',"Add new user, User ID: $result");
                return $result;
            } else {
                M::aLog('SimpleUser',"Add new user.",1);
                return false;
            }
        }

    }

