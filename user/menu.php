<?php
$menu1  =  "";
//$head_url = basename($_SERVER["SCRIPT_NAME"]);
$head_url = $params[0];
if($head_url=='home' || $head_url=='')
  $menu1 = "active";
if($head_url=='reset-password')
  $menu3 = "active";
if($head_url=='packages')
  $menu4 = "active";
if($head_url=='exam-list')
  $menu5 = "active";
 if($head_url=='exam-manager')
  $menu6 = "active";
 if($head_url=='exam-list-user')
  $menu7 = "active";
 if($head_url=='exam-history')
  $menu8 = "active";
 if($head_url=='exam-analysis')
  $menu9 = "active";
 if($head_url=='edit-profile')
  $menu10 = "active"
?>
<div class="sidebar clearfix">
  <style>
  /* Tooltip */
  .test + .tooltip > .tooltip-inner {
      background-color:#009688; 
      color: #FF0; 
      border: 1px solid green; 
      padding: 15px;
      font-size: 14px;
	  min-width: 350px;
	  font-weight:bold;
	
  }
  /* Tooltip on top */
  .test + .tooltip.top > .tooltip-arrow {
      border-top: 5px solid green;
  }
  /* Tooltip on bottom */
  .test + .tooltip.bottom > .tooltip-arrow {
      border-bottom: 5px solid blue;
  }
  /* Tooltip on left */
  .test + .tooltip.left > .tooltip-arrow {
      border-left: 5px solid red;
  }
  /* Tooltip on right */
  .test + .tooltip.right > .tooltip-arrow {
      border-right: 5px solid black;
  }
  </style>
<ul class="sidebar-panel nav">
  <li class="sidetitle">MAIN</li>
  <li><a href="<?=URLUR?>home" class="<?=$menu1?>"><span class="icon color5" ><i class="fa fa-home"></i></span>Dashboard<!--<span class="label label-default">2</span>--></a></li>
 	<li><a href="<?=URLUR?>packages" class="<?=$menu4?> test" data-toggle="tooltip"  data-placement="right" title="Choose your exam’s packages and Buy online (Net banking/Credit Card/ Debit Card etc.)" ><span class="icon color10" ><i class="fa fa-shopping-cart"></i></span>Buy Packages</a></li>
	<li><a href="<?=URLUR?>exam-list" class="<?=$menu5?> test" data-toggle="tooltip"  data-placement="right" title="All your package exams and Open Exams are listed here!"><span class="icon color7" ><i class="fa fa-clock-o"></i></span>Exams</a></li>
    <li><a href="<?=URLUR?>exam-config" class="<?=$menu6?> test" data-toggle="tooltip"  data-placement="right" title="Prepare and “practice” your exams based on your analysis (System Generated mock test or build your own set). Select your option and press Continue…" ><span class="icon color11" ><i class="fa fa-bar-chart"></i></span>Exam Manager</a></li>
    <li><a href="<?=URLUR?>exam-list-user" class="<?=$menu7?> test" data-toggle="tooltip"  data-placement="right" title="All your unattended and dropped Exams will be listed here." ><span class="icon color12" ><i class="fa fa-save"></i></span>Saved Exams</a></li>
    <li><a href="<?=URLUR?>exam-history" class="<?=$menu8?> test" data-toggle="tooltip"  data-placement="right" title="Snapshots of all your exams (package exams and Open Exams) listed here. Get more details by clicking on each exam." ><span class="icon color13" ><i class="fa fa-th"></i></span>Exam History</a></li>
      <li><a href="<?=URLUR?>exam-analysis" class="<?=$menu9?> test" data-toggle="tooltip"  data-placement="right" title="Identify your strength and weakness on topic wise by reviewing attended exams and prepare through Exam manager…" ><span class="icon color14" ><i class="fa fa-bar-chart"></i></span>Exam Analysis</a></li> 
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
<ul class="sidebar-panel nav">
   <li class="sidetitle">MORE</li>
  <li><a href="<?=URLUR?>edit-profile" class="<?=$menu10?>"><span class="icon color13" ><i class="fa fa-edit"></i></span>Edit Profile</a></li>
   <li><a href="<?=URLUR?>reset-password" class="<?=$menu3?>"><span class="icon color8" ><i class="fa fa-key"></i></span>Reset Password</a></li>
   <li><a href="<?=URLUR?>logout" ><span class="icon color9" ><i class="fa fa-sign-out"></i></span>Logout</a></li>
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