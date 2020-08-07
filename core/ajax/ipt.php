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
            $base_ip = $_POST['ip1'].'.'.$_POST['ip2'].'.'.$_POST['ip3'].'.';
            $data['mac'] = $_POST['mac'];
            $data['network_id'] = $_POST['network_id'];
            $data['country'] = $_POST['country'];
            $data['flag'] = $_POST['flag'];
            $data['ir_access'] = $_POST['ir_access'] ?? 0;
            $data['ir_block'] = $_POST['ir_block'] ?? 0;
            $data['abuse'] = $_POST['abuse'] ?? 0;
            $data['owner'] = $_POST['owner'];
            $data['note'] = $_POST['note'];
            $data['status'] = 1;
            $output = new stdClass();
            global $actlog;
            if ($_POST['ip5']>$_POST['ip4']) {
                while ($_POST['ip5']>=$_POST['ip4']) {
                    $ip = $base_ip.$_POST['ip4'];
                    $data['ip'] = $ip;
                    if ($db->exist("ip='$ip'")) {
                        $output->e = true;
                    } else {
                        $res = $db->insert($data);
                        $actlog->add("Add IP ($ip)", null, ($res) ?? null, !$output->e);
                    }
                    $output->res = true;
                    $_POST['ip4']++;
                }
                echo json_encode($output);
            } else {
                $ip = $base_ip.$_POST['ip4'];
                $data['ip'] = $ip;
                if ($db->exist("ip='$ip'")) {
                    $res = false;
                } else {
                    $res = $db->insert($data);
                }
                $output->e = ($res) ? false : true;
                $output->res = ($res) ?? false;
                $actlog->add("Add Item to ($table)", $data, ($res) ?? null, $output->res);
                echo json_encode($output);
            }
        }

    }