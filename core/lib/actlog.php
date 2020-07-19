<?php
    /**
     * Class Actlog
     *
     * Mahan | Action Log
     *
     * @package    App\Core
     * @author     Milad Abooali <m.abooali@hotmail.com>
     * @copyright  2012 - 2020 Codebox
     * @license    http://codebox.ir/license/1_0.txt  Codebox License 1.0
     * @version    1.0.0
     */

    namespace App\Core;

    if (!defined('START')) die('__ You just find me! 😹 . . . <a href="javascript:history.back()">Go Back</a>');

    class Actlog
    {

        private $db, $path;

        /**
         * Actlog constructor.
         * @param null $path
         */
        function __construct($path=null)
        {
            $this->path = $path ?? '/';
            $this->db   = new MySQL(DB_INFO,'act_log');
        }

        public function add ($act,$rel=null,$status=null)
        {

            $data['path'] = $this->path;
            $data['user'] = $_SESSION['M']['user']['id'] ?? '0';
            $data['act'] = $act;
            $data['rel'] = $rel;
            $data['status'] = $status;

            $result = $this->db->insert($data);

            return ($result) ? $result : false;
        }

    }