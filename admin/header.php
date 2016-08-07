  <!-- Start Page Loading -->
  <div class="loading"><img src="<?=URLAD?>img/loading.gif" alt="loading-img"></div>
  <!-- End Page Loading -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
  <!-- START TOP -->
  <div id="top" class="clearfix">

    <!-- Start App Logo -->
    <div class="applogo">
      <a href="<?=URLAD?>" class="logo"><?php echo SHORT_NAME; ?></a>
    </div>
    <!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->

    <!-- Start Searchbox -->
<!--    <form class="searchform">
      <input type="text" class="searchbox" id="searchbox" placeholder="Search">
      <span class="searchbutton"><i class="fa fa-search"></i></span>
    </form>-->
    <!-- End Searchbox -->

    <!-- Start Top Menu -->
     
  
<!--    <ul class="topmenu" style="margin-left:10px;">
       <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Fill Data<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?=URLAD?>exam-group"  class="<?=$submenu1?>"><i class="fa fa-arrow-circle-right"></i> Exam Group</a></li>
	  <li><a href="<?=URLAD?>exam" class="<?=$submenu2?>" ><i class="fa fa-arrow-circle-right"></i> Exam</a></li>
	  <li><a href="<?=URLAD?>section" class="<?=$submenu3?>" ><i class="fa fa-arrow-circle-right"></i> Section</a></li>
	  <li><a href="<?=URLAD?>subject" class="<?=$submenu4?>" ><i class="fa fa-arrow-circle-right"></i> Subject</a></li>
	  <li><a href="<?=URLAD?>module" class="<?=$submenu5?>" ><i class="fa fa-arrow-circle-right"></i> Module</a></li>
      <li><a href="<?=URLAD?>direction" class="<?=$submenu6?>" ><i class="fa fa-arrow-circle-right"></i> Direction</a></li>
       <li><a href="<?=URLAD?>exam-package" class="<?=$submenu7?>" ><i class="fa fa-arrow-circle-right"></i> Exam Packages</a></li>
        </ul>
      </li>
    </ul>
  -->

    <!-- End Top Menu -->

    <!-- Start Sidepanel Show-Hide Button -->
    <a href="#sidepanel" class="sidepanel-open-button"><i class="fa fa-outdent"></i></a>
    <!-- End Sidepanel Show-Hide Button -->
 
    <!-- Start Top Right -->
    <ul class="top-right">
    
     <?php
	if($_SESSION['MYPR_adm_type']=='admin')
	{
   ?>

    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle hdbutton">Create New <span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list">
         <li><a href="<?=URLAD?>exam-group"  class="<?=$submenu1?>"><i class="fa fa-arrow-circle-right"></i> Exam Group</a></li>
	  <li><a href="<?=URLAD?>exam" class="<?=$submenu2?>" ><i class="fa fa-arrow-circle-right"></i> Exam</a></li>
	  <li><a href="<?=URLAD?>section" class="<?=$submenu3?>" ><i class="fa fa-arrow-circle-right"></i> Section</a></li>
	  <li><a href="<?=URLAD?>subject" class="<?=$submenu4?>" ><i class="fa fa-arrow-circle-right"></i> Subject</a></li>
	  <li><a href="<?=URLAD?>module" class="<?=$submenu5?>" ><i class="fa fa-arrow-circle-right"></i> Module</a></li>
      <li><a href="<?=URLAD?>direction" class="<?=$submenu6?>" ><i class="fa fa-arrow-circle-right"></i> Direction</a></li>
       <li><a href="<?=URLAD?>exam-package" class="<?=$submenu7?>" ><i class="fa fa-arrow-circle-right"></i> Exam Packages</a></li>
    
      </li>
        </ul>
          </li>
         <?php
	}
?>
  

<!--    <li class="link">
      <a href="#" class="notifications">6</a>
    </li>

-->    <li class="dropdown link">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><img src="<?=URLAD?>img/profileimg.png" alt="img"><b><?=ucfirst($_SESSION['MYPR_adm_username'])?></b><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
           <?php
			if($_SESSION['MYPR_adm_type']=='admin')
			{
		   ?>
          <li><a href="<?=URLAD?>list-users"><i class="fa falist fa-users"></i>Admin Users</a></li>
           <?php
  				}
  			?>
          <li><a href="<?=URLAD?>reset-password"><i class="fa falist fa-wrench"></i>Reset Password</a></li>
          <li class="divider"></li>
          <li><a href="<?=URLAD?>logout"><i class="fa falist fa-power-off"></i> Logout</a></li>
        </ul>
    </li>

    </ul>
    <!-- End Top Right -->

  </div>
  <!-- END TOP -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 