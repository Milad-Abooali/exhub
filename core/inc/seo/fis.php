<?php

    namespace App\Core;
    global $user;

    $db = new MySQL(DB_INFO,'seo_keywords');
    $this->data['keywords'] = $db->select(null,'fis=1','*',null,'priority');

    foreach ($this->data['keywords'] as $k => $item) {
        $this->data['keywords'][$k]['ratio'] = 0.01;
        $where = "keyword_id=".$item['id'];
        $where .= " AND user_id=".$_SESSION['M']['user']['id'];
        $done = $db->count($where,date('Y-m-d'),date('Y-m-d', strtotime( '-1 days' )) ,'seo_fis');
        if ($done) {
            $this->data['keywords'][$k]['ratio'] += ($done*0.09);
        }

        $engins = ['Yahoo','Yandex','Google','Bing','Ask','AOL','Baidu','Yooz','Parsijoo','Parseek','Rismoon'];
        foreach ($engins as $engin) {
            $where_p = $where." AND engin='$engin'";
            $this->data['keywords'][$k][$engin] = $db->exist($where_p,date('Y-m-d'),date('Y-m-d', strtotime( '-1 days' )) ,'seo_fis');
         }
    }
    M::console($this->data['keywords']);
