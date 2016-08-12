<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen = new general();

$where = "";

if ($_SESSION['MYPR_adm_type'] == "vendor") {
    $allow_id = array();
    $exam_id = $_SESSION['MYPR_exam_id'];

    $where2 = " and exam_id=" . $exam_id;
    $per_count = $objgen->get_AllRowscnt("exam_permission", $where2);
    if ($per_count > 0) {
        $per_arr = $objgen->get_AllRows("exam_permission", 0, $per_count, "id asc", $where2, "user_id");
        foreach ($per_arr as $k => $v) {
            $allow_id[] = $v['user_id'];
        }
    }

    if (count($allow_id) > 0) {
        $where = "and id IN (" . implode($allow_id) . ")";
    } else {
        $where = "and id=0";
    }
}


$user_count = $objgen->get_AllRowscnt("users", $where);
if ($user_count > 0) {
    $user_arr = $objgen->get_AllRows("users", 0, $user_count, "full_name asc", $where);
}


if (isset($_POST['Search'])) {

    $usrid = $_POST['user'];

    $where = " AND user_id='$usrid'";
    $row_count = $objgen->get_AllRowscnt("user_exam_score", $where);
    if ($row_count > 0) {
        $res_arr = $objgen->get_AllRows("user_exam_score", 0, $row_count, "id desc", $where);
    }
}
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
        <!-- chart Modal -->
        <div id="chartModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Exam Chart</h4>
                    </div>
                    <div class="modal-body">
                        <div id="chart-container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- START CONTENT -->
        <div class="content">

            <!-- Start Page Header -->
            <div class="page-header">
                <h1 class="title">Exams <span class="label label-info"><?= $row_count ?></span></h1>
                <ol class="breadcrumb">
                    <li><a href="<?= URLUR ?>home">Home</a></li>
                    <li><a href="javascript:;"> Exams</a></li>
                </ol>



            </div>
            <!-- End Page Header -->

            <!-- //////////////////////////////////////////////////////////////////////////// --> 
            <!-- START CONTAINER -->
            <div class="container-default">

                <div class="row">

                    <div class="col-md-12 col-lg-12">

                        <?php
                        if ($msg2 != "") {
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <i class="fa fa-check"></i>
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <b>Alert!</b> <?php echo $msg2; ?>
                            </div>

                            <?php
                        }
                        ?>

                        <div class="panel panel-widget">

                            <div class="panel-body">
                                <form role="form" action="" method="post" enctype="multipart/form-data" >
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="form-control" name="user" required >
                                                <option value="" selected="selected">Select User</option>
                                                <?php
                                                if ($user_count > 0) {
                                                    foreach ($user_arr as $key => $val) {
                                                        ?>
                                                        <option value="<?= $val['id'] ?>" <?php if ($usrid == $val['id']) { ?> selected="selected" <?php } ?> ><?= $objgen->check_tag($val['full_name']) ?> (ID-<?= $val['id'] ?>)</option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>	
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-default" name="Search"><span class="fa fa-search"></span>&nbsp;Search</button>

                                        <button class="btn btn-danger" type="button" name="Cancel" onClick="window.location = '<?= $list_url ?>'"><span class="fa fa-undo"></span>&nbsp;Reset</button>
                                    </div>
                                </form>
                            </div>


                            <div class="panel-body table-responsive">

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Sl. No.</td>
                                            <td>Exam</td>
                                            <td>Total Questions</td>
                                            <td>Mark</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($row_count > 0) {
                                            $i = 0;
                                            foreach ($res_arr as $key => $val) {
                                                $i++;
                                                $examScoreId = $val['id'];
                                                $examId = $val['exam_id'];
                                                $correctAnsCount = $val['correct_answer_num'];
                                                $wrongAnsCount = $val['wrong_answer_num'];
                                                $unansCount = $val['unanswered_num'];
                                                $examDate = $val['exam_attended_on'];
                                                $examDate = date('jS F Y h:i A', strtotime($examDate));

                                                if ($val['exam_created_by'] == 'user') {
                                                    $table = 'user_exam_list';
                                                } else {
                                                    $table = 'exam_list';
                                                }
                                                $where = " AND id='$examId'";
                                                $getExamDetails = $objgen->get_Onerow($table, $where, 'exam_name,totno_of_qu');
                                                ?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $objgen->check_tag($getExamDetails['exam_name']); ?></td>
                                                    <td><?php echo $objgen->check_tag($getExamDetails['totno_of_qu']); ?></td>
                                                    <td><?php echo $objgen->check_tag($val['exam_mark']); ?></td>
                                                    <td><?php echo $examDate; ?></td>
                                                    <td>
                                                        <a href="#" onclick="showModal('<?= $getExamDetails["exam_name"] ?>', '<?= $examScoreId ?>')" role="button" class="fa fa-eye" data-toggle="modal"></a>
                                                    </td>

                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

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
        <script src="<?= URLUR ?>js/chart.js"></script>
        <script type="text/javascript">
            function showChartModal(exm_name, correct_ans_cnt, wrong_ans_cnt, unans_cnt) {
                correct_ans_cnt = parseInt(correct_ans_cnt);
                wrong_ans_cnt = parseInt(wrong_ans_cnt);
                unans_cnt = parseInt(unans_cnt);
                $("#chartModal").modal('show');
                // Build the chart
                $('#chart-container').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Exam Status for ' + exm_name
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                            name: 'Brands',
                            colorByPoint: true,
                            data: [{
                                    name: 'correct',
                                    y: correct_ans_cnt
                                }, {
                                    name: 'Unanswered',
                                    y: unans_cnt
                                }, {
                                    name: 'Incorrect',
                                    y: wrong_ans_cnt
                                }]
                        }]
                });
            }

            function showModal(exam_name, exam_score_id) {
                $("#chartModal").modal('show');
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "<?= URLUR ?>ajax2.php",
                    data: {pid: 5, exam_name: exam_name, exam_score_id: exam_score_id},
                    success: function (result) {
                        $('#chart-container').html(result);
                    }
                });
            }
        </script>
        <script type="text/javascript" src="<?= URLUR ?>js/datatables/datatables.min.js"></script>

    </body>
</html>