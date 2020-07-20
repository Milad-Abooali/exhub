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

        private $db, $path, $class_act;

        /**
         * Actlog constructor.
         * @param null $path
         * @param null $class_act
         */
        function __construct($path=null,$class_act=null)
        {
            $this->path = $path ?? '';
            $this->class_act = $class_act ?? 'core/def';
            $this->db   = new MySQL(DB_INFO,'act_log');
        }

        /**
         * Add Action Log
         * @param $act
         * @param null|string $actdata
         * @param null|string $rel
         * @param null|int $status
         * @return bool|int|\mysqli_result|string
         */
        public function add($act,$actdata=null,$rel=null,$status=null)
        {
            $data['call_path'] = $this->path;
            $data['class_act'] = $this->class_act;
            $data['user'] = $_SESSION['M']['user']['id'] ?? '0';
            $data['data'] = ($actdata) ? json_encode($actdata) : null;
            $data['act'] = $act;
            $data['rel'] = $rel;
            $data['status'] = $status;
            $result = $this->db->insert($data);
            return ($result) ? true : false;
        }

        /**
         * Show Action logs for path
         * @param $call_path
         * @param null $count
         * @return array|bool
         */
        public function show($call_path=null, $count=25)
        {
            $call_path = $this->db->escape($call_path);
            $where = ($call_path) ? "call_path='$call_path'" : null;
            $result = $this->db->select(null, $where,'*',$count,'id DESC');
            return ($result) ? $result : array();
        }
    }