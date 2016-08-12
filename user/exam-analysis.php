<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen = new general();
$where = " AND user_id='$usrid'";
$getAllExamsCntByUser = $objgen->get_AllRowscnt('user_exam_score', $where);
if ($getAllExamsCntByUser > 0) {
    $getAllExamsByUser = $objgen->get_AllRows('user_exam_score', 1, $getAllExamsCntByUser, '`id` DESC', $where);
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
        <style>
            .exam_bar_chart_div{
                width: 450px;
                float: left;
                margin: 20px;
            }
        </style>

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
                    <li><a href="<?= URLUR ?>home">Home</a></li>
                    <li><a href="<?= URLUR ?>exam-list"> Exams</a></li>
                    <li><a href="javascript:;"> Exams Analysis</a></li>
                </ol>



            </div>
            <!-- End Page Header -->

            <!-- //////////////////////////////////////////////////////////////////////////// --> 
            <!-- START CONTAINER -->
            <div class="container-default">

                <div class="row">

                    <div class="col-md-12 col-lg-12">



                        <div class="panel panel-widget">

                            <div class="panel-body table-responsive" align="center" style="background:#eff0f1">
                                <div id="chart-container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            </div>
                            <div>
                                <?php
                                if (!empty($getAllExamsByUser)) {
                                    $i = 0;
                                    foreach ($getAllExamsByUser as $key => $value) {
                                        $examScoreId = $value['id'];
                                        ?>
                                        <div class="exam_bar_chart_div <?= $examScoreId ?>" id="exam_bar_chart<?= $i ?>"></div>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
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
<?php
$where = " AND user_id='$usrid'";
$getLastExamByUser = $objgen->get_AllRows('user_exam_score', 0, 1, '`id` DESC', $where);

if (!empty($getLastExamByUser)) {
    $examScoreId = $getLastExamByUser[0]['id'];
    $getLastExamId = $getLastExamByUser[0]['exam_id'];
    $lastExamDate = $getLastExamByUser[0]['exam_attended_on'];
    $lastExamDate = date('jS F Y h:i A', strtotime($lastExamDate));
    if ($getLastExamByUser[0]['exam_created_by'] == 'user') {
        $examTable = 'user_exam_list';
    } else {
        $examTable = 'exam_list';
    }
    $getLastExamDetails = $objgen->get_Onerow($examTable, " AND id='$getLastExamId'", 'exam_name');
    $lastExamName = $getLastExamDetails['exam_name'];
//    $lastExamCorrectAnsCnt = $getLastExamByUser[0]['correct_answer_num'];
//    $lastExamWrongAnsCnt = $getLastExamByUser[0]['wrong_answer_num'];
//    $lastExamUnansweredCnt = $getLastExamByUser[0]['unanswered_num'];
    $getMarkBySectionCnt = $objgen->get_AllRowscnt('user_exam_log', " AND `exam_score_id`='$examScoreId'", '`qn_section_id`');
    if($getMarkBySectionCnt>0){
        $getMarkBySection = $objgen->get_AllRows('user_exam_log', 0, $getMarkBySectionCnt, '', " AND `exam_score_id`='$examScoreId'", '`qn_section_id`', '`qn_section_id`,SUM(`exam_mark`) as section_total_mark');
    }
    if(!empty($getMarkBySection)){
        foreach ($getMarkBySection as $key => $value) {
            $sectionMark = $value['section_total_mark'];
            $sectionMark = (int)$sectionMark;
            $sectionId = $value['qn_section_id'];
            $getSectionDetails = $objgen->get_Onerow('section', " AND id='$sectionId'", 'name');
            $sectionName = $getSectionDetails['name'];
            $sectionArr1[]= array("$sectionName",$sectionMark);

        }
    }
    if(!empty($sectionArr1)){
        $jsonsectionArr1 = json_encode($sectionArr1);
        echo "window.onload = showChartModal('$lastExamName','$lastExamDate',$jsonsectionArr1);";
    }
}

//code for barchart
if (!empty($getAllExamsByUser)) {
    $i = 0;
    
    foreach ($getAllExamsByUser as $key => $value) {
        unset($sectionArr);
        $examScoreId = $value['id'];
        $examId = $value['exam_id'];
        $exam_created_by = $value['exam_created_by'];
        $examDate = $value['exam_attended_on'];
        $examDate = date('jS F Y h:i A', strtotime($examDate));
        if($exam_created_by=='user'){
            $examTable = 'user_exam_list';
        }else{
            $examTable = 'exam_list';
        }
        $getExamDetails = $objgen->get_Onerow($examTable, " AND id='$examId'", 'exam_name');
        $examName = $getExamDetails['exam_name'];
        $getMarkBySectionCnt = $objgen->get_AllRowscnt('user_exam_log', " AND `exam_score_id`='$examScoreId'", '`qn_section_id`');
        if($getMarkBySectionCnt>0){
            $getMarkBySection = $objgen->get_AllRows('user_exam_log', 0, $getMarkBySectionCnt, '', " AND `exam_score_id`='$examScoreId'", '`qn_section_id`', '`qn_section_id`,SUM(`exam_mark`) as section_total_mark');
        }
        if(!empty($getMarkBySection)){
            foreach ($getMarkBySection as $key1 => $value1) {
                $sectionMark = $value1['section_total_mark'];
                $sectionMark = (int)$sectionMark;
                $sectionId = $value1['qn_section_id'];
                $getSectionDetails = $objgen->get_Onerow('section', " AND id='$sectionId'", 'name');
                $sectionName = $getSectionDetails['name'];
                $sectionArr[]= array("$sectionName",$sectionMark);

            }
        }
        if(!empty($sectionArr)){
            $jsonsectionArr = json_encode($sectionArr);
            echo "window.onload = showExmChart('exam_bar_chart".$i."','$examName attended on $examDate',$jsonsectionArr);";

            $i++;
        }
    }
    
}
?>
            function showChartModal(exm_name, attend_date, section_data) {
                $("#chartModal").modal('show');
                // Build the chart
                $('#chart-container').highcharts({
                    chart: {
                        backgroundColor: "#eff0f1",
                        borderRadius: 15,
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: '<b>Exam Status for ' + exm_name + ' attended on ' + attend_date+'</b>',
                        style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif',
                                    background: 'red',
                                    color: '#ef4836'
                                }
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
                            name: 'Attend Percentage',
                            colorByPoint: true,
                            data: section_data
                        }]
                });
            }

            //bar chart function
            function showExmChart(div_id, title,sectionData) {
                $('#' + div_id).highcharts({
                    chart: {
                        type: 'column',
                        backgroundColor: "#eff0f1",
                        borderRadius: 15
                    },
                    title: {
                        text: '<b>'+title+'</b>',
                        style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif',
                                    background: 'red',
                                    color: '#ef4836'
                                }
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            rotation: -45,
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Mark'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        pointFormat: 'Total mark obtained for the section: <b>{point.y:.1f}</b>'
                    },
                    series: [{
                            name: 'Section',
                            data: sectionData,
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                format: '{point.y:.1f}', // one decimal
                                y: 10, // 10 pixels down from the top
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif',
                                    background: 'red'
                                }
                            }
                        }]
                });
            }
            ;
        </script>
        <script type="text/javascript" src="<?= URLUR ?>js/datatables/datatables.min.js"></script>

    </body>
</html>
<?php
?>