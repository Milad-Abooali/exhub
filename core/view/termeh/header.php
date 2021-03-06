<!--- Page Header -->

<!--- Header Navbar -->
<div class="h-nav">
  <div>
    <a href="<?= APP_URL ?>" title="صفحه نخست"><img id="cb-logo" class="animated slideInLeft" alt="CODEBOX" src="<?= IMG ?>codebox.png" /></a>
    <sup class="text-secondary">v6 eX 1.0</sup>
  </div>
  <div class="showMobMenu cb-rtl animated slideInDown d-block d-md-none" onclick="showMobMenu()">
    <span class="text-muted mx-1 btn btn-sm" href="#000"><i class="ico menu mx-1"></i> خدمات </span>
    <div id="mob-menu" class="card">
        mob menu
    </div>
  </div>
  <div class="h-nav-menu animated slideInDown d-none d-md-block">
    <?php if (isset($_SESSION['M']['user'])): ?>
    <button class="btn btn-sm btn-outline-danger rounded doA-logout"><i class="fa fa-user ml-1"></i> Logout</button>
    <?php endif; ?>
      <button class="btn btn-sm btn-outline-light" type="button" disabled>
        <span id="is-online" class="spinner-grow spinner-grow-sm text-<?= (isset($_SESSION['M']['user'])) ? 'success' : 'warning'?>" role="status" aria-hidden="true"></span>
      </button>
  </div>
</div>

<!--- Notify -->
<div id="app-notify">
    <div class="cb-ltr w-100 d-block alerts"><br></div>
</div>

<!--- Footer Navbar -->
<div class="f-nav-m animated slideInUp d-block d-md-none text-center pt-2">
  <div class="f-nav-open">
    دسترسی سریع <i class="animated slideInUp infinite fa fa-angle-up pl-2"></i>
  </div>
  <div class="f-nav-close">
    بستن منو <i class="fa fa-angle-down mt-3 pl-2"></i>
  </div>
  <div>
    <hr>
    <div class="cb-rtl mt-3">
      <a class="btn btn-outline-success rounded ml-3" href="<?= APP_URL ?>register.php" title="ایجاد حساب کاربری"><i class="fa fa-user ml-1"></i> عضویت </a>
      <a class="btn btn-outline-primary rounded" href="<?= APP_URL ?>clientarea.php" title="ورود به حساب کاربری"><i class="fa fa-user ml-1"></i> ورود </a>
    </div>
    <hr>
    <div class="cb-rtl row">
        menu d
        <!-- <a class="btn col-6" href="<?= APP_URL ?>کنسرسیوم" title="طرح تجمیع کدباکس"> کنسرسیوم </a> -->
    </div>
  </div>
</div>

<div class="f-nav animated slideInUp d-none d-md-flex">
  <div class="mt-2 cb-cs-n">

    <small>2012 - 2020  ©  <a href="<?= APP_URL ?>" title="کدباکس">CODEBOX</a> | v 6</small>
  </div>
  <div class="cb-rtl">
      menu
    <!--  <a class="btn" href="<?= APP_URL ?>کنسرسیوم" title="طرح تجمیع کدباکس"> کنسرسیوم </a> -->
  </div>
</div>

<!--- Scroll To Top -->
<i id="gotop" class="btn btn-outline-secondary fa fa-arrow-circle-up fa-2x p-2" onclick="scrollToTop()" title="بازگشت به ابتدای صفحه">
<?= $this->data['PAGE']['title'] ?>
</i>