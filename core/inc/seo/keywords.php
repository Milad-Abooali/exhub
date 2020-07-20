<?php

    namespace App\Core;
    global $user;
    $this->data['users'] = $user->getAll();
    $this->data['user_count'] = is_array($this->data['users']) ? count($this->data['users']) : 0;

    $db = new MySQL(DB_INFO,'seo_keywords');
    $this->data['keywords'] = $db->selectAll(null,'priority');
    $this->data['keywords_count'] = is_array($this->data['keywords']) ? count($this->data['keywords']) : 0;

    $actlog = new actlog();
    $this->data['actlog'] = $actlog->show('seo/keywords');
