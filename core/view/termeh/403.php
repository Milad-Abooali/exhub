<?php

    http_response_code(403);

  $this->data['PAGE']['demo']=0;

  $this->data['PAGE']['title'] = '403';
  $this->data['PAGE']['keywords'] = NULL;
  $this->data['PAGE']['description'] = NULL;
  $this->data['PAGE']['robots'] = 1; // Null = Follow
  $this->data['PAGE']['image'] = NULL;
  $this->data['PAGE']['canonical'] = NULL;
  $this->data['PAGE']['path'] = $this->page_path;
  $this->data['PAGE']['amphtml'] = NULL;
  $this->data['PAGE']['feed'] = NULL;
  
  $this->data['PAGE']['head'] = ' ';
  
  include('head.php'); 
  include('header.php'); 
  
?>


<div id="app-body" class="container bg-error">

<!-- Row Error Message -->

	<div class="row justify-content-center my-5">
		<div class="col-md-7">
			<div class="clearfix cb-rtl text-right">
				<h1 class="float-left display-3 mr-4 text-warning">403</h1>
				<h4 class="pt-3 cb-f">غیر مجاز !</h4>
				<p class="text-muted cb-f">شما اجازه دسترسی به این قسمت سایت را ندارید.</p>
			</div>
			<hr>
			<p class="text-muted cb-f">آیا اشتباهی رخ داده است؟</p>
			<ul class="cb-f cb-rtl text-right">
			  <li>مجدد وارد حساب کاربری خود شوید.</li>
			  <li>با مرورگر دیگری آزمایش کنید.</li>
			  <li>با تغییر IP مورد استفاده جهت اتصال به اینترنت مجدد آزمایش کنید.</li>
			</ul>
    </div>
  </div>
  
</div>

<?php 
  include('footer.php'); 
?>