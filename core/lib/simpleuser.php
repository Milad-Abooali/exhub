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
        private $db;

        /**
         * SimpleUser constructor.
         */
        function __construct() {
            $this->db = new MySQL(null,'user_list');
        }

        /**
         * Register user
         * @param string $username
         * @return bool
         */
        public function check($username) {
            if ($this->db->exist("username='$username'")) {
                return false;
            } else {
                return true;
            }
        }
        /**
         * Register user
         */
        public function add($data) {


            $data['password'] = password_hash($data['password'], PASSWORD_ARGON2I);
            $data['group_id'] = $data['group_id'] ?? 0;
            $data['data']     = json_encode($data['data'] ?? array());
            $result = $this->db->insert($data);
            if ($result) {
                M::aLog('SimpleUser',"Add new user, User ID: $result");
            } else {
                M::aLog('SimpleUser',"Add new user.",1);
            }
        }




    }