<?php

    namespace App\Core;
    global $user;

    $db = new MySQL(DB_INFO,'seo_keywords');
    $this->data['keywords'] = $db->selectAll(null,'priority');
    $this->data['keywords_count'] = is_array($this->data['keywords']) ? count($this->data['keywords']) : 0;
