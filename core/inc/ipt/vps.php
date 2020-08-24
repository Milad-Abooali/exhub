<?php

    namespace App\Core;
    global $user;


    $db = new MySQL(DB_INFO,'ipt_rvps');
    $this->data['rvps'] = $db->selectAll();

    if ($this->data['rvps']) {
        foreach ($this->data['rvps'] as $k => $rvps) {
            $this->data['rvps'][$k]['ip'] = $db->selectId($rvps['ip_id'],'*','ipt_ips');
            $this->data['rvps'][$k]['network'] = $db->selectId($rvps['network_id'],'*','ipt_networks');
            $this->data['rvps'][$k]['plan'] = $db->selectId($rvps['plan_id'],'*','fin_plans');
            $this->data['rvps'][$k]['os'] = $db->selectId($rvps['os_id'],'*','ipt_os');
            $where = 'nid='.$this->data['rvps'][$k]['server_nid'];
            $this->data['rvps'][$k]['server'] = $db->selectRow($where,null,'ipt_servers');
        }
    }

    $this->data['status_text'] = [
      0 =>  'VM Created',
      1 =>  'OS Installed',
      2 =>  'Network Connected',
      3 =>  'Ezzz Done',
      4 =>  'Ready VPS'
    ];

    $this->data['status_color'] = [
      0 =>  'light text-dark',
      1 =>  'warning text-dark',
      2 =>  'info text-light',
      3 =>  'primary text-light',
      4 =>  'success text-light'
    ];

    // New rVPS

    $this->data['plans'] = $db->select('fin_plans', "service_type='VPS'",'id, plan_name',null,null,'plan_name');
    $this->data['ip_loc'] = $db->select('ipt_networks', 'status=1','country',null,null,'country');

