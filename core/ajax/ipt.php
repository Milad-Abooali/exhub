<?php
    /**
     * Class IPT
     *
     * Mahan | Ajax Class IPT
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
         * Insert IPs
         */
        function insertIPs()
        {
            $table = 'ipt_ips';
            $db = new MySQL(DB_INFO, $table);

            $data['ip'] = $_POST['ip1'].'.'.$_POST['ip2'].'.'.$_POST['ip3'].'.';
            $data['mac'] = $_POST['mac'];
            $data['network_id'] = $_POST['network_id'];
            $data['country'] = $_POST['country'];
            $data['flag'] = $_POST['flag'];
            $data['ir_access'] = $_POST['ir_access'];
            $data['ir_block'] = $_POST['ir_block'];
            $data['abuse'] = $_POST['abuse'];
            $data['owner'] = $_POST['owner'];
            $data['note'] = $_POST['note'];
            $data['status'] = 1;

            if ($_POST['ip5']>$_POST['ip4']) {
                $i = $_POST['ip5']-$_POST['ip4'];
                while ($i>0) {

                }
            } else {
                $ip = $data['ip'] .= $_POST['ip4'];
                if ($db->exist("ip='$ip'")) {
                    $res = false;
                } else {
                    $res = $db->insert($data);
                }
                $output = new stdClass();
                $output->e = ($res) ? false : true;
                $output->res = ($res) ?? false;
                global $actlog;
                $actlog->add("Add Item to ($table)", $data, ($res) ?? null, (isset($res)) ? 1 : 0);
                echo json_encode($output);
            }
        }

    }