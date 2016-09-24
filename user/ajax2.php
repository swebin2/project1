<?php
require_once "includes/includepath.php";
$objgen = new general();

if ($_POST['pid'] == 1) {

    $usrid = $_POST['user_id'];
    $userAction = $_POST['action'];
    $keynum = $_POST['key'];

    $qnAnsStr = $_POST['str'];

    $pieces = explode("&", $qnAnsStr);

    $examId = $_SESSION['exam'][$usrid]['id'];
    if ($_SESSION['exam'][$usrid]['exam_creator'] == 'user') {
        $examListArr = $objgen->get_Onerow("user_exam_list", "AND id=" . $examId);
    } else {
        $examListArr = $objgen->get_Onerow("exam_list", "AND id=" . $examId);
    }

    $qnStr = $pieces[0];
    $qnPieces = explode("=", $qnStr);
    $qnId = $qnPieces[1];
//    $ansId[] = '';
    for ($i = 1; $i <= (count($pieces) - 1); $i++) {
        $ansStr = $pieces[$i];
        $ansPieces = explode("=", $ansStr);
        $ansId[] = $ansPieces[1];
    }
    //to chk array is empty
    if (is_array($ansId)) {
        $chkansIdArr = array_filter($ansId);
    } else {
        $chkansIdArr = $ansId;
    }

    if (!empty($qnId)) {
        if (!empty($chkansIdArr)) {
            $_SESSION['exam'][$usrid]['exam_qnSts'][$qnId] = '1';
        } else {
            $_SESSION['exam'][$usrid]['exam_qnSts'][$qnId] = '0';
        }

        $_SESSION['exam'][$usrid]['exam_qnAns'][$qnId] = $ansId;
    }
    ?>
    <div class="panel panel-widget">

        <div class="panel-body table-responsive" style="width: 78%;float: left">

            <?php
            $_SESSION['exam'][$usrid]['exam_first_attempt_sts'] = 0;
            if ($userAction == 'nxt') {
                $_SESSION['exam'][$usrid]['current_qn_num'] = $_SESSION['exam'][$usrid]['current_qn_num'] + 1;
                $_SESSION['exam'][$usrid]['current_qn_count'] = $_SESSION['exam'][$usrid]['current_qn_count'] + 1;
            } elseif ($userAction == 'prev') {
                $_SESSION['exam'][$usrid]['current_qn_num'] = $_SESSION['exam'][$usrid]['current_qn_num'] - 1;
                $_SESSION['exam'][$usrid]['current_qn_count'] = $_SESSION['exam'][$usrid]['current_qn_count'] - 1;
            } elseif ($userAction == 'qnum') {
                $_SESSION['exam'][$usrid]['current_qn_num'] = $keynum + 1;
                $_SESSION['exam'][$usrid]['current_qn_count'] = $keynum;
            }

            $_SESSION['exam'][$usrid]['current_qn_count'];
//            echo '<pre>';
//            print_r($_SESSION['exam'][$usrid]['qid']);
//            echo '</pre>';
//            echo 'key: ' . $_SESSION['exam'][$usrid]['current_qn_count'];
            $result = $objgen->get_Onerow("question", "AND id=" . $_SESSION['exam'][$usrid]['qid'][$_SESSION['exam'][$usrid]['current_qn_count']]);

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
//            echo $question_type . '=>' . $qtyp;
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
            <div><?php echo "<b>" . $_SESSION['exam'][$usrid]['current_qn_num'] . ".</b> " . $question ?></div>

            <br />
            <?php
            if ($question_type == 7) {
                ?>
                <form class="form-horizontal" role="form" id='login' method="post" action="">
                    <input type="hidden" name="qn_id" value="<?= $result['id']; ?>">
                    <textarea class="form-control custom-control" rows="3" style="resize:none" name="ans"><?= $_SESSION['exam'][$usrid]['exam_qnAns'][$result['id']][0] ?></textarea>
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

                                    <input type="radio" 
                                        <?php
                                        if($_SESSION['exam'][$usrid]['exam_qnAns'][$result['id']][0]==$val2['id']){
                                            echo 'checked';
                                        }
                                        ?>
                                    value="<?= $val2['id'] ?>" id="answer<?= $key + 1 ?><?= $key2 + 1 ?>" name="answerrdo<?= $key + 1 ?>"  />

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
                            <select name="ans" class="form-control" >
                                <option value="">Select</option>
                                <?php
                                foreach ($res_arr2 as $key2 => $val2) {
                                    
                                    ?>
                                    <option
                                        <?php
                                        if($_SESSION['exam'][$usrid]['exam_qnAns'][$result['id']][0]==$val2['id']){
                                            echo 'selected';
                                        }
                                        ?>
                                        value="<?= $val2['id'] ?>"><?= $objgen->basedecode($val2['answer']) ?></option>

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

                                    <input type="checkbox"
                                           <?php
                                        if($_SESSION['exam'][$usrid]['exam_qnAns'][$result['id']][0]==$val2['id']){
                                            echo 'checked';
                                        }
                                        ?>
                                           value="<?= $val2['id'] ?>" id="chkanswer<?= $key + 1 ?><?= $key2 + 1 ?>" name="answerchk<?= $key + 1 ?>"  />

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

                            <input name="answerfill"  class="form-control" value="<?= $_SESSION['exam'][$usrid]['exam_qnAns'][$result['id']][0] ?>" >
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

                        foreach ($res_arr2 as $key2 => $val2) {


                            $ans = $objgen->basedecode($val2['answer']);
                            $ansty = $objgen->get_Onerow("answer", "AND question_id=" . $val2['question_id'] . " and  	curr_order_id =" . $val2['match_id']);
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
                                        <select name="ans" class="form-control" >
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

                        foreach ($res_arr2 as $key2 => $val2) {

                            $ans = $objgen->basedecode($val2['answer']);

                            $ansty = $objgen->get_Onerow("answer", "AND question_id=" . $result['id'] . " and  	curr_order_id =" . $val2['match_id']);
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
                        
                        ?>
                        <div id="workarea">
                                                        <div style="width: 165px;float: left">
                                                            <?php
                                                            
                                                            foreach ($pair as $key3 => $val3) {
                                                            ?>
                                                            <div class="player"><?= $val3 ?></div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-lg-offset-2" style="width: 165px;float: left">
                                                            <?php
                                                            
                                                            foreach ($pair as $key3 => $val3) {
                                                            ?>
                                                            <div class="slot">
                                                                <span class="hidden-xs fa fa-arrow-circle-right" style="font-size:140%;float: left"></span>Drop Here
                                                            </div>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                        <div style="width: 165px;float: left">
                                                            <?php
                                                            $m = 0;
                                                            foreach ($pair as $key3 => $val3) {
                                                            ?>
                                                            <div class="slot2"><?= $pair2[$m]; ?></div>
                                                            <?php
                                                            $m++;
                                                            }
                                                            ?>
                                                            
                                                        </div>


                                                    </div>
                                                    <input type="hidden" id="dm_ans" name="ans" value="">
                                                    <script>
                                                        var config = {filter: 'raw'};
                                                        config.filter = 'raw';
                                                        YUI(config).use('dd-drop', 'dd-proxy', 'dd-constrain', function (Y) {

                                                            var slots = Y.one('#workarea').all('.slot');
                                                            Y.each(slots, function (v, k) {
                                                                var id = v.get('id'), groups = ['two'];
                                                                //        switch (id) {
                                                                //            case 't1':
                                                                //            case 't2':
                                                                //                groups = ['one'];
                                                                //                break;
                                                                //        }
                                                                var drop = new Y.DD.Drop({
                                                                    node: v,
                                                                    groups: groups
                                                                });
                                                            });

                                                            var players = Y.one('#workarea').all('.player');
                                                            Y.each(players, function (v, k) {
                                                                var id = v.get('id'), groups = ['one', 'two'];
                                                                //        switch (id) {
                                                                //            case 'pt1':
                                                                //            case 'pt2':
                                                                //                groups = ['one'];
                                                                //                break;
                                                                //            case 'pb1':
                                                                //            case 'pb2':
                                                                //                groups = ['two'];
                                                                //                break;
                                                                //        }
                                                                var drag = new Y.DD.Drag({
                                                                    node: v,
                                                                    groups: groups,
                                                                    dragMode: 'intersect'
                                                                }).plug(Y.Plugin.DDProxy, {
                                                                    moveOnEnd: false
                                                                }).plug(Y.Plugin.DDConstrained, {
                                                                    constrain2node: '#workarea'
                                                                });
                                                                drag.on('drag:start', function () {
                                                                    var p = this.get('dragNode'),
                                                                            n = this.get('node');
                                                                    n.setStyle('opacity', .25);
                                                                    if (!this._playerStart) {
                                                                        this._playerStart = this.nodeXY;
                                                                    }
                                                                    p.set('innerHTML', n.get('innerHTML'));
                                                                    p.setStyles({
                                                                        backgroundColor: n.getStyle('backgroundColor'),
                                                                        color: n.getStyle('color'),
                                                                        opacity: .65
                                                                    });
                                                                });
                                                                drag.on('drag:end', function () {
                                                                    var n = this.get('node');
                                                                    n.setStyle('opacity', '1');
                                                                });
                                                                drag.on('drag:drophit', function (e) {
                                                                    var xy = e.drop.get('node').getXY();
                                                                    this.get('node').setXY(xy, Y.UA.ie);
                                                                });
                                                                drag.on('drag:dropmiss', function (e) {
                                                                    if (this._playerStart) {
                                                                        this.get('node').setXY(this._playerStart, Y.UA.ie);
                                                                        this._playerStart = null;
                                                                    }
                                                                });
                                                            });
                                                        });
                                                    </script>
                    </form>
                    <?php
                }
                ?>

                <?php
            }
            ?>



            <?php
            if ($examListArr['explanation'] == "yes") {
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


        </div>
        <div class="qn_panel">
            <ul>
                <?php
                for ($i = 0; $i < count($_SESSION['exam'][$usrid]['qid']); $i++) {
                    if (array_key_exists($_SESSION['exam'][$usrid]['qid'][$i], $_SESSION['exam'][$usrid]['exam_qnSts'])) {

                        if ($_SESSION['exam'][$usrid]['exam_qnSts'][$_SESSION['exam'][$usrid]['qid'][$i]] == 0) {
                            $style = "background: red";
                        } else {
                            $style = "background: green";
                        }
                    } else {
                        $style = '';
                    }
                    ?>
                    <li style="<?= $style ?>"><a href="javascript:void(0)" id="<?= $_SESSION['exam'][$usrid]['qid'][$i] ?>" onclick="examqn(<?= $i ?>)"><?= $i + 1 ?></a></li>
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
            if ($chkFlag > 0) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            ?>
            Flag &nbsp
            <div class="material-switch pull-right">
                <input id="someSwitchOptionSuccess" name="qn_flag" value="1" onclick="flagqn(<?= $questionId ?>)" <?= $checked ?> type="checkbox"/>
                <label for="someSwitchOptionSuccess" class="label-success"></label>
            </div>
        </div>
        <?php
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
        ?>
    </div>   
    <?php
}

//flag question
if ($_POST['pid'] == 2) {
    $action = $_POST['action'];
    $qnId = $_POST['qn_id'];
    $userId = $_POST['user_id'];

    $result = $objgen->get_Onerow("question_flag", "AND user_id='$userId' AND que_id='$qnId'");
    if (empty($result)) {
        $insrt = $objgen->ins_Row("question_flag", 'user_id,que_id,status', "'$userId','$qnId','$action'");
    } else {
        $tblId = $result['id'];
        $insrt = $objgen->upd_Row("question_flag", "status='$action'", "id='$tblId'");
    }
}
if ($_POST['pid'] == 3) {
    $usrid = $_SESSION['ma_log_id'];
    $exmMode = $_POST['exm_mode'];
    $exmQnFilter = $_POST['exm_qn_filter'];
    $exmDiffLevel = $_POST['exm_diff_lvl'];
    $userId = $_POST['user_id'];
    if ($exmDiffLevel == 'all') {
        $difficultyCond = '';
    } else {
        $difficultyCond = "AND difficulty='" . ucfirst($exmDiffLevel) . "'";
    }
    ?>
    <div class="qn-section-container">

        <?php
        $getExamId = $_POST['exam_id'];
        if(!empty($getExamId)){
            $getSectionByExamCnt = $objgen->get_AllRowscnt('section'," AND exam_id='$getExamId'");
            if($getSectionByExamCnt>0){
                $userExamSectionArr = $objgen->get_AllRows('section', 0, $getSectionByExamCnt, '', " AND exam_id='$getExamId'", '', 'id AS section_id');
            }

        }else{
            $userExamSectionArr = $objgen->getUserExamSection($usrid);
        }
        $totsecQnCount = 0;
        for ($i = 0; $i < count($userExamSectionArr); $i++) {
            $sectionId = $userExamSectionArr[$i]['section_id'];
            $getSectionDetails = $objgen->get_Onerow('section', " AND id='$sectionId'", 'id,name');
            $sectionName = $getSectionDetails['name'];
            if ($exmQnFilter == 'all') {
                if ($exmDiffLevel == 'all') {
                    $where = ' AND section=' . $sectionId." AND exam='$getExamId' AND status='active'";
                    $sectionQnCount = $objgen->get_AllRowscnt('question', $where);
                } else {
                    $where = "AND section='$sectionId' AND exam='$getExamId' AND status='active' $difficultyCond";
                    $sectionQnCount = $objgen->get_AllRowscnt('question', $where);
                }
            } elseif ($exmQnFilter == 'unused') {
                $where = " AND section='$sectionId' AND (qn_attend_status='unanswered' $difficultyCond)";
                $sectionQnCount = $objgen->get_AllRowscnt('question_userexmlog', $where, 'qn_id');
            } elseif ($exmQnFilter == 'incorrect') {
                $where = " AND section='$sectionId' AND (qn_attend_status='answered' AND (user_ans!=correct_answer) $difficultyCond)";
                $sectionQnCount = $objgen->get_AllRowscnt('question_userexmlog', $where, 'qn_id');
            } elseif ($exmQnFilter == 'inun') {
                $where = " AND section='$sectionId' AND (qn_attend_status='unanswered' OR (user_ans!=correct_answer) $difficultyCond)";
                $sectionQnCount = $objgen->get_AllRowscnt('question_userexmlog', $where, 'qn_id');
            } elseif ($exmQnFilter == 'flag') {
                $where = " AND section='$sectionId' AND user_id='$userId' AND status='1' $difficultyCond";
                $sectionQnCount = $objgen->get_AllRowscnt('user_flag_question', $where);
            }
            $totsecQnCount += $sectionQnCount;
            ?>
            <span class="qn-section-col">
                <input type="checkbox" name="section[]" class="maxqn_enable_cb" value="<?= $sectionId ?>" id="section_<?= $i ?>" onclick="selectChkbx(<?= $sectionQnCount ?>, this.value, $(this))">
                <label for="section_<?= $i ?>" class="first"><?= $sectionName ?> (<?= $sectionQnCount ?>)</label>
                <div class="max_qn">
                    <input type="text" class="num_section_qn" onchange="calc_tot_qn(this.value)" onblur="find_total_enterd_qn()" onkeyup="minmax(this.value, 0, <?= $sectionQnCount ?>, 'section_qn<?= $sectionId ?>')" id="section_qn<?= $sectionId ?>" name="section_qn[<?= $sectionId ?>]">
                </div>
            </span>
            <?php
        }
        ?>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {
            $('div.max_qn').hide();
            $('input.maxqn_enable_cb').change(function () {

                if ($(this).is(':checked')) {
                    $(this).next().next('div.max_qn').show();
                } else {
                    $(this).next().next('div.max_qn').hide();
                }
            });

            $('input.onoffswitch-checkbox').change(function () {

                if ($(this).is(':checked')) {
                    $(this).next().next('div.max_exm_time').show();
                } else {
                    $(this).next().next('div.max_exm_time').hide();
                }
            });

            $("#qn_select_count").html(<?= $totsecQnCount ?>);

        });

    </script>
    <?php
}

if ($_POST['pid'] == 4) {
    $usrid = $_SESSION['ma_log_id'];
    $exmDiffLevel = $_POST['exm_diff_lvl'];
    $userId = $_POST['user_id'];
    if ($exmDiffLevel == 'all') {
        $difficultyCond = '';
    } else {
        $difficultyCond = "AND difficulty='" . ucfirst($exmDiffLevel) . "'";
    }
    $getExamId = $_POST['exam_id'];
    if(!empty($getExamId)){
        $getSectionByExamCnt = $objgen->get_AllRowscnt('section'," AND exam_id='$getExamId'");
        if($getSectionByExamCnt>0){
            $userExamSectionArr = $objgen->get_AllRows('section', 0, $getSectionByExamCnt, '', " AND exam_id='$getExamId'", '', 'id AS section_id');
        }

    }else{
        $userExamSectionArr = $objgen->getUserExamSection($usrid);
    }
    $sectionId = "";
    $totsecQnCount = 0;
    for ($i = 0; $i < count($userExamSectionArr); $i++) {
        $sectionId .= $userExamSectionArr[$i]['section_id'] . ',';
    }
    $sectionId = rtrim($sectionId, ',');

    /*
     * for all qn count with all difficulty
     */
    $where = " AND section IN($sectionId) AND exam='$getExamId' AND status='active' $difficultyCond";
    $getAllDiffQnCount = $objgen->get_AllRowscnt('question', $where);
    /*
     * for unused qncount with all difficulty
     */
    $where = " AND section IN ($sectionId) AND (qn_attend_status='unanswered' $difficultyCond)";
    $unansweredQnCount = $objgen->get_AllRowscnt('question_userexmlog', $where, 'qn_id');
    /*
     * for incorrect qncount with all difficulty
     */
    $where = " AND section IN ($sectionId) AND (qn_attend_status='answered' AND (user_ans!=correct_answer) $difficultyCond)";
    $incorrectQnCount = $objgen->get_AllRowscnt('question_userexmlog', $where, 'qn_id');
    /*
     * for incorrect+unused qncount with all difficulty
     */
    $where = " AND section IN ($sectionId) AND (qn_attend_status='unanswered' OR (user_ans!=correct_answer) $difficultyCond)";
    $inunQnCount = $objgen->get_AllRowscnt('question_userexmlog', $where, 'qn_id');
    /*
     * for flagged qn count with all difficulty
     */
    $where = " AND section IN ($sectionId) AND user_id='$userId' AND status='1' $difficultyCond";
    $flaggedQnCount = $objgen->get_AllRowscnt('user_flag_question', $where);

    $return["getAllDiffQnCount"] = $getAllDiffQnCount;
    $return["unansweredQnCount"] = $unansweredQnCount;
    $return["incorrectQnCount"] = $incorrectQnCount;
    $return["inunQnCount"] = $inunQnCount;
    $return["flaggedQnCount"] = $flaggedQnCount;
    echo json_encode($return);
    ?>

    <?php
}

//exam history details
if ($_POST['pid'] == 5) {
    $examScoreId = $_POST['exam_score_id'];
    $getMarkBySectionCnt = $objgen->get_AllRowscnt('user_exam_log', " AND `exam_score_id`='$examScoreId'", '`qn_section_id`');
    if ($getMarkBySectionCnt > 0) {
        $getMarkBySection = $objgen->get_AllRows('user_exam_log', 0, $getMarkBySectionCnt, '', " AND `exam_score_id`='$examScoreId'", '`qn_section_id`', '`qn_section_id`,SUM(`exam_mark`) as section_total_mark');
    }
    ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <td>Sl. No.</td>
                <td>Section</td>
                <td>Mark</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($getMarkBySection)) {
                $i=1;
                foreach ($getMarkBySection as $key1 => $value1) {
                    $sectionMark = $value1['section_total_mark'];
                    $sectionMark = (int) $sectionMark;
                    $sectionId = $value1['qn_section_id'];
                    $getSectionDetails = $objgen->get_Onerow('section', " AND id='$sectionId'", 'name');
                    $sectionName = $getSectionDetails['name'];
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $objgen->check_tag($sectionName); ?></td>
                        <td><?php echo $objgen->check_tag($sectionMark); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>
    <?php
}

if($_POST['pid']==6){
?>
    <div class="col-md-4 col-lg-4">
        <div class="form-group">
            <label class="form-label" for="input3">Select No. of Exam Questions & Exam Duration *</label>
            <select required="" class="form-control" name="duration_type" id="duration_type" onchange="setQn_numN_dur($(this).val());">
                <option value="">Select</option>
                <option value="1">50 questions - 30 min </option>
                <option value="2">100 questions - 60 min </option>
           </select>
            <div id="qnnumdur">
                <input type="hidden" id="duration" name="duration" value="">
                <input type="hidden" id="no_of_qu" name="no_of_qu" value="">
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="form-group">
            <p style="padding: 0px;margin: 0px;">&nbsp;</p>
            <button name="create" class="btn btn-default"><span class="fa fa-save"></span>&nbsp;Save</button>
        </div>
    </div>
<script type="text/javascript">
    function setQn_numN_dur(option_val){
        if(option_val==1){
            $("#duration").val("00:30");
            $("#no_of_qu").val('50');
        }else if(option_val==2){
            $("#duration").val("01:00");
            $("#no_of_qu").val('100');
        }
    }
</script>
    
<?php
}
?>



