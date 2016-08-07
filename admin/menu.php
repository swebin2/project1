<?php
$menu1  =  "";
//$head_url = basename($_SERVER["SCRIPT_NAME"]);
$head_url = $params[0];
if($head_url=='home' || $head_url=='')
  $menu1 = "active";
if($head_url=='add-user' || $head_url=='list-users')
  $menu2 = "active";
if($head_url=='reset-password')
  $menu3 = "active";
if($head_url=='clear-cache')
  $menu4 = "active";
if($head_url=='reg-users')
  $menu5 = "active";
if($head_url=='add-testi' || $head_url=='list-testi')
  $menu6 = "active";
 if($head_url=='payments')
  $menu7 = "active";
if($head_url=='exam-group' || $head_url=='exam' || $head_url=='subject' || $head_url=='section' || $head_url=='module' || $head_url=='add-exam-group' || $head_url=='add-exam' || $head_url=='add-section' || $head_url=='add-subject' || $head_url=='add-module' || $head_url=='add-direction' || $head_url=='direction' || $head_url=='exam-package' || $head_url=='add-exam-package')
{
  $menu8 = "active";
  $dis1  = "display:block";
}
if($head_url=='exam-group' || $head_url=='add-exam-group')
{
  $submenu1 = "active";
}
if($head_url=='exam' || $head_url=='add-exam')
{
  $submenu2 = "active";
}
if($head_url=='section' || $head_url=='add-section')
{
  $submenu3 = "active";
}
if($head_url=='subject' || $head_url=='add-subject')
{
  $submenu4 = "active";
}
if($head_url=='module' || $head_url=='add-module')
{
  $submenu5 = "active";
}
if($head_url=='direction' || $head_url=='add-direction')
{
  $submenu6 = "active";
}
if($head_url=='exam-package' || $head_url=='add-exam-package')
{
  $submenu7 = "active";
}
if($head_url=='add-question' || $head_url=='questions')
  $menu9 = "active";
if($head_url=='import-questions')
  $menu10 = "active";
if($head_url=='manage-exam' || $head_url=='add-exam-list')
  $menu11 = "active";
 if($head_url=='view-exam-history')
  $menu12 = "active";
 if($head_url=='view-exam-analysis')
  $menu13 = "active";
?>
<div class="sidebar clearfix">

<ul class="sidebar-panel nav">
  <li class="sidetitle">MAIN</li>
  <li><a href="<?=URLAD?>home" class="<?=$menu1?>"><span class="icon color5" ><i class="fa fa-home"></i></span>Dashboard<!--<span class="label label-default">2</span>--></a></li>
  <li><a href="<?=URLAD?>reg-users" class="<?=$menu5?>"><span class="icon color12" ><i class="fa fa-check-square-o"></i></span>Registered Users</a></li>
  <li><a href="<?=URLAD?>view-exam-history" class="<?=$menu12?>"><span class="icon color13" ><i class="fa fa-th"></i></span>User Exam History</a></li>
      <li><a href="<?=URLAD?>view-exam-analysis" class="<?=$menu13?>"><span class="icon color14" ><i class="fa fa-bar-chart"></i></span>User Exam Analysis</a></li> 
   <?php
	if($_SESSION['MYPR_adm_type']=='admin')
	{
   ?>
  <li><a href="<?=URLAD?>list-testi" class="<?=$menu6?>"><span class="icon color7" ><i class="fa fa-file-text-o"></i></span>Testimonials</a></li>
  <?php
	}
	?>
  <li><a href="<?=URLAD?>payments" class="<?=$menu7?>"><span class="icon color11" ><i class="fa fa-diamond"></i></span>Payments</a></li>
    <?php
	if($_SESSION['MYPR_adm_type']=='admin')
	{
   ?>
  <li><a href="<?=URLAD?>questions" class="<?=$menu9?>"><span class="icon color8" ><i class="fa fa-flask"></i></span>Questions</a></li>
   <li><a href="<?=URLAD?>import-questions" class="<?=$menu10?>"><span class="icon color13" ><i class="fa fa-upload"></i></span>Import Questions</a></li>
      <li><a href="<?=URLAD?>manage-exam" class="<?=$menu11?>"><span class="icon color7" ><i class="fa fa-cube"></i></span>Manage Exam</a></li>
	
    <?php
	}
	?>
<!--  <li><a href="#"><span class="icon color7"><i class="fa fa-flask"></i></span>UI Elements<span class="caret"></span></a>
    <ul>
      <li><a href="icons.html">Icons</a></li>
      <li><a href="tabs.html">Tabs</a></li>
      <li><a href="buttons.html">Buttons</a></li>
      <li><a href="panels.html">Panels</a></li>
      <li><a href="notifications.html">Notifications</a></li>
      <li><a href="modal-boxes.html">Modal Boxes</a></li>
      <li><a href="progress-bars.html">Progress Bars</a></li>
      <li><a href="others.html">Others<span class="label label-danger">NEW</span></a></li>
    </ul>
  </li>
  <li><a href="charts.html"><span class="icon color8"><i class="fa fa-bar-chart"></i></span>Charts</a></li>
  <li><a href="#"><span class="icon color9"><i class="fa fa-th"></i></span>Tables<span class="caret"></span></a>
    <ul>
      <li><a href="basic-table.html">Basic Tables</a></li>
      <li><a href="data-table.html">Data Tables</a></li>
    </ul>
  </li>
  <li><a href="#"><span class="icon color10"><i class="fa fa-check-square-o"></i></span>Forms<span class="caret"></span></a>
    <ul>
      <li><a href="form-elements.html">Form Elements</a></li>
      <li><a href="layouts.html">Form Layouts</a></li>
      <li><a href="text-editors.html">Text Editors</a></li>
    </ul>
  </li>
  <li><a href="widgets.html"><span class="icon color11"><i class="fa fa-diamond"></i></span>Widgets</a></li>
  <li><a href="calendar.html"><span class="icon color8"><i class="fa fa-calendar-o"></i></span>Calendar<span class="label label-danger">NEW</span></a></li>
  <li><a href="typography.html"><span class="icon color12"><i class="fa fa-font"></i></span>Typography</a></li>
  <li><a href="#"><span class="icon color14"><i class="fa fa-paper-plane-o"></i></span>Extra Pages<span class="caret"></span></a>
    <ul>
      <li><a href="social-profile.html">Social Profile</a></li>
      <li><a href="invoice.html">Invoice<span class="label label-danger">NEW</span></a></li>
      <li><a href="login.html">Login Page</a></li>
      <li><a href="register.html">Register</a></li>
      <li><a href="forgot-password.html">Forgot Password</a></li>
      <li><a href="lockscreen.html">Lockscreen</a></li>
      <li><a href="blank.html">Blank Page</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="404.html">404 Page</a></li>
      <li><a href="500.html">500 Page</a></li>
    </ul>
  </li>-->
</ul>
   <?php
	if($_SESSION['MYPR_adm_type']=='admin')
	{
   ?>
<ul class="sidebar-panel nav">
   <li class="sidetitle">CONTENT</li>
    <li><a href="javascript:;"  class="<?=$menu8?>" ><span class="icon color14"><i class="fa fa-paper-plane-o"></i></span>Fill Data<span class="caret"></span></a>
    <ul style="<?=$dis1?>">
      <li><a href="<?=URLAD?>exam-group"  class="<?=$submenu1?>"><i class="fa fa-arrow-circle-right"></i> Exam Group</a></li>
	  <li><a href="<?=URLAD?>exam" class="<?=$submenu2?>" ><i class="fa fa-arrow-circle-right"></i> Exam</a></li>
	  <li><a href="<?=URLAD?>section" class="<?=$submenu3?>" ><i class="fa fa-arrow-circle-right"></i> Section</a></li>
	  <li><a href="<?=URLAD?>subject" class="<?=$submenu4?>" ><i class="fa fa-arrow-circle-right"></i> Subject</a></li>
	  <li><a href="<?=URLAD?>module" class="<?=$submenu5?>" ><i class="fa fa-arrow-circle-right"></i> Module</a></li>
      <li><a href="<?=URLAD?>direction" class="<?=$submenu6?>" ><i class="fa fa-arrow-circle-right"></i> Direction</a></li>
       <li><a href="<?=URLAD?>exam-package" class="<?=$submenu7?>" ><i class="fa fa-arrow-circle-right"></i> Exam Packages</a></li>
	 </ul>
</ul>
<?php
	}
?>
<ul class="sidebar-panel nav">
   <li class="sidetitle">MORE</li>
   <?php
	if($_SESSION['MYPR_adm_type']=='admin')
	{
   ?>
  <li><a href="<?=URLAD?>list-users" class="<?=$menu2?>"><span class="icon color10" ><i class="fa fa-users"></i></span>Admin Users</a></li>
  <?php
  }
  ?>
  
   <li><a href="<?=URLAD?>reset-password" class="<?=$menu3?>"><span class="icon color8" ><i class="fa fa-key"></i></span>Rest Password</a></li>
   <li><a href="<?=URLAD?>logout" ><span class="icon color9" ><i class="fa fa-sign-out"></i></span>Logout</a></li>
</ul>

<!--<ul class="sidebar-panel nav">
  <li class="sidetitle">MORE</li>
  <li><a href="grid.html"><span class="icon color15"><i class="fa fa-columns"></i></span>Grid System</a></li>
  <li><a href="maps.html"><span class="icon color7"><i class="fa fa-map-marker"></i></span>Maps</a></li>
  <li><a href="customizable.html"><span class="icon color10"><i class="fa fa-lightbulb-o"></i></span>Customizable</a></li>
  <li><a href="helper-classes.html"><span class="icon color8"><i class="fa fa-code"></i></span>Helper Classes</a></li>
  <li><a href="changelogs.html"><span class="icon color12"><i class="fa fa-file-text-o"></i></span>Changelogs</a></li>
</ul>-->


<!--<div class="sidebar-plan">
  Pro Plan<a href="#" class="link">Upgrade</a>
  <div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
  </div>
</div>
<span class="space">42 GB / 100 GB</span>
</div>-->

</div>