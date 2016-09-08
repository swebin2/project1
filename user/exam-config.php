<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen = new general();
$pagehead = "Exam";
$list_url = URLUR."manage-exam";
$add_url  = URLUR."exam-manager";
$add_url2  = URLUR."exam-start";
if($_GET['msg']==1)
{
  $msg2 = "Exam Created Successfully.";
}

$usrid = $_SESSION['ma_log_id'];
$getUserInfo = $objgen->get_Onerow("users", " AND id='$usrid'");

$getAvailUserPackageCount = $objgen->get_AllRowscnt('exam_permission'," AND user_id='$usrid' AND status='active'");

$getAllExamsCount = $objgen->get_AllRowscnt('exmas'," AND id IN (SELECT exam_id FROM `exam_permission` WHERE user_id='$usrid' AND status='active')");
if($getAllExamsCount>0){
    $getAllExams = $objgen->get_AllRows('exmas',0,$getAllExamsCount,''," AND id IN (SELECT exam_id FROM `exam_permission` WHERE user_id='$usrid' AND status='active')");
}
if(isset($_POST['create'])){
    $date = date("Y-m-d");
    $examId = $_POST['exam'];
    $getExamInfo = $objgen->get_Onerow("exmas", " AND id='$examId'");
    $getSectionByExamCnt = $objgen->get_AllRowscnt('section'," AND exam_id='$examId'");
    if($getSectionByExamCnt>0){
        $getSectionByExam = $objgen->get_AllRows('section', 0, $getSectionByExamCnt, '', " AND exam_id='$examId'", '', 'id');
    }
    $exam_duration = $objgen->check_input($_POST['duration']);
    $exam_totnumqns = $objgen->check_input($_POST['no_of_qu']);
    $qnAvg = $exam_totnumqns/$getSectionByExamCnt;
    $explanationStatus = 'no';
    $msg = $objgen->ins_Row('user_exam_list','user_id,duration,totno_of_qu,explanation,created_mode,status,created_date',"'".$usrid."','".$exam_duration."','".$exam_totnumqns."','".$explanationStatus."','system','active','".$date."'");
    $insrt = $objgen->get_insetId();
    $exam_name = 'System Gen '.$getExamInfo['exam_name'].' '.$getUserInfo['full_name'].' '.$insrt;
    $exam_name = ucwords($exam_name);
    $updateExmName = $objgen->upd_Row('user_exam_list', "exam_name='$exam_name'", "id='$insrt'");
    $totAssignedQns = 0;
    for($i=0;$i<$getSectionByExamCnt;$i++){
        $sectionId = $getSectionByExam[$i]['id'];
        if($i==($getSectionByExamCnt-1)){
            $sectoinNumQn=$exam_totnumqns-$totAssignedQns;
        }else{
            $sectoinNumQn = ceil($qnAvg);
        }
        $msg = $objgen->ins_Row('user_section_list','user_id,section_id,no_of_qu,user_exam_list_id',"'".$usrid."','".$sectionId."','".$sectoinNumQn."','".$insrt."'");
        $totAssignedQns+=$sectoinNumQn;
    }
    header("location:".$add_url2."/?id=$insrt&cat=user");
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
                                <?php
                                    if($msg2!="")
                                    {
                                    ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <b>Alert!</b> <?php echo $msg2; ?>
                                    </div>
                                 
                                    <?php
                                    }
                                    ?>
                                <?php
                                if($getAvailUserPackageCount>0){
                                ?>
                                <form method="post" name="frm" action="">
                                    <div class="col-md-12 col-lg-12">

                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="input3">Select Exam *</label>
                                                    <select required="" id="exam" name="exam" class="form-control">
                                                        <option selected="selected" value="">Select</option>
                                                        <?php
                                                        if(!empty($getAllExams)){
                                                            foreach ($getAllExams as $k=>$v){
                                                                $examId = $v['id'];
                                                                $examName = $v['exam_name'];
                                                                echo "<option selected='selected' value='$examId'>$examName</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="input3">Select Exam Generation Mode *</label>
                                                    <nav class="segmented-button" style="background: none;text-align: left;padding: 0px;margin: 0px;">
                                                        <input type="radio" name="exm_gen_mode" value="system" id="exm_gen_mode_system" checked="">
                                                        <label for="exm_gen_mode_system" class="first">System Generated</label>

                                                        <input type="radio" name="exm_gen_mode" value="manual" id="exm_gen_mode_manual">
                                                        <label for="exm_gen_mode_manual" class="last">Manual</label>
                                                    </nav>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-lg-4">
                                                <div class="form-group" id="exm_gen_act">
                                                    <p style="padding: 0px;margin: 0px;">&nbsp;</p>
                                                    <a href="javascript:;" onclick="chk_exm_gen_action($('input[name=exm_gen_mode]:checked').val())" name="create" class="btn btn-default"><span class="fa fa-save"></span>&nbsp;Continue</a>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <div id="dyn_field"></div>
                                    </div>
                                </form>
                                <?php
                                }else{
                                    echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <b>Alert!</b> There is no active package is available for you. Please buy a package and continue...
                                    </div>';
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
        <script type="text/javascript" src="<?= URLUR ?>js/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?= URLUR ?>js/jquery.redirect.js"></script>
        <script type="text/javascript">
            function chk_exm_gen_action(exm_gen_mode){
                if(exm_gen_mode=='system'){
                    <?php
                        $chkSystemGenExamExist = $objgen->chk_Ext("user_exam_list", " user_id='$usrid' AND created_mode='system' AND status='active'", 'id');
                        if($chkSystemGenExamExist>0){
                            $examExistsStatus = 1;
                        }else{
                            $examExistsStatus = 0;
                        }
                    ?>
                    var exam_exists_status = <?= $examExistsStatus ?>;
                    if(exam_exists_status==1){
                        alert("System Generated Exam is already exists. You can not create multiple system generated exam.");
                    }else{
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: "<?= URLUR ?>ajax2.php",
                            data: {pid: 6},
                            success: function (result) {
                                $('#exm_gen_act').html('');
                                 $('label.first').css('color', '#000');
                                $('input[name=exm_gen_mode]').attr('disabled',true);
                                $('#dyn_field').html(result);
                            }
                        });
                    }
                }else if(exm_gen_mode=='manual'){
                    exam_id = $('#exam').val();
//                    window.location = 'exam-manager/?exam_id=' + exam_id;
                    $.redirect('exam-manager', {'exam_id': exam_id});
                }
            }
        </script>
    </body>
</html>
<?php

?>