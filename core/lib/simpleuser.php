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

        public $ERROR;
        private $db, $user=array();

        /**
         * SimpleUser constructor.
         */
        function __construct() {
            $this->db = new MySQL(DB_INFO,'user_list');
        }

        /**
         * Get All users
         * @return array
         */
        public function getAll() {
            return $this->db->select() ?? array();
        }

        /**
         * Get user Groups
         * @param int $id
         * @return array|bool
         */
        public function getGroups($id) {
            $id = intval($id);
            return $this->db->select('user_groups',"user_id=$id") ?? array();
        }


        /**
         * Set User Groups
         * @param array $id
         * @param array $data
         * @return array|bool
         */
        public function setGroups($id,$data) {
            $id = intval($id);
            return $this->db->updateAny($data,"user_groups","user_id=$id") ?? false;
        }

        /**
         * Check username
         * @param string $username
         * @return bool
         */
        public function getUser($username) {
            $username = $this->db->escape($username);
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
            if ($this->getUser($data['username'])) {
                $this->ERROR = 'Username already in use !';
                return false;
            }
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ["cost" => 8]);
            $data['data']     = json_encode($data['data'] ?? array());
            $result = $this->db->insert($data);
            (!$result) ?: $this->db->insert(array('user_id'=>$result),'user_groups');
            return ($result) ? $result : false;
        }

        /**
         * Upate User Password.
         * @param int $id
         * @param string $password
         * @return bool|int|\mysqli_result|string|null
         */
        public function updatePass($id, $password) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT, ["cost" => 8]);
            return $this->db->updateId($id, $data);
        }

        /**
         * Upate User.
         * @param int $id
         * @param array $data
         * @return bool|int|\mysqli_result|string|null
         */
        public function update($id, $data) {
            return $this->db->updateId($id, $data);
        }

    }

