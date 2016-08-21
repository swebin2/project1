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
    $getExamId = $_GET['exam_id'];
    if(!empty($getExamId)){
        $getSectionByExamCnt = $objgen->get_AllRowscnt('section'," AND exam_id='$getExamId'");
        if($getSectionByExamCnt>0){
            $userExamSectionArr = $objgen->get_AllRows('section', 0, $getSectionByExamCnt, '', " AND exam_id='$getExamId'", '', 'id AS section_id');
        }

    }else{
        $userExamSectionArr = $objgen->getUserExamSection($usrid);
    }
    
    $sectionId = "";
    $totsecQnCount= 0;
    for($i=0;$i<count($userExamSectionArr);$i++){
        $sectionId      .= $userExamSectionArr[$i]['section_id'].',';
    }
    $sectionId = rtrim($sectionId, ',');
    
    
    /*
     * for all qn count with all difficulty
     */
    $where = " AND section IN($sectionId)";
    $getAllDiffQnCount = $objgen->get_AllRowscnt('question', $where);
    /*
     * for unused qncount with all difficulty
     */
    $where = " AND section IN ($sectionId) AND (qn_attend_status='unanswered')";
    $unansweredQnCount = $objgen->get_AllRowscnt('question_userexmlog',$where,'qn_id');
    /*
     * for incorrect qncount with all difficulty
     */
    $where = " AND section IN ($sectionId) AND (qn_attend_status='answered' AND (user_ans!=correct_answer))";
    $incorrectQnCount = $objgen->get_AllRowscnt('question_userexmlog',$where,'qn_id');
    /*
     * for incorrect+unused qncount with all difficulty
     */
    $where = " AND section IN ($sectionId) AND (qn_attend_status='unanswered' OR (user_ans!=correct_answer))";
    $inunQnCount = $objgen->get_AllRowscnt('question_userexmlog',$where,'qn_id');
    /*
     * for flagged qn count with all difficulty
     */
    $where = " AND section IN ($sectionId) AND user_id='$usrid' AND status='1'";
    $flaggedQnCount = $objgen->get_AllRowscnt('user_flag_question',$where);
                
//    exit();

if(isset($_POST['create'])){
    $date = date("Y-m-d");
    $exam_name = 'exam_'.$usrid.$date.rand(1, 1000);
    if($_POST['onoffswitch']=='on'){
        $exam_duration = $objgen->check_input($_POST['duration']);
    }  else {
        $exam_duration = 'Untimed';
    }
    
    $exam_totnumqns = $objgen->check_input($_POST['totqncnt']);
    if($_POST['exm_mode']=='practice'){
        $explanationStatus = 'yes';
    }else{
        $explanationStatus = 'no';
    }
    $msg = $objgen->ins_Row('user_exam_list','user_id,exam_name,duration,totno_of_qu,explanation,created_date',"'".$usrid."','".$exam_name."','".$exam_duration."','".$exam_totnumqns."','".$explanationStatus."','".$date."'");
    $insrt = $objgen->get_insetId();
    if($insrt){
        foreach ($_POST['section'] as $key => $value) {
            $sectionId = $value;
            $sectionQnCnt = $_POST['section_qn'][$sectionId];
            $msg = $objgen->ins_Row('user_section_list','user_id,section_id,no_of_qu,user_exam_list_id',"'".$usrid."','".$sectionId."','".$sectionQnCnt."','".$insrt."'");	 
            header("location:".$add_url2."/?id=$insrt&cat=user");
        }
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
                                    <form name="frm" action="" onsubmit="return validateForm()" method="post">
                                    <div class="col-md-3 col-lg-3">
                                        <nav class="segmented-button">
                                            <input type="radio" name="exm_mode" value="test" id="exm_mode_test" checked>
                                            <label for="exm_mode_test" class="first">Test Mode</label>
                                            
                                            <input type="radio" name="exm_mode" value="practice" id="exm_mode_practice">
                                            <label for="exm_mode_practice" class="last">Practice Mode</label>
                                        </nav>
                                        <div class="qn-filter-container">
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="all" id="exm_qn_filter_all" onclick="get_exam_section();" checked>
                                                <label for="exm_qn_filter_all" class="first">All Questions</label>
                                                <span class="num_qn" id="allDiffQnCount"><?= $getAllDiffQnCount ?></span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="unused" id="exm_qn_filter_unused" onclick="get_exam_section();" >
                                                <label for="exm_qn_filter_unused" class="first">Unused</label>
                                                <span class="num_qn" id="unansweredQnCount"><?= $unansweredQnCount ?></span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="incorrect" id="exm_qn_filter_incorrect" onclick="get_exam_section();" >
                                                <label for="exm_qn_filter_incorrect" class="first">Incorrect</label>
                                                <span class="num_qn" id="incorrectQnCount"><?= $incorrectQnCount ?></span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="inun" id="exm_qn_filter_inun" onclick="get_exam_section();" >
                                                <label for="exm_qn_filter_inun" class="first">Incorrect + Unused</label>
                                                <span class="num_qn" id="inunQnCount"><?= $inunQnCount ?></span>
                                            </span>
                                            <span class="qn-filter-col">
                                                <input type="radio" name="exm_qn_filter" value="flag" id="exm_qn_filter_flag" onclick="get_exam_section();" >
                                                <label for="exm_qn_filter_flag" class="first">Flagged</label>
                                                <span class="num_qn" id="flaggedQnCount"><?= $flaggedQnCount ?></span>
                                            </span>
                                        </div>
                                        <div class="diff-lvl-container">
                                            <p class="diff-lvl-head">Difficulty Level</p>
                                            <nav class="segmented-button">
                                                <input type="radio" name="exm_diff_lvl" onclick="get_exam_section();get_qncat_count()" value="all" id="exm_diff_lvl_all" checked>
                                                <label for="exm_diff_lvl_all" class="first">All</label>
                                                
                                                <input type="radio" name="exm_diff_lvl" onclick="get_exam_section();get_qncat_count()" value="easy" id="exm_diff_lvl_easy">
                                                <label for="exm_diff_lvl_easy">Easy</label>
                                                
                                                <input type="radio" name="exm_diff_lvl" onclick="get_exam_section();get_qncat_count()" value="average" id="exm_diff_lvl_avg">
                                                <label for="exm_diff_lvl_avg">Avg</label>

                                                <input type="radio" name="exm_diff_lvl" onclick="get_exam_section();get_qncat_count()" value="hard" id="exm_diff_lvl_hard">
                                                <label for="exm_diff_lvl_hard" class="last">Hard</label>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 section-list-container">
                                        
                                        <div id="ajx_section_load">
                                            <div class="qn-section-container">
                                                <?php
//                                                $userExamSectionArr = $objgen->getUserExamSection($usrid);
                                                $totsecQnCount= 0;
                                                for($i=0;$i<count($userExamSectionArr);$i++){
                                                    $sectionId      = $userExamSectionArr[$i]['section_id'];
                                                    $getSectionDetails = $objgen->get_Onerow('section', " AND id='$sectionId'", 'id,name');
                                                    $sectionName    = $getSectionDetails['name'];
                                                    $exmMode        = 'test';
                                                    $exmQnFilter    = 'all';
                                                    $exmDiffLevel   = 'all';
                                                    $where = ' AND section='.$sectionId;
                                                    $sectionQnCount = $objgen->get_AllRowscnt('question',$where);
                                                    $totsecQnCount += $sectionQnCount;

                                                ?>
                                                <span class="qn-section-col">
                                                    <input type="checkbox" name="section[]" class="maxqn_enable_cb" value="<?= $sectionId ?>" id="section_<?= $i ?>" onclick="selectChkbx(<?= $sectionQnCount ?>,this.value,$(this))">
                                                    <label for="section_<?= $i ?>" class="first"><?= $sectionName ?> (<?= $sectionQnCount ?>)</label>
                                                    <div class="max_qn">
                                                        <input type="text" class="num_section_qn" onchange="calc_tot_qn(this.value)" onblur="find_total_enterd_qn()" onkeyup="minmax(this.value, 0, <?= $sectionQnCount ?>,'section_qn<?= $sectionId ?>')" id="section_qn<?= $sectionId ?>" name="section_qn[<?= $sectionId ?>]">
                                                    </div>
                                                    
                                                </span>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-3 col-lg-3" style="text-align: center;padding-top: 10px;">
                                        <div class="qn_select_count_container btn btn-info">
                                            <p>Available</p>
                                            <p id="qn_select_count" class="qn_select_count">0</p>
                                            
                                        </div>
                                        <div class="exm_mark_container btn btn-warning">
                                            <p>Selected*</p>
                                            <p id="section_qn_count" class="qn_select_count">0</p>
                                            <input type="hidden" id="totqncnt" name="totqncnt" value="0">
                                            
                                        </div>
                                        <div class="chk_timer_container">
                                            <p>Timer</p>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                                <label class="onoffswitch-label" for="myonoffswitch">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                                <div class="max_exm_time">
                                                    <select id="duration" name="duration" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="00:01">00:01</option>
                                                        <option value="00:02">00:02</option>
                                                        <option value="00:03">00:03</option>
                                                        <option value="00:04">00:04</option>
                                                        <option value="00:05">00:05</option>
                                                        <option value="00:06">00:06</option>
                                                        <option value="00:07">00:07</option>
                                                        <option value="00:08">00:08</option>
                                                        <option value="00:09">00:09</option>
                                                        <option value="00:10">00:10</option>
                                                        <option value="00:11">00:11</option>
                                                        <option value="00:12">00:12</option>
                                                        <option value="00:13">00:13</option>
                                                        <option value="00:14">00:14</option>
                                                        <option value="00:15">00:15</option>
                                                        <option value="00:16">00:16</option>
                                                        <option value="00:17">00:17</option>
                                                        <option value="00:18">00:18</option>
                                                        <option value="00:19">00:19</option>
                                                        <option value="00:20">00:20</option>
                                                        <option value="00:21">00:21</option>
                                                        <option value="00:22">00:22</option>
                                                        <option value="00:23">00:23</option>
                                                        <option value="00:24">00:24</option>
                                                        <option value="00:25">00:25</option>
                                                        <option value="00:26">00:26</option>
                                                        <option value="00:2">00:27</option>
                                                        <option value="00:28">00:28</option>
                                                        <option value="00:29">00:29</option>
                                                        <option value="00:30">00:30</option>
                                                        <option value="00:31">00:31</option>
                                                        <option value="00:32">00:32</option>
                                                        <option value="00:33">00:33</option>
                                                        <option value="00:34">00:34</option>
                                                        <option value="00:35">00:35</option>
                                                        <option value="00:36">00:36</option>
                                                        <option value="00:37">00:37</option>
                                                        <option value="00:38">00:38</option>
                                                        <option value="00:39">00:39</option>
                                                        <option value="00:40">00:40</option>
                                                        <option value="00:41">00:41</option>
                                                        <option value="00:42">00:42</option>
                                                        <option value="00:43">00:43</option>
                                                        <option value="00:44">00:44</option>
                                                        <option value="00:45">00:45</option>
                                                        <option value="00:46">00:46</option>
                                                        <option value="00:47">00:47</option>
                                                        <option value="00:48">00:48</option>
                                                        <option value="00:49">00:49</option>
                                                        <option value="00:50">00:50</option>
                                                        <option value="00:51">00:51</option>
                                                        <option value="00:52">00:52</option>
                                                        <option value="00:53">00:53</option>
                                                        <option value="00:54">00:54</option>
                                                        <option value="00:55">00:55</option>
                                                        <option value="00:56">00:56</option>
                                                        <option value="00:57">00:57</option>
                                                        <option value="00:58">00:58</option>
                                                        <option value="00:59">00:59</option>
                                                        <option value="01:00">01:00</option>
                                                        <option value="01:15">01:15</option>
                                                        <option value="01:30">01:30</option>
                                                        <option value="01:45">01:45</option>
                                                        <option value="02:00">02:00</option>
                                                        <option value="02:15">02:15</option>
                                                        <option value="02:30">02:30</option>
                                                        <option value="02:45">02:45</option>
                                                        <option value="03:00">03:00</option>
                                                        <option value="03:15">03:15</option>
                                                        <option value="03:30">03:30</option>
                                                        <option value="Untimed">Untimed</option>
                                                   </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="margin_top_30">
                                            <button type="submit" class="btn btn-success" name="create">Start Exam</button>
                                        </div>
                                    </div>
                                    </form>
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
        <script type="text/javascript">
            
            $(document).ready(function () {
                $('div.max_qn').hide();
                $('input.maxqn_enable_cb').change(function(){

                   if ($(this).is(':checked')){
                       $(this).next().next('div.max_qn').show();
                   }
                   else{
                       $(this).next().next('div.max_qn').hide();
                   }
               });
               
                $('input.onoffswitch-checkbox').change(function(){

                   if ($(this).is(':checked')){
                       $(this).next().next('div.max_exm_time').show();
                   }
                   else{
                       $(this).next().next('div.max_exm_time').hide();
                   }
               });
               $("#qn_select_count").html(<?= $totsecQnCount ?>);
                    
            });
            function minmax(value, min, max,inp_id) 
            {
                $("#"+inp_id).val(Math.min(Math.max(min, value), max));
            }
            function get_exam_section(){
                $("#qn_select_count").html(0);
                $("#totqncnt").val(0);
                var exm_qn_filter = $("input[name='exm_qn_filter']:checked"). val();
                var exm_mode = $("input[name='exm_mode']:checked"). val();
                var exm_diff_lvl = $("input[name='exm_diff_lvl']:checked"). val();
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "<?= URLUR ?>ajax2.php",
                    data: {pid: 3, exm_qn_filter: exm_qn_filter,exm_mode: exm_mode,exm_diff_lvl: exm_diff_lvl,user_id: <?= $usrid ?>,exam_id:<?= $getExamId ?>},
                    success: function (result) {
                        $('#ajx_section_load').html(result);
                    }
                });
            }
            function get_qncat_count(){
                var exm_diff_lvl = $("input[name='exm_diff_lvl']:checked"). val();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "<?= URLUR ?>ajax2.php",
                    data: {pid: 4, exm_diff_lvl: exm_diff_lvl,user_id: <?= $usrid ?>,exam_id:<?= $getExamId ?>},
                    success: function (result) {
                        $('#allDiffQnCount').html(result["getAllDiffQnCount"]);
                        $('#unansweredQnCount').html(result["unansweredQnCount"]);
                        $('#incorrectQnCount').html(result["incorrectQnCount"]);
                        $('#inunQnCount').html(result["inunQnCount"]);
                        $('#flaggedQnCount').html(result["flaggedQnCount"]);
                    }
                });
                
            }
            function calc_tot_qn(num){
                var totqncnt=$('#totqncnt').val();
                totqn = parseInt(totqncnt);
                totqn+=parseInt(num);
//                $('#qn_select_count').html(totqn);
            }
            function find_total_enterd_qn(){
                var arr = document.querySelectorAll('input[id^="section_qn"]');
                var total=0;
                $(".num_section_qn").each(function(){
                    var th= $(this);
                    thval = parseInt(th.val());
                    if(isNaN(thval)){
                        thval = 0;
                    }else{
                        thval = thval;
                    }
                    total += thval;
                });
                $("#section_qn_count").html(total);
                $('#totqncnt').val(total);
                
            }
            function insrt_count(qty,id){
                $("#section_qn"+id).val(qty);
            }
            function selectChkbx(qty,id,t) {
                if (t.is(':checked')) {
                    $("#section_qn"+id).val(qty);
                    calc_tot_qn(qty);
                    find_total_enterd_qn();
                } else {
                  $("#section_qn"+id).val(0);
                  find_total_enterd_qn();
                }
            }
            function validateForm() {
                var x = document.forms["frm"]["totqncnt"].value;
                if (x == 0 || x == "") {
                    alert("Select atleast one question");
                    return false;
                }
            }
        </script>
    </body>
</html>
<?php

?>