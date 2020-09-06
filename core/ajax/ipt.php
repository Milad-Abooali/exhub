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
         * Update rVPS Status
         */
        function rvpsStatus () {
            global $actlog;
            $output = new stdClass();

            $rid = $_POST['rid'];
            $status['status'] = $_POST['status'];

            $table = 'ipt_rvps';
            $db = new MySQL(DB_INFO, $table);
            $res = $db->updateId($rid,$status);

            $text = [
              0 =>  'VM Created',
              1 =>  'OS Installed',
              2 =>  'Network Connected',
              3 =>  'Ezzz Done',
              4 =>  'Ready VPS'
            ];

            $output->res = $text[$status['status']];

            $actlog->add("Update item (ipt_rvps) to ".$output->res, $status, $rid, $res);
            echo json_encode($output);
        }

        /**
         * Delet rVPS
         */
        function rvpsDelete () {
            global $actlog;
            $output = new stdClass();

            $table = 'ipt_rvps';
            $db = new MySQL(DB_INFO, $table);

            $rid = $_POST['rid'];
            $ipid = $_POST['ipid'];

            $data = $db->selectId($rid);
            $db->deleteId($rid);

            $table = 'ipt_ips';
            $status['status'] = 1;
            $output->res = $db->updateId($ipid,$status,$table);

            $actlog->add("Delete item ($table)", $data, null, $output->res);
            echo json_encode($output);
        }

        /**
         * Save rVPS Modal
         */
        function saveRvps()
        {
            global $actlog;
            $output = new stdClass();

            $table = 'ipt_rvps';
            $db = new MySQL(DB_INFO, $table);


            $data['ip_id'] = $_POST['ip_id'];
            $data['object_id'] = $_POST['obj_id'];
            $data['network_id'] = $_POST['network_id'];
            $data['server_nid'] = $_POST['server_nid'];
            $data['plan_id'] = $_POST['plan_id'];
            $data['uuid'] = $_POST['uuid'];
            $data['os_id'] = $_POST['os'];
            $data['port'] = $_POST['port'];
            $data['ram'] = $_POST['ram'];
            $data['cpu_core'] = $_POST['cpu_core'];
            $data['hdd'] = $_POST['hdd'];
            $data['ssd'] = $_POST['ssd'];
            $data['nvme'] = $_POST['nvme'];
            $data['status'] = $_POST['status'];
            $data['note'] = $_POST['note'];
            $exist = $db->exist('ip_id="'.$data['ip_id'].'"');
            if(!$exist) {
                $res = $db->insert($data);
                $output->e = ($res) ? false : true;
                $table = 'ipt_ips';
                $status['status'] = 2;
                $db->updateId($data['ip_id'],$status,$table);
            } else {
                $output->e = 'rVPS for this IP is exist !';
            }
            $output->res = ($res) ?? false;
            $actlog->add("Add Item to ($table)", $data, ($res) ?? null, $output->res);
            echo json_encode($output);
        }

        /**
         * Get VM from host by ip id
         */
        function getVM()
        {

            $output = new stdClass();

            $name = $_POST['name'] ?? null;
            $server_nid = $_POST['server_nid'] ?? 0;

            $db = new MySQL(DB_INFO);
            $table = 'ipt_servers';
            $where = 'nid='.$server_nid;
            $server = $db->selectRow($where, null,$table);

            $host = new ESXi($server['main_ip'],'exapi','EX@api#'.$server_nid);
            $output->res = $host->getVMsByName($name)[0];

            echo json_encode($output);
        }

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

            $table = 'fin_plan_limits';
            $where = "plan_name='".$output->res['plan']['plan_name']."'";
            $output->res['limits'] = $db->selectRow($where, null,$table);

            $table = 'ipt_os';
            $plan_cpu = $output->res['plan']['cpu_core'];
            $plan_ram = $output->res['plan']['ram'];
            $where = 'min_ram<='.$plan_ram.' AND min_cpu<='.$plan_cpu;
            $output->res['os'] =  $db->select($table, $where);

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

        // VPS Page

        /**
         * New VPS Modal - Step 1
         */
        function newVPS()
        {
            $output = new stdClass();

            $db = new MySQL(DB_INFO);

            $table = 'ipt_networks';
            $where = "status=1 AND country='".$_POST['iploc']."'";
            $networks = $db->select($table, $where);
            foreach ((array) $networks as $net) $nets[$net['id']] = $net['id'];
            $output->res['nets'] = implode("','",$nets);
            $table = 'ipt_rvps';
            $where = 'plan_id='.$_POST['plan']." AND network_id IN ('".$output->res['nets']."')";
            $output->res['rvps'] = $db->selectRow($where, null,$table);
            $output->e = ($output->res['rvps']) ? false : true;
            if ($output->res['rvps']) {

                $table = 'ipt_servers';
                $where = 'status=1 AND nid='.$output->res['rvps']['server_nid'];
                $output->res['rvps']['server'] = $db->selectRow($where, null,$table);

                $table ='ipt_networks';
                $output->res['rvps']['network'] = $db->selectId($output->res['rvps']['network_id'],'*',$table);

                $table ='ipt_ips';
                $output->res['rvps']['ip'] = $db->selectId($output->res['rvps']['ip_id'],'*',$table);

                $table ='ipt_os';
                $output->res['rvps']['os'] = $db->selectId($output->res['rvps']['os_id'],'*',$table);

                $table ='fin_plans';
                $output->res['rvps']['plan'] = $db->selectId($output->res['rvps']['plan_id'],'*',$table);

                $table = 'fin_plan_limits';
                $where = "plan_name='".$output->res['rvps']['plan']['plan_name']."'";
                $output->res['rvps']['limits'] = $db->selectRow($where, null,$table);
            }
            echo json_encode($output);
        }


        /**
         * Add IP MOdal
         */
//        function getNetworkVPS()
//        {
//            $db = new MySQL(DB_INFO);
//            $nets = $db->select('ipt_networks', 'status=1 AND server_nid='.$_POST['server_nid']);
//            $ips = array();
//            foreach ((array) $nets as $net) {
//                $table = 'ipt_ips';
//                $where = 'status=1 AND network_id='.$net['id'];
//                $ips[] = $db->selectRow($where,null,$table);
//            }
//            $output = new stdClass();
//            $output->e = false;
//            $output->res['nets'] = $nets;
//            $output->res['ips'] = $ips;
//            echo json_encode($output);
//        }


    }