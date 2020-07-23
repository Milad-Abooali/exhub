<?php
/**
* Class DataTable
*
* Mahan | DataTable generatore
*
* @package    App\Core
* @author     Milad Abooali <m.abooali@hotmail.com>
* @copyright  2012 - 2020 Codebox
* @license    http://codebox.ir/license/1_0.txt  Codebox License 1.0
* @version    1.0
*/

    namespace App\Core;

    if (!defined('START')) die('__ You just find me! 😹 . . . <a href="javascript:history.back()">Go Back</a>');



    class DataTable
    {

        private $columns,$table = 'act_log',$primaryKey = 'id';
        private $sql_details = array(
          'user' => DB_INFO['username'],
          'pass' => DB_INFO['password'],
          'db'   => DB_INFO['name'],
          'host' => DB_INFO['hostname']
        );

        /**
         * DataTable constructor.
         */
        function __construct() {

        }

        /**
         * @return false|string
         */
        public function gen () {
            return json_encode(SSP::simple( $_GET, $this->sql_details, $this->table, $this->primaryKey, $this->columns ));
        }

    }