<?php
$where = "";
$exam_count = $objgen->get_AllRowscnt("exmas",$where);
if($exam_count>0)
{
  $exam_arr = $objgen->get_AllRows("exmas",0,$exam_count,"exam_name asc",$where);
}
?>
<header class="header" style="border-top: 3px solid #18BB7C;"> 
      
      <!-- end top-header  -->
      
      <div class="container">
        <div class="row">
          <div class="col-xs-12"> <a class="header-logo" href="<?=URL?>"><img class="header-logo__img" src="<?=URL?>images/logo.png" alt="Logo"></a>
            <div class="header-inner">
              <nav class="navbar yamm">
                <div class="navbar-header hidden-md  hidden-lg  hidden-sm ">
                  <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div id="navbar-collapse-1" class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                    <li class="dropdown"><a href="<?=URL?>">HOME</a> </li>
                    <li class="dropdown"> <a href="#.">EXAMS</a>
                      <ul role="menu" class="dropdown-menu" style="display: none;">
                      <?php
						if($exam_count>0)
						{
							foreach($exam_arr as $key=>$val)
							{
						?>
                        <li><a href="<?=URL?>login"><?php echo $objgen->check_tag($val['exam_name']); ?></a> </li>
                        <?php
							}
						}
					    ?>
                  
                      </ul>
                    </li>
                    <li> <a href="<?=URL?>about-us">ABOUT US</a> </li>
                    <li> <a href="<?=URL?>contact">CONTACT US</a> </li>
                    <li> <a href="<?=URL?>signup">SIGN UP</a> </li>
                    <li><a href="<?=URL?>login">LOGIN</a></li>
                  </ul>
                </div>
              </nav>
              <!--end navbar --> 
              
            </div>
            <!-- end header-inner --> 
          </div>
          <!-- end col  --> 
        </div>
        <!-- end row  --> 
      </div>
      <!-- end container--> 
    </header>