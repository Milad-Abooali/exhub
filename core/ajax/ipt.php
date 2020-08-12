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
         * Add New rVPS Modal
         */
        function addRvps()
        {
            $output = new stdClass();

            $db = new MySQL(DB_INFO);
            $table = 'ipt_networks';
            $where = 'status=1 AND server_nid='.$_POST['server'];
            $networks = $db->select($table, $where);

            $table = 'ipt_servers';
            $where = 'status=1 AND nid='.$_POST['server'];
            $output->res['server'] = $db->selectRow($where, null,$table);

            $table = 'fin_plans';
            $output->res['plan'] = $db->selectId($_POST['plan'],'*',$table);

            $ip = false;
            foreach ($networks as $network) {
                $output->res['network'] = $network;
                $table = 'ipt_ips';
                $where = 'status=1 AND network_id='.$network['id'];
                $order = 'network_id';
                $ip = $db->selectRow($where, $order,$table);
                if ($ip) break;
            }
            $output->res['ip'] = $ip;
            $output->e = ($ip) ? false : true;
            echo json_encode($output);
        }

        /**
         * Get Networks Location
         */
        function getNetworksLoc()
        {
            $db = new MySQL(DB_INFO);
            $locs = $db->select('ipt_networks', 'status=1 AND server_nid='.$_POST['server'],'country',null,null,'country');
            $output = new stdClass();
            $output->e = false;
            $output->res = $locs;
            echo json_encode($output);
        }

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