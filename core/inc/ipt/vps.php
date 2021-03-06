<?php

    namespace App\Core;
    global $user;

    $db = new MySQL(DB_INFO);
    $this->data['vps_pending'] = $db->select('ipt_vps','status=0');
    if ($this->data['vps_pending']) {
        foreach ($this->data['vps_pending'] as $k => $v) {
            $this->data['vps_pending'][$k]['ip'] = $db->selectId($v['ip_id'],'*','ipt_ips');
            $this->data['vps_pending'][$k]['network'] = $db->selectId($v['network_id'],'*','ipt_networks');
            $this->data['vps_pending'][$k]['plan'] = $db->selectId($v['plan_id'],'*','fin_plans');
            $this->data['vps_pending'][$k]['os'] = $db->selectId($v['os_id'],'*','ipt_os');
            $where = 'status=1 AND nid='.$v['server_nid'];
            $this->data['vps_pending'][$k]['server'] = $db->selectRow($where, null,'ipt_servers');
        }
    }

    $db = new MySQL(DB_INFO,'ipt_servers');
    $this->data['servers'] = $db->selectAll();

    $this->data['status_text'] = [
      0 =>  'Pending',
      1 =>  'Active',
      2 =>  'Completed',
      3 =>  'Suspended',
      4 =>  'Terminated',
      5 =>  'Cancelled',
      6 =>  'Fraud'
    ];

    $this->data['status_color'] = [
      0 =>  'warning text-dark',
      1 =>  'success text-dark',
      2 =>  'light text-light',
      3 =>  'danger text-light',
      4 =>  'danger text-light',
      5 =>  'dark text-light',
      6 =>  'danger text-light',
    ];

    // New VPS
    $this->data['ip_loc'] = $db->select('ipt_networks', 'status=1','country',null,null,'country');

