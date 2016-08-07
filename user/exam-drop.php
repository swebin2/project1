<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen = new general();

setcookie("timer_start_time", "", time() - (60 * 60 * 24));
setcookie("current_time", "", time() - (60 * 60 * 24));
setcookie("time_diff", "", time() - (60 * 60 * 24));
setcookie("counter_time", "", time() - (60 * 60 * 24));
unset($_SESSION['exam'][$usrid]);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo TITLE; ?></title>

<?php require_once "header-script.php"; ?>
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
                    <li><a href="javascript:;"> Exams</a></li>
                </ol>



            </div>
            <!-- End Page Header -->

            <!-- //////////////////////////////////////////////////////////////////////////// --> 
            <!-- START CONTAINER -->
            <div class="container-default">

                <div class="row">

                    <div class="col-md-12 col-lg-12">



                        <div class="panel panel-widget">

                            <div class="panel-body table-responsive" align="center">
                                <p>You have dropped the exam!</p>
                                <a href="<?= URLUR ?>exam-list" role="button" class="btn btn-success" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Take Another Exam</a>

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