<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen = new general();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo TITLE; ?></title>

<?php require_once "header-script.php"; ?>
        <link type="text/css" href="<?=URLUR?>css/custom.css" rel="stylesheet">
    </head>
    <body>
        <?php require_once "header.php"; ?>

        <?php require_once "menu.php"; ?>


        <!-- //////////////////////////////////////////////////////////////////////////// --> 
        <!-- START CONTENT -->
        <div class="content">

            <!-- Start Page Header -->
            <div class="page-header">
                <h1 class="title">Exams <span class="label label-info"><?= $row_count ?></span></h1>
                <ol class="breadcrumb">
                    <li><a href="<?= URLAD ?>home">Home</a></li>
                    <li><a href="javascript:;"> Exam Management</a></li>
                </ol>



            </div>
            <!-- End Page Header -->

            <!-- //////////////////////////////////////////////////////////////////////////// --> 
            <!-- START CONTAINER -->
            <div class="container-default">

                <div class="row">

                    <div class="col-md-12 col-lg-12">



                        <div class="panel panel-widget">

                            <div class="panel-body table-responsive">
                                <div class="col-md-12 col-lg-12 section-head-container">
                                    <div class="col-md-3 col-lg-3">
                                        <h3 class="section-head"><span class="head-num">1</span>Select Mode</h3>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <h3 class="section-head"><span class="head-num">2</span>Select Sections</h3>
                                    </div>
                                    <div class="col-md-3 col-lg-3">
                                        <h3 class="section-head"><span class="head-num">3</span>Create Test</h3>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12" style="padding-top: 0px">
                                    <div class="col-md-3 col-lg-3">
                                        <nav class="segmented-button">
                                            <input type="radio" name="exm_mode" value="test" id="exm_mode_test" checked>
                                            <label for="exm_mode_test" class="first">Test Mode</label>
                                            
                                            <input type="radio" name="exm_mode" value="practice" id="exm_mode_practice">
                                            <label for="exm_mode_practice" class="last">Practice Mode</label>
                                        </nav>
                                        <div class="qn-filter-container">
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="all" id="exm_qn_filter_all" checked>
                                                <label for="exm_qn_filter_all" class="first">All Questions</label>
                                                <span class="num_qn">1234</span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="unused" id="exm_qn_filter_unused">
                                                <label for="exm_qn_filter_unused" class="first">Unused</label>
                                                <span class="num_qn">123</span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="incorrect" id="exm_qn_filter_incorrect">
                                                <label for="exm_qn_filter_incorrect" class="first">Incorrect</label>
                                                <span class="num_qn">12</span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="inun" id="exm_qn_filter_inun">
                                                <label for="exm_qn_filter_inun" class="first">Incorrect + Unused</label>
                                                <span class="num_qn">1234</span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="flag" id="exm_qn_filter_flag">
                                                <label for="exm_qn_filter_flag" class="first">Flagged</label>
                                                <span class="num_qn">0</span>
                                            </span>
                                        </div>
                                        <div class="diff-lvl-container">
                                            <p class="diff-lvl-head">Difficulty Level</p>
                                            <nav class="segmented-button">
                                                <input type="radio" name="exm_diff_lvl" value="test" id="exm_diff_lvl_all" checked>
                                                <label for="exm_diff_lvl_all" class="first">All</label>
                                                
                                                <input type="radio" name="exm_diff_lvl" value="test" id="exm_diff_lvl_easy">
                                                <label for="exm_diff_lvl_easy">Easy</label>
                                                
                                                <input type="radio" name="exm_diff_lvl" value="test" id="exm_diff_lvl_avg">
                                                <label for="exm_diff_lvl_avg">Avg</label>

                                                <input type="radio" name="exm_diff_lvl" value="practice" id="exm_diff_lvl_hard">
                                                <label for="exm_diff_lvl_hard" class="last">Hard</label>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 section-list-container">
                                        <div class="qn-section-container">
                                            <?php
                                            for($i=0;$i<=10;$i++){
                                                
                                            ?>
                                            <span class="qn-section-col">
                                                <input type="checkbox" name="section[]" value="<?= $i ?>" id="section_<?= $i ?>">
                                                <label for="section_<?= $i ?>" class="first">Section Label (<?= rand(10,100) ?>)</label>
                                            </span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3" style="text-align: center">
                                        <div class="qn_select_count_container">
                                            <p>Available</p>
                                            <p class="qn_select_count">96</p>
                                        </div>
                                        <div class="exm_mark_container">
                                            <p>Create Test for</p>
                                            <input type="text" name="exm_mark" value="">
                                            <p class="fade_txt">(max: 50)</p>
                                        </div>
                                        <div class="chk_timer_container">
                                            <p>Timer</p>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                                <label class="onoffswitch-label" for="myonoffswitch">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="margin_top_30">
                                            <button type="submit" class="btn btn-success">Start Exam</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>
            </div>


            <!-- END CONTAINER -->
            <!-- //////////////////////////////////////////////////////////////////////////// --> 


            <!-- Start Footer -->
<?php require_once "footer.php"; ?>
            <!-- End Footer -->


        </div>
        <!-- End Content -->
        <!-- //////////////////////////////////////////////////////////////////////////// --> 


<?php require_once "footer-script.php"; ?>
        <script type="text/javascript" src="<?= URLUR ?>js/datatables/datatables.min.js"></script>

    </body>
</html>
<?php

?>