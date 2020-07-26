<?php

    $this->data['PAGE']['demo']=0;

    $this->data['PAGE']['title'] = 'A > FIS';
    $this->data['PAGE']['head'] = ' ';

    include('core/view/termeh/head.php');
    include('core/view/termeh/header.php');
?>

    <div id="app-body" class="container" data-g="admin" data-token="<uponE>$_SESSION['M']['TOKEN']</uponE>">

        <!-- Row Form -->


        <!-- Row List -->
        <div id="fis-list" class="row mt-4 py-4 px-1 cb-oa">
            <?php foreach ((array) $this->data['keywords'] as $item) { ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header text-center">
                        <a data-toggle="collapse" href="#key-<?= $item['id'] ?>">
                           <small> Keyword ID: <?= $item['id'] ?></small>
                            <hr>
                            <h4 class="panel-title">
                                <?= $item['keyword'] ?>
                            </h4>
                            <div id="circle-<?= $item['id'] ?>" class="p-circle" data-ratio="<?= $item['ratio'] ?>">
                                <strong></strong>
                            </div>

                        </a>
                    </div>
                    <div id="key-<?= $item['id'] ?>"  data-parent="#fis-list" class="panel-collapse collapse">
                        <div class="card-body">

                            <div class="list-group">
                                <a data-eid="Yahoo" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Yahoo']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://search.yahoo.com/search?p=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=yahoo.com"> Yahoo
                                </a>
                                <a data-eid="Yandex" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Yandex']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://yandex.ru/search/?text=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=yandex.ru"> Yandex
                                </a>
                                <a data-eid="Google" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Google']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://www.google.com/search?q=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=google.com"> Google
                                </a>
                                <a data-eid="Bing" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Bing']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://www.bing.com/search?q=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=bing.com"> Bing
                                </a>
                                <br>
                                <a data-eid="Ask" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Ask']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://www.ask.com/web?q=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=ask.com" /> Ask
                                </a>
                                <a data-eid="AOL" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['AOL']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://search.aol.com/aol/search?s_it=sb-top&v_t=sb-nrf&q=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=aol.com" /> AOL
                                </a>
                                <a data-eid="Baidu" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Baidu']) ?'cb-ob-1': 'doA-fisopen' ?>" href="http://www.baidu.com/s?ie=utf-8&wd=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=baidu.com" /> Baidu
                                </a>
                                <br>
                                <a data-eid="Yooz" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Yooz']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://www.yooz.ir/search/?q=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=yooz.ir"> یوز
                                </a>
                                <a data-eid="Parsijoo" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Parsijoo']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://parsijoo.ir/websearch?q=<?= $item['keyword'] ?>">
                                    <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=parsijoo.ir"> پارسی جو
                                </a>
                                <a data-eid="Parseek" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Parseek']) ?'cb-ob-1': 'doA-fisopen' ?>" href="https://www.parseek.com/search/?b=جستجو+در+وب&sq=<?= $item['keyword'] ?>">
                                   <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=parseek.com" /> پارسیک
                                </a>
                                <a data-eid="Rismoon" data-rid="<?= $item['id'] ?>" target="_blank" class="list-group-item <?= ($item['Rismoon']) ?'cb-ob-1': 'doA-fisopen' ?>" href="http://www.rismoon.com/search-fa.html?tab=web&q=<?= $item['keyword'] ?>">
                                   <img class="cb-ico-link" src="http://www.google.com/s2/favicons?domain=rismoon.com" />  ریسمون
                                </a>
                            </div>
                        </div>
                        <div class="card-footer wa">
                            Today Ratio: <strong id="ratio-<?= $item['id'] ?>"><?= $item['ratio'] ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
        <!-- Row Logs -->
        <?php
            include('core/view/termeh/logsrow.php');
        ?>

    </div>

<?php
    include('core/view/termeh/footer.php');
?>