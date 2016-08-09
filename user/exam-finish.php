<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen = new general();

function is_array_empty($arr){
  if(is_array($arr)){     
      foreach($arr as $key => $value){
          if(!empty($value) || $value != NULL || $value != ""){
              return true;
              break;//stop the process we have seen that at least 1 of the array has value so its not empty
          }
      }
      return false;
  }
}

if (isset($_SESSION['exam'][$usrid])) {
    $examId = $_SESSION['exam'][$usrid]['id'];
    $result = $objgen->get_Onerow("exam_list", "AND id=" . $examId);

    $exam_name = $objgen->check_tag($result['exam_name']);
    $totno_of_qu = $objgen->check_tag($result['totno_of_qu']);
    $exam_neagive_mark = $objgen->check_tag($result['neagive_mark']);
    $examAttendedOn = date("Y-m-d H:i:s");
    $examQnAnsArr = $_SESSION['exam'][$usrid]['exam_qnAns'];
    if(empty($_SESSION['exam'][$usrid]['exam_creator'])){
        $examCreator = '';
    }else{
        $examCreator = $_SESSION['exam'][$usrid]['exam_creator'];
    }
    

    $correctAnsCount = 0;
    $wrongAnsCount = 0;
    $unanswerCount = 0;
    $totMark = 0;
    $negMark = 0;
    $i=0;
    $exmScoreTempId= time().mt_rand();
    if(count($examQnAnsArr)>0){
        foreach ($examQnAnsArr as $key => $valueArr) {
       
        $where        = "AND id=$key";
        $getQnMarkArr = $objgen->get_Onerow("question", $where, 'mark,negative_per,question_type,section');
        $qnMark       = $getQnMarkArr['mark'];
        $qnType       = $getQnMarkArr['question_type'];
        $qnSectionId  = $getQnMarkArr['section'];

        if ($exam_neagive_mark == 0) {
            $qnNegPer = 0;
        } else {
            if (!empty($exam_neagive_mark) || $exam_neagive_mark != -1) {
                $qnNegPer = $exam_neagive_mark;
            } else {
                $qnNegPer = $getQnMarkArr['negative_per'];
            }
        }
        
        
        if (is_array_empty($valueArr)) {
            $qnAttendStatus = 'answered';
            
            /*
             * here from calculation starts
             */
            $where = "AND question_id=$key AND right_ans='yes'";
            $getQnCorrectAns_count = $objgen->get_AllRowscnt("answer", $where);
            $getQnCorrectAnsArr = $objgen->get_AllRows("answer", 0, $getQnCorrectAns_count, "id asc", $where);
            $correctAnsId = array();
            $ansSts = '';
            foreach ($getQnCorrectAnsArr as $key1 => $value1) {
                $correctAnsId[] = $value1['id'];
                if ($qnType == 4 || $qnType == 7) {
                    $usrAns = strtolower($valueArr[0]);
                    $correctAns = strtolower($objgen->basedecode($value1['answer']));
                    if ($usrAns == $correctAns) {
                        $ansSts = 1;
                        break;
                    } else {
                        $ansSts = 0;
                    }
                }elseif($qnType == 1 || $qnType == 2 || $qnType == 8 || $qnType == 9){
                    $usrAns = $valueArr[0];
                    $correctAns = $value1['id'];
                    if ($usrAns == $correctAns) {
                        $ansSts = 1;
                        break;
                    } else {
                        $ansSts = 0;
                    }
                }elseif($qnType == 3){
                    $usrAns = '';
                    foreach ($valueArr as $k1 => $v1) {
                        $usrAns .= $v1 . ',';
                    }
                    $usrAns = rtrim($usrAns, ',');
                }elseif($qnType == 5 || $qnType == 6){
                    $usrAns = $valueArr[0];
                }
            }

            $correctAnsIds = '';
            foreach ($correctAnsId as $key2 => $value2) {
                $correctAnsIds .= $value2 . ',';
            }
            $correctAnsIds = rtrim($correctAnsIds, ',');
            if (empty($ansSts)) {
//                echo '*******************************************';
//                echo '<pre>';
//                echo '<br>correct ans array<br>';
//                print_r($correctAnsId);
//                echo '<br>given ans array<br>';
//                print_r($valueArr);

                if (is_array($valueArr))  {
                    $valueArr = $valueArr;
                }else{
                    $valueArr[]=$valueArr;
                }

                $ansArrDiff = array_diff($valueArr,$correctAnsId);
    //            echo '<br>array diff<br>';
    //            print_r($ansArrDiff);


                if (empty($ansArrDiff)) {
                    $ansSts = 1;
                } else {
                    $ansSts = 0;
                }
    //            echo 'answer sts:'.$ansSts.'(1=>correct,0=>wrong)';
    //            echo '</pre>';
    //            echo '*******************************************';
            }
            if ($ansSts == 1) {
                $ansMark = $qnMark;
                $correctAnsCount += 1;
                $totMark += $qnMark;
            } elseif ($ansSts == 0) {
                $ansMark = 0;
                $wrongAnsCount += 1;
                $negMark += ($qnNegPer / 100) * $qnMark;
            }
            /*
             * end of calculation
             */
            
            
        } else {
            $qnAttendStatus = 'unanswered';
            $unanswerCount += 1;
        }
        $lastTempId = $exmScoreTempId;
        $logIns = $objgen->ins_Row('user_exam_log', 'exam_score_id,user_id,exam_id,exam_created_by,qn_id,qn_section_id,user_ans,correct_answer,answer_status,qn_attend_status,exam_mark,exam_attended', "'$exmScoreTempId','$usrid','$examId','$examCreator','$key','$qnSectionId','$usrAns','$correctAnsIds','$ansSts','$qnAttendStatus','$ansMark','$examAttendedOn'");
        $getLastInsertLogId = $objgen->get_insetId();
    }
    }
    $grandTotalMark = $totMark - $negMark;

    
    $userScoreIns = $objgen->ins_Row('user_exam_score', 'user_id,exam_id,exam_created_by,correct_answer_num,wrong_answer_num,unanswered_num,exam_mark,exam_attended_on', "'$usrid','$examId','$examCreator','$correctAnsCount','$wrongAnsCount','$unanswerCount','$grandTotalMark','$examAttendedOn'");
    $getLastInsertId = $objgen->get_insetId();
    $getInsertedTempId = $objgen->get_Onerow('user_exam_log', "AND id='$getLastInsertLogId'", 'exam_score_id');
    $insertedTempId = $getInsertedTempId['exam_score_id'];
    $updateExamLog = $objgen->upd_Row('user_exam_log', "exam_score_id='$getLastInsertId'", "exam_score_id='$insertedTempId'");
    
   $exmPkgId = $_SESSION['exam'][$usrid]['exam_package'];
   $exmCountUpdate = $objgen->upd_Row('exam_permission', "exam_complete=exam_complete+1", "user_id='$usrid' AND package_id='$exmPkgId'");
   
   
   
} else {
    header('Location: ' . URLUR . 'exam-list.php');
}
//exit();
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

                            <div class="panel-body table-responsive" align="center">
                                <h3><?= $exam_name ?> Result</h3>
                                <div>Questions <?= $totno_of_qu ?></div>
                                <div>Correct Answer : <?= $correctAnsCount ?></div>
                                <div>Wrong Answer : <?= $wrongAnsCount ?></div>
                                <div>Unanswered : <?= $unanswerCount ?></div>
                                <div>Total Mark : <?= $grandTotalMark ?></div>

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
setcookie("timer_start_time", "", time() - (60 * 60 * 24));
setcookie("current_time", "", time() - (60 * 60 * 24));
setcookie("time_diff", "", time() - (60 * 60 * 24));
setcookie("counter_time", "", time() - (60 * 60 * 24));
unset($_SESSION['exam'][$usrid]);
?>