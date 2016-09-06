<?php
$objgen		=	new general();

 
if(isset($_POST['Send']))
{

		$full_name  = $_POST['full_name'];
		$subject    = $_POST['subject'];
		$comments   = $_POST['message'];
		
		$to = ADMINMAIL;
		
		$subject = "Enquiry from ".SITE_NAME.' : '.$subject;
		
		
		if($subject!="")
		{
		
		$message = '<table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" colspan="2"><img src="'.WEBLINK.'/images/logo.png" /></td>
        </tr>
		 <tr>
          <td align="left" colspan="2">&nbsp;</td>
        </tr>
		<tr>
          <td width="160" align="left" valign="middle">Full Name: </td>
          <td width="220" align="left" valign="top">'.$full_name.'</td>
        </tr>
        <tr>
          <td align="left" valign="middle">Subject: </td>
          <td align="left" valign="top">'.$subject.'</td>
        </tr>
        <tr>
          <td align="left" valign="top">Message: </td>
          <td align="left" valign="top">'.$comments.'</td>
        </tr>
        <tr>
          <td colspan="2" align="left" style="line-height:20px;;">&nbsp;</td>
        </tr>
      </table>';
		
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From:'. FROMMAIL . "\r\n" .
					'Reply-To:'. FROMMAIL . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
					
	  // print_r($message);exit;
		
		// Mail it
		mail($to, $subject, $message, $headers);
		$msg2 = "Message sent successfully";
		
		}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
<title><?=TITLE?></title>
<link rel="shortcut icon" href="<?=URL?>images/favicon.ico" type="image/x-icon">
<link href="<?=URL?>css/master.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

<!-- style 4 aboutfooter -->
<link rel="stylesheet" href="<?=URL?>css/font-awesome.css">
<link rel="stylesheet" href="<?=URL?>css/main2.css">
<link rel="stylesheet" type="text/css" href="<?=URL?>css/styles.css" />

<!--styles -->

<script src="<?=URL?>js/jquery-1.11.3.min.js"></script>
<style>
# scroll-top {
 display:none !important;
}
</style>
</head>

<body>

<!-- Loader -->
<div id="page-preloader" style="display: none;"><span class="spinner"></span></div>
<!-- Loader end -->

<div class="layout-theme animated-css" data-header="sticky" data-header-top="200"> 
  
  <!-- Start Switcher --> 
  
  <!-- End Switcher -->
  
  <div id="wrapper"> 
    
    <!-- HEADER -->
    <?php require_once("header.php"); ?>
    <!-- end header --> 
    
    <!-- end main-content -->
    
    <div class="wrap-title-page">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <h1 class="ui-title-page">contact us</h1>
          </div>
        </div>
      </div>
      <!-- end container--> 
    </div>
    <!-- end wrap-title-page -->
    
    <main class="main-content"> 
      
      <!--<div class="container">
						<div class="row">
							<div class="col-md-5">
								<section class="section_contacts">
									<h2 class="ui-title-inner decor decor_mod-a">Get in Touch with us</h2>
									<p>Reprehenderit in voluptate velit esse cillum dolo reu fugiat nulla pariat ecated cupidatat non pried ent sun in asculpa.</p>
									<ul class="list-social list-inline">
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-facebook"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-twitter"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-google-plus"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-linkedin"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-behance"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-vimeo"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-whatsapp"></i></a>
										</li>
										<li>
											<a href="javascript:void(0);"><i class="icon fa fa-youtube-play"></i></a>
										</li>
									</ul>
									<ul class="list-contacts list-unstyled">
										<li class="list-contacts__item">
											<i class="icon stroke icon-Phone2"></i>
											<div class="list-contacts__inner">
												<div class="list-contacts__title">PHONE</div>
												<div class="list-contacts__info">+1 (000) 234 5670  |  +0800 12345</div>
											</div>
										</li>
										<li class="list-contacts__item">
											<i class="icon stroke icon-Mail"></i>
											<div class="list-contacts__inner">
												<div class="list-contacts__title">EMAIL</div>
												<div class="list-contacts__info">academica@domain.com</div>
											</div>
										</li>
										<li class="list-contacts__item">
											<i class="icon stroke icon-WorldWide"></i>
											<div class="list-contacts__inner">
												<div class="list-contacts__title">WEB</div>
												<div class="list-contacts__info">http://study.college.edu</div>
											</div>
										</li>
										<li class="list-contacts__item">
											<i class="icon stroke icon-House"></i>
											<div class="list-contacts__inner">
												<div class="list-contacts__title">location</div>
												<div class="list-contacts__info">35 Main Street, Arizona 33024</div>
											</div>
										</li>
									</ul>
								</section>
							</div>

							<div class="col-md-7">
								<div class="section_map">
									<h2 class="ui-title-inner decor decor_mod-a">OUR LOCATION</h2>
									<img class="img-responsive" src="images/map.jpg" height="505" width="670" alt="map">
								</div>
							</div>
						</div>
					</div>-->
      
      <section class="section_contacts-form">
        <div class="container">
          <div class="row">
            <div class="col-sm-8">
              <h2 class="ui-title-block">Send <strong>Us Message</strong></h2>
              <div class="wrap-subtitle">
                <div class="ui-subtitle-block ui-subtitle-block_w-line">If you have some feedback or want to ask any questions</div>
              </div>
              <!-- end wrap-title -->
                <?php
														if($msg2!="")
														{
														?>
														<div class="" style="color:#F00">
															
														 <?php echo $msg2; ?>
														</div>
													 
														<?php
														}
														?>
              <form class="form-contact ui-form" action="" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="Full Name" required name="full_name" >
                  </div>
                  <div class="col-md-6">
                    <input class="form-control" type="text" placeholder="Subject" required name="subject" >
                  </div>
                  <div class="col-xs-12">
                    <textarea class="form-control" required rows="11" required name="message"></textarea>
                    <button class="btn btn-primary btn-effect" type="submit" name="Send">SEND NOW</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- end col -->
            
            <div class="col-sm-4"> <a class="support"> <img class="img-responsive" src="<?=URL?>images/contact.jpg" height="248" width="330" alt="Foto">
              <div class="support__title" style="padding: 8px 5px;"><i class="icon stroke icon-Headset"></i>Feel free to contact us</div>
              </a> </div>
            <!-- end col --> 
            
          </div>
          <!-- end row --> 
        </div>
        <!-- end container --> 
      </section>
      <!-- end section_contacts-form --> 
      
    </main>
    <!-- end main-content --> 
    
    <!-- footer -->
    <?php require_once("footer.php"); ?>
  </div>
  <!-- end wrapper --> 
</div>
<!-- end layout-theme --> 

<!-- SCRIPTS --> 
<script src="<?=URL?>js/jquery-migrate-1.2.1.js"></script> 
<script src="<?=URL?>js/bootstrap.min.js"></script> 
<script src="<?=URL?>js/modernizr.custom.js"></script> 
<script src="<?=URL?>js/waypoints.min.js"></script> 
<script src="<?=URL?>js/jquery.easing.min.js"></script> 

<!--THEME--> 
<script src="<?=URL?>js/jquery.sliderPro.min.js"></script> 
<script src="<?=URL?>js/owl.carousel.min.js"></script> 
<script src="<?=URL?>js/jquery.isotope.min.js"></script> 
<script src="<?=URL?>js/jquery.prettyPhoto.js"></script> 
<script src="<?=URL?>js/cssua.min.js"></script> 
<script src="<?=URL?>js/wow.min.js"></script> 
<script src="<?=URL?>js/custom.min.js"></script> 

<!--COLOR SWITCHER --> 
<script src="<?=URL?>js/scripts.js"></script> 
<script src="<?=URL?>js/jquery.datetimepicker.js"></script> 
<script src="<?=URL?>js/jquery.jelect.js"></script> 
<!--<script src="js/jquery.easypiechart.min.js"></script> 
--> 

<!--<script src="js/jquery.min.js"></script>
<script src="js/main.js"></script>
<!--	<script src="js/owl.carousel.min.js"></script>




--> 

</body>
</html>