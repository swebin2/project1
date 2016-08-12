<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen = new general();

//unset($_SESSION[$usrid]['exam']['id']);
//unset($_SESSION['exam'][$usrid]['qid']);
//echo $_SESSION['exam'][$usrid]['id'];
//doubt with this 2nd condition on 'if' statement
if (isset($_SESSION['exam'][$usrid]['id']) && empty($_SESSION['exam'][$usrid]['qid'])) {

    $qulist_arr = array();
    $_SESSION['exam'][$usrid]['qid'] = array();

    $id = $_SESSION['exam'][$usrid]['id'];
    if($_SESSION['exam'][$usrid]['exam_creator']=='user'){
        $result = $objgen->get_Onerow("user_exam_list", "AND id=" . $id);
    }else{
        $result = $objgen->get_Onerow("exam_list", "AND id=" . $id);
    }
    $exam_name = $objgen->check_tag($result['exam_name']);
    $group_id = $objgen->check_tag($result['group_id']);
    $exam_id = $objgen->check_tag($result['exam_id']);
    $duration = $objgen->check_tag($result['duration']);
//    $_SESSION['exam'][$usrid]['exam_duration'] = $duration;
    $neagive_mark = $objgen->check_tag($result['neagive_mark']);
    $avaibility = $objgen->check_tag($result['avaibility']);
    if($duration=='Untimed'){
        if(empty($_SESSION['exam'][$usrid]['exm_strat_time'])){
            $date = new DateTime();
            $_SESSION['exam'][$usrid]['exm_strat_time'] = $date->getTimestamp();
        }
        $examStarttime = $_SESSION['exam'][$usrid]['exm_strat_time'];
    }

    if ($result['start_date'] != "0000-00-00 00:00:00") {
        $start_date = date("d-m-Y H:i", strtotime($result['start_date']));
    }

    if ($result['end_date'] != "0000-00-00 00:00:00") {
        $end_date = date("d-m-Y H:i", strtotime($result['end_date']));
    }

    $exam_assign = $objgen->check_tag($result['exam_assign']);
    $link_add = $objgen->check_tag($result['link_add']);

    $totno_of_qu = $objgen->check_tag($result['totno_of_qu']);
    
    if($_SESSION['exam'][$usrid]['exam_creator']=='user'){
        $where = " and user_exam_list_id=" . $id;
        $secli_count = $objgen->get_AllRowscnt("user_section_list", $where);
    }else{
        $where = " and exam_list_id=" . $id;
        $secli_count = $objgen->get_AllRowscnt("section_list", $where);
    }
    if ($secli_count > 0) {
        if($_SESSION['exam'][$usrid]['exam_creator']=='user'){
            $secli_arr = $objgen->get_AllRows("user_section_list", 0, $secli_count, "id asc", $where);
        }else{
            $secli_arr = $objgen->get_AllRows("section_list", 0, $secli_count, "id asc", $where);
        }

        foreach ($secli_arr as $key => $val) {
            if ($group_id == 0 || $exam_id == 0) {
                $where = " and section='" . $val['section_id'] . "'";
            } else {

                $where = " and exam_group = '" . $group_id . "' and exam='" . $exam_id . "' and section='" . $val['section_id'] . "'";
            }
            
            $qu_count = $objgen->get_AllRowscnt("question", $where);
            if ($qu_count > 0) {
                $qu_arr = $objgen->get_AllRows("question", 0, $val['no_of_qu'], "rand()", $where);
                foreach ($qu_arr as $k => $v) {
                    $qulist_arr[] = $v['id'];
                }
            }
        }

        $_SESSION['exam'][$usrid]['qid'] = $qulist_arr;
    }
    $_SESSION['exam'][$usrid]['exam_name'] = $objgen->check_tag($result['exam_name']);
}

//print_r($_SESSION[$usrid]['exam']['id']);
//print_r($_SESSION['exam'][$usrid]['qid']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo TITLE; ?></title>

        <?php require_once "header-script.php"; ?>
        <?php require_once "footer-script.php"; ?>
        <link href="<?= URLUR ?>css/timer.css" rel="stylesheet">
        <link href="<?= URLUR ?>css/fieldChooser.css" rel="stylesheet">
        <link href="<?= URLUR ?>css/custom.css" rel="stylesheet">
        <link href="<?= URLUR ?>css/qn_flag.css" rel="stylesheet">
        

        <script src="js/jquery.cookie.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/dragnmatch.js"></script>
        <script>
            $(document).ready(function () {
                var $sourceFields = $("#sourceFields");
                var $destinationFields = $("#destinationFields");
                var $destiField = $(".destiField");
                var $chooser = $("#fieldChooser").fieldChooser($sourceFields, $destiField);

                $('#destinationFields div').sortable({
                    update: function (event, ui) {
                        var inpval = '';
                        $('.destiField div').each(function () {
                            var dataId = $(this).attr('id');
                            inpval += dataId + ',';
                        });
                        inpval = inpval.slice(0, -1);
                        $('#dm_ans').val(inpval);
                    }
                });
            });

        </script>
        <style>
            .rcorners1{
                background-color: #eff0f1;
                font-family: Consolas,Menlo,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New,monospace,sans-serif;
                font-size: 13px;
                margin-bottom: 1em;
                max-height: 600px;
                overflow: auto;
                padding: 15px;
                width: auto;
            }
        </style>
    </head>
    <body>
        <?php
        $examDuration = $_SESSION['exam'][$usrid]['exam_duration'];
        sscanf($examDuration, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
        ?>
        <script>
            if (!Date.now) {
                Date.now = function now() {
                    return new Date().getTime();
                };
            }
            var dt = Date.now();
            var time = dt;

            if ($.cookie('timer_start_time') == null || $.cookie('timer_start_time') == '') {
                var start_time = time;
                // set cookie  
                $.cookie('timer_start_time', start_time, {expires: 7});
                $.cookie('current_time', time);
                $.cookie('time_diff', 0);
            } else {
                $.cookie('current_time', time);
                var start = $.cookie('current_time'),
                        end = $.cookie('timer_start_time');
                var time_diff = (start - end) / 1000;
                time_diff = Math.floor(time_diff);
                $.cookie('time_diff', time_diff);
            }
            counter_time = (60 *<?= $time_seconds ?>) - $.cookie('time_diff');
            $.cookie('counter_time', counter_time);
        </script>
        <?php //require_once "header.php";    ?>

        <?php //require_once "menu.php";    ?>


        <!-- //////////////////////////////////////////////////////////////////////////// --> 
        <!-- START CONTENT -->
        <div class="content" style="margin:20px;padding-top: 0">
            <div id="top" style="margin-left: -30px !important;position: static;width: 105%;">

            <!-- Start App Logo -->
            <div class="applogo">
              <a class="logo" href="/sumesh/tricky/user/">Tricky Score</a>
            </div>
            <!-- End App Logo -->

          </div>
            <!-- //////////////////////////////////////////////////////////////////////////// --> 
            <!-- START CONTAINER -->
            <div class="container-default">

                <div class="row">

                    <div class="col-md-12 col-lg-12">
                      
                        <div class="col-md-12 col-lg-12">
                            <div class="col-md-8 col-lg-8"><h3><?= $_SESSION['exam'][$usrid]['exam_name'] ?></h3></div>
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
                            <div class="col-md-4 col-lg-4"><div id="clock"></div>
                                <div id="clocknew"></div>
                            </div>
                        </div>

                        <div id="ajax_div1">    

                            <div class="panel panel-widget">

                                <div class="panel-body table-responsive" style="width: 78%;float: left">

                                    <?php
                                    if (count($_SESSION['exam'][$usrid]['qid']) > 0) {
//                                        echo '<pre>';
//                                        print_r($_SESSION['exam'][$usrid]['qid']);
//                                        echo '</pre>';
                                        if (!isset($_SESSION['exam'][$usrid]['exam_first_attempt_sts'])) {
                                            $_SESSION['exam'][$usrid]['current_qn_num'] = 1;
                                            $_SESSION['exam'][$usrid]['current_qn_count'] = 0;
                                        } else {
                                            $_SESSION['exam'][$usrid]['current_qn_num'] = $_SESSION['exam'][$usrid]['current_qn_num'];
                                            $_SESSION['exam'][$usrid]['current_qn_count'] = $_SESSION['exam'][$usrid]['current_qn_count'];
                                        }


                                        $qnId = $_SESSION['exam'][$usrid]['qid'][$_SESSION['exam'][$usrid]['current_qn_count']];
                                        $result = $objgen->get_Onerow("question", "AND id=" . $qnId);


                                        $question_type = $result['question_type'];

                                        $where = " and question_id=" . $result['id'];
                                        $row_count2 = $objgen->get_AllRowscnt("answer", $where);
                                        if ($row_count2 > 0) {
                                            $res_arr2 = $objgen->get_AllRows("answer", 0, $row_count2, "id asc", $where);
                                            // $res_arr5 = $objgen->get_AllRows("answer",0,$row_count2,"rand()",$where);
                                        }

                                        if ($question_type == 1) {
                                            $qtyp = 'Multiple Choice (Radiobutton)';
                                        }


                                        if ($question_type == 2) {
                                            $qtyp = 'Multiple Choice (Dropdown)';
                                        }


                                        if ($question_type == 3) {
                                            $qtyp = 'Multiple Correct';
                                        }


                                        if ($question_type == 4) {
                                            $qtyp = 'Fill in the Blank';
                                        }


                                        if ($question_type == 5) {
                                            $qtyp = 'Drag and Match';
                                        }

                                        if ($question_type == 6) {
                                            $qtyp = 'Matching';
                                        }


                                        if ($question_type == 7) {
                                            $qtyp = 'Essay (Evaluated by Admin)';
                                        }


                                        if ($question_type == 8) {
                                            $qtyp = 'True/False';
                                        }


                                        if ($question_type == 9) {
                                            $qtyp = 'Yes/No';
                                        }
//                                        echo $question_type . '=>' . $qtyp;
                                        ?>
                                        <?php
                                        if ($result['direction_id'] != 0) {
                                            $dir_det = $objgen->get_Onerow("direction", "AND id=" . $result['direction_id']);
                                            ?>
                                            <div class="rcorners1" >
                                                <b>Direction:</b><?= $objgen->basedecode($dir_det['direction']) ?>
                                            </div>
                                            <br clear="all" />
                                            <?php
                                        }
                                        $question = $objgen->basedecode($result['question']);
                                        $question = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $question);
                                        $questionId = $result['id'];
                                        ?>
                                        <div><?php echo "<b>" . $_SESSION['exam'][$usrid]['current_qn_num'] . ".</b><span id='qn'> " . $question . "</span>"; ?></div>

                                        <br />
                                        <?php
                                        if ($question_type == 7) {
                                            ?>
                                            <form class="form-horizontal" role="form" id='login' method="post" action="">
                                                <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                                                <textarea class="form-control custom-control" rows="3" style="resize:none" name="ans"></textarea>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($row_count2 > 0) {

                                            if ($question_type == 1 || $question_type == 8 || $question_type == 9) {
                                                ?>
                                                <form class="form-horizontal" role="form" id='login' method="post" action="">   
                                                    <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                                                    <?php
                                                    foreach ($res_arr2 as $key2 => $val2) {

                                                        $cls = "info";
                                                        ?>
                                                        <div class="form-group"> <?= $alphas[$key2] ?>&nbsp;&nbsp;
                                                            <div class="radio radio-<?= $cls ?> radio-inline">

                                                                <input type="radio" class="ans"  value="<?= $val2['id'] ?>" id="answer<?= $key + 1 ?><?= $key2 + 1 ?>" name="answerrdo<?= $key + 1 ?>"  />

                                                                <label for="answer<?= $key + 1 ?><?= $key2 + 1 ?>">
                                                                    <?= $objgen->basedecode($val2['answer']) ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </form>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($question_type == 2) {
                                                ?>
                                                <form class="form-horizontal" role="form" id='login' method="post" action="">
                                                    <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                                                    <div class="form-group col-md-4">
                                                        <select name="ans" class="ans form-control" >
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($res_arr2 as $key2 => $val2) {
                                                                ?>
                                                                <option value="<?= $val2['id'] ?>"><?= $objgen->basedecode($val2['answer']) ?></option>

                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </form>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($question_type == 3) {
                                                ?>
                                                <form class="form-horizontal" role="form" id='login' method="post" action="">
                                                    <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                                                    <?php
                                                    foreach ($res_arr2 as $key2 => $val2) {

                                                        $cls = "info";
                                                        ?>
                                                        <div class="form-group"> <?= $alphas[$key2] ?>&nbsp;&nbsp;
                                                            <div class="checkbox checkbox-<?= $cls ?> checkbox-inline">

                                                                <input class="ans[]" type="checkbox"  value="<?= $val2['id'] ?>" id="chkanswer<?= $key + 1 ?><?= $key2 + 1 ?>" name="answerchk<?= $key + 1 ?>[]"  />

                                                                <label for="chkanswer<?= $key + 1 ?><?= $key2 + 1 ?>">
                                                                    <?= $objgen->basedecode($val2['answer']) ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </form>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($question_type == 4) {
                                                ?>     
                                                <form class="form-horizontal" role="form" id='login' method="post" action="">
                                                    <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                                                    <div>

                                                        <input name="answerfill"  class="ans form-control" value="" >
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($question_type == 6) {
                                                ?>
                                                <form class="form-horizontal" role="form" id='login' method="post" action="">
                                                    <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                                                    <?php
                                                    $answermatch = array();
                                                    $pair = array();
                                                    $pair2 = array();
                                                    $corrans = array(); 
                                                    
                                                    foreach ($res_arr2 as $key2 => $val2) {


                                                        $ans = $objgen->basedecode($val2['answer']);
                                                        $ansty = $objgen->get_Onerow("answer", "AND question_id=" . $val2['question_id'] . " and curr_order_id =" . $val2['match_id']);
                                                        $corrans[$key2] = $objgen->basedecode($ansty['answer']);

                                                        if (!in_array($ans, $corrans)) {
                                                            $pair[$key2] = $ans;
                                                        } else {
                                                            $pair2[] = $ans;
                                                        }
                                                    }

                                                    @shuffle($pair2);
                                                    foreach ($pair as $key3 => $val3) {
                                                        ?>
                                                        <div class="row" >
                                                            <div class="form-group" style="clear:both"> 
                                                                <div class="col-md-3"  style="margin:5px;" >
                                                                    <?= $alphas[$key3] ?>&nbsp;&nbsp;<?= $val3 ?>
                                                                </div>
                                                                <div class="col-md-2" style="margin:5px;">
                                                                    <i class='fa fa-long-arrow-right'></i>
                                                                </div>
                                                                <div class="col-md-3" style="margin:5px;">
                                                                    <select name="ans" class="ans form-control" >
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        foreach ($pair2 as $key2 => $val2) {
                                                                            ?>
                                                                            <option value="<?= $val2 ?>"><?= $val2 ?></option>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </form>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($question_type == 5) {
                                                ?>
                                                <form class="form-horizontal" role="form" id='login' method="post" action="">
                                                    <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                                                    <?php
                                                    $answermatch = array();
                                                    $pair = array();
                                                    $pair2 = array();
                                                    $corrans = array(); 
                                                    
                                                    foreach ($res_arr2 as $key2 => $val2) {

                                                        $ans = $objgen->basedecode($val2['answer']);

                                                        $ansty = $objgen->get_Onerow("answer", "AND question_id=" . $val['id'] . " and  	curr_order_id =" . $val2['match_id']);
                                                        $corrans[$key2] = $objgen->basedecode($ansty['answer']);

                                                        if (!in_array($ans, $corrans)) {
                                                            $pair[$key2] = $ans;
                                                        } else {
                                                            $pair2[] = $ans;
                                                        }
                                                    }

                                                    //print_r($pair2);

                                                    @shuffle($pair2);

                                                    //print_r($pair2);
                                                    $m = 0;
//                                                    foreach ($pair as $key3 => $val3) {
                                                    ?>
                                                    <!--                                                        <div class="row" >
                                                                                                                <div class="form-group" style="clear:both"> 
                                                    
                                                                                                                    <div class="col-md-1" style="margin:5px;">
                                                    <?= $alphas[$key3] ?>&nbsp;&nbsp;
                                                                                                                    </div>
                                                                                                                    <div class="col-md-3"  style="margin:5px;" >
                                                                                                                        <div class="dragdrop2"  ondragstart="drag(event)" name="<?= $corrans[$key3] ?>" draggable="true"  id="drg<?= $key3 ?>"   >
                                                                                                                            <div style="position:absolute;padding:5px;">
                                                    <?= $val3 ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col-md-1" style="margin:5px;">
                                                                                                                        <i class='fa fa-long-arrow-right'></i>
                                                                                                                    </div>
                                                                                                                    <div class="col-md-3" style="margin:5px;">
                                                    
                                                                                                                        <div class="dragdrop"  ondrop="drop(event)" ondragover="allowDrop(event)" id="<?= $pair2[$m] ?>" >
                                                                                                                            <div style="position:absolute;padding:5px;">
                                                    <?= $pair2[$m] ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                    
                                                                                                                    </div>
                                                    
                                                    
                                                                                                                </div>
                                                                                                            </div>-->
                                                    <?php
//                                                        $m++;
//                                                    }
                                                    ?>
                                                    <link href="css/fieldChooser.css" rel="stylesheet">
                                                    <div id="fieldChooser" tabIndex="1">
                                                        <div id="sourceFields">
                                                            <div id="1">First name</div>
                                                            <div id="2">Last name</div>
                                                            <div id="3">Home</div>
                                                            <div id="4">Work</div>
                                                        </div>
                                                        <div id="destinationFields">
                                                            <div class="destiField">
                                                                
                                                            </div>
                                                        </div>
                                                        <div id="staticFields" class="fc-field-list fc-static-fields" style="float: left">

                                                            <div class="fc-field">First name Field</div>
                                                            <div class="fc-field">Last name Field</div>
                                                            <div class="fc-field">Home Field</div>
                                                            <div class="fc-field">Work Field</div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="dm_ans" name="ans" value="">
                                                </form>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                        }
                                        ?>



                                        <?php
                                        if ($result['quest_det'] != "") {
                                            ?> 
                                            <div style="clear:both"></div>
                                            <hr />
                                            <div class="rcorners1" style="clear:both" >
                                                <b> Explanation :</b> <?php echo $objgen->basedecode($result['quest_det']); ?>
                                            </div>
                                            <br />
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    } else {
                                        echo '<p>No questions found for this exam.</p>';
                                    }
                                    ?>


                                </div>
                                <div class="qn_panel">
                                    <ul>
                                        <?php
                                        for($i=0;$i<count($_SESSION['exam'][$usrid]['qid']);$i++){
                                            if(!empty($_SESSION['exam'][$usrid]['exam_qnSts'])){
                                                if (array_key_exists($_SESSION['exam'][$usrid]['qid'][$i], $_SESSION['exam'][$usrid]['exam_qnSts'])) {

                                                    if($_SESSION['exam'][$usrid]['exam_qnSts'][$_SESSION['exam'][$usrid]['qid'][$i]]==0){
                                                        $style = "background: red";
                                                    }else{
                                                        $style = "background: green";
                                                    }
                                                }else{
                                                    $style = '';
                                                }
                                            }
                                        ?>
                                        <li style="<?= $style ?>"><a href="javascript:void(0)" onclick="examqn(<?= $i ?>)"><?= $i+1 ?></a></li>
                                        <?php
                                        }
                                        ?>
                                        
                                    </ul>
                                    <div class="qn_color_hint_container">
                                        <p class="qn_color_hint_col"><span class="qn_color_hint redbg"></span> <span class="qn_hint">Unanswered Question</span></p>
                                        <p class="qn_color_hint_col"><span class="qn_color_hint greenbg"></span> <span class="qn_hint">Answered Question</span></p>
                                        <p class="qn_color_hint_col"><span class="qn_color_hint greybg"></span> <span class="qn_hint">Pending Question</span></p>
                                    </div>
                                </div>
                            </div>
                            
                            <br clear="all" />
                            <div align="right">
                                                                
                                <div style="float: left;margin-right: 50px">
                                    <?php
                                    $chkFlag = $objgen->chk_Ext("question_flag", "user_id='$usrid' AND que_id='$questionId' AND status=1");
                                    if($chkFlag>0){
                                        $checked = 'checked';
                                    }else{
                                        $checked='';
                                    }
                                    ?>
                                    Flag &nbsp
                                    <div class="material-switch pull-right">
                                        <input id="someSwitchOptionSuccess" name="qn_flag" value="1" onclick="flagqn(<?= $questionId ?>)" <?= $checked ?> type="checkbox"/>
                                        <label for="someSwitchOptionSuccess" class="label-success"></label>
                                    </div>
                                </div>
                                <?php
                                if (count($_SESSION['exam'][$usrid]['qid']) == 0) {
                                    ?>
                                    <a href="javascript:void(0);" role="button" class="btn btn-success" onClick="examnfinish()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Finish</a>
                                    <?php
                                } else {
                                    if ($_SESSION['exam'][$usrid]['current_qn_count'] == 0) {
                                        ?>
                                        <a href="javascript:void(0);" role="button" style="float: left" class="btn btn-warning" onClick="examndrop()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Drop Exam</a>
                                        <a href="javascript:void(0);" role="button" class="btn btn-success" onClick="examnext()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Next</a>

                                        <?php
                                    } elseif ($_SESSION['exam'][$usrid]['current_qn_count'] > 0 && $_SESSION['exam'][$usrid]['current_qn_count'] < count($_SESSION['exam'][$usrid]['qid']) - 1) {
                                        ?>
                                        <a href="javascript:void(0);" role="button" style="float: left" class="btn btn-warning" onClick="examndrop()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Drop Exam</a>
                                        <a href="javascript:void(0);" role="button" class="btn btn-success" onClick="examnprev()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Previous</a>
                                        <a href="javascript:void(0);" role="button" class="btn btn-success" onClick="examnext()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Next</a>

                                        <?php
                                    } elseif ($_SESSION['exam'][$usrid]['current_qn_count'] == (count($_SESSION['exam'][$usrid]['qid']) - 1)) {
                                        ?>
                                        <a href="javascript:void(0);" role="button" class="btn btn-success" onClick="examnprev()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Previous</a>
                                        <a href="javascript:void(0);" role="button" class="btn btn-success" onClick="examnfinish()" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Finish</a>
                                        <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>

                        <br clear="all" />
                    </div>
                </div>
            </div>


            <!-- END CONTAINER -->
            <!-- //////////////////////////////////////////////////////////////////////////// --> 


            <!-- Start Footer -->
            <?php require_once "footer.php";      ?>
            <!-- End Footer -->


        </div>
        <!-- End Content -->
        <!-- //////////////////////////////////////////////////////////////////////////// --> 

        <script type="text/javascript" src="<?= URLUR ?>js/datatables/datatables.min.js"></script>

        <script src="js/jquery.countdown.js"></script>
        <script>
            <?php
            if($duration!='Untimed'){
            ?>
                                    var timer_start_time = parseInt($.cookie('timer_start_time'));
                                    var addSeconds = (60 *<?= $time_seconds ?>) * 1000;
                                    var countdown_time = timer_start_time + addSeconds;
                                    $('#clock').countdown(countdown_time, {elapse: true})
                                            .on('update.countdown', function (event) {
                                                var $this = $(this);

                                                if (event.elapsed) {
                                                    window.location.replace("<?= URLUR . "exam-finish" ?>");
                                                } else {
                                                    $this.html(event.strftime('<div id="clockdiv"><div>    <span class="hours">%H</span>    <div class="smalltext">Hours</div>  </div>  <div>    <span class="minutes">%M</span>    <div class="smalltext">Minutes</div>  </div>  <div>    <span class="seconds">%S</span>    <div class="smalltext">Seconds</div>  </div></div>'));
                                                }
                                            });
                                       <?php
            }else{
                                       ?>
                                    var fiveSeconds =  new Date().getTime();
                                    $('#clock').countdown(fiveSeconds, {elapse: true})
                                        .on('update.countdown', function(event) {
                                            var $this = $(this);
                                            if (event.elapsed) {
                                            $this.html(event.strftime('<div id="clockdiv"><div>    <span class="hours">%H</span>    <div class="smalltext">Hours</div>  </div>  <div>    <span class="minutes">%M</span>    <div class="smalltext">Minutes</div>  </div>  <div>    <span class="seconds">%S</span>    <div class="smalltext">Seconds</div>  </div></div>'));
                                            } else {
                                            
                                            }
                                    });
                                    <?php
            }
                                    ?>
                                    function examqn(k)
                                    {
                                        var str = $("form").serialize();
//                                            alert(str);
                                        $.ajax({
                                            type: "POST",
                                            dataType: "html",
                                            url: "<?= URLUR ?>ajax2.php",
                                            data: {pid: 1, action: 'qnum', user_id: <?= $usrid ?>, str: str,key: k},
                                            success: function (result) {

                                                $('#ajax_div1').html(result);


                                            }
                                        });

                                    }
                                    function examnext()
                                    {
                                        var str = $("form").serialize();
//                                            alert(str);
                                        $.ajax({
                                            type: "POST",
                                            dataType: "html",
                                            url: "<?= URLUR ?>ajax2.php",
                                            data: {pid: 1, action: 'nxt', user_id: <?= $usrid ?>, str: str},
                                            success: function (result) {

                                                $('#ajax_div1').html(result);


                                            }
                                        });

                                    }
                                    function examnprev()
                                    {
                                        var str = $("form").serialize();
                                        $.ajax({
                                            type: "POST",
                                            dataType: "html",
                                            url: "<?= URLUR ?>ajax2.php",
                                            data: {pid: 1, action: 'prev', user_id: <?= $usrid ?>, str: str},
                                            success: function (result) {

                                                $('#ajax_div1').html(result);


                                            }
                                        });

                                    }
                                    function examnfinish()
                                    {
                                        var str = $("form").serialize();
                                        $.ajax({
                                            type: "POST",
                                            dataType: "html",
                                            url: "<?= URLUR ?>ajax2.php",
                                            data: {pid: 1, action: 'prev', user_id: <?= $usrid ?>, str: str},
                                            success: function (result) {

                                                window.location.replace("<?= URLUR . "exam-finish" ?>");


                                            }
                                        });

                                    }
                                    function flagqn(qn_id)
                                    {
                                        $('#someSwitchOptionSuccess').val(1);
                                        $('#someSwitchOptionSuccess:not(:checked)').each(function () {
                                            // set value 0 and check it
                                            $(this).attr('checked', true).val(0);
                                        });
                                        var flagval = document.getElementById("someSwitchOptionSuccess").value;
                                        $.ajax({
                                            type: "POST",
                                            dataType: "html",
                                            url: "<?= URLUR ?>ajax2.php",
                                            data: {pid: 2, user_id: <?= $usrid ?>, qn_id: qn_id,action: flagval},
                                            success: function (result) {

                                            }
                                        });

                                    }
                                    function examndrop()
                                    {
                                        var result = confirm("Want to drop the exam?");
                                        if (result) {
                                            window.location.replace("<?= URLUR . "exam-drop" ?>");
                                        }

                                    }

        </script>

    </body>
</html>