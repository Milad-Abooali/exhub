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
            $where = 'nid='.$this->data['rvps'][$k]['server_nid'];
            $this->data['rvps'][$k]['server'] = $db->selectRow($where,null,'ipt_servers');
        }
    }

    $this->data['status_text'] = [
      0 =>  'VM Created',
      1 =>  'OS Installed',
      2 =>  'Network Connected',
      3 =>  'Ready VPS'
    ];

    $this->data['status_color'] = [
      0 =>  'muted',
      1 =>  'light',
      2 =>  'primary',
      3 =>  'success'
    ];

    // New rVPS

    $this->data['plans'] = $db->select('fin_plans', "service_type='VPS'",'id, plan_name',null,null,'plan_name');
    $this->data['servers'] = $db->select('ipt_servers', 'status=1','nid');
    $this->data['ip_loc'] = $db->select('ipt_networks', 'status=1','country',null,null,'country');

    // EXSi test

    $host = new ESXi('178.216.251.67','root','CB@2019#r28');

    M::console($host->getVMs());