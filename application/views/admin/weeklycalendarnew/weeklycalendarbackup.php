<style type="text/css">
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }

    .print,
    .print * {
        display: none;
    }

    .page-break {
        page-break-before: always;
    }

    .tabledesign td {
        width: 30px;
        border-collapse: separate;
        /* Separate cell spacing */
        border-spacing: 5px;
        page-break-inside: avoid;
    }

    .tabledes td {
        width: 30px;
        height: 80px;
        border-collapse: separate;
        /* Separate cell spacing */
        border-spacing: 5px;
    }


    .div_pdf_footer_img {
        position: fixed;
        bottom: 0;
        width: 100%;
        /* page-break-before: always; */
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1><i class="fa fa-mortar-board"></i>
            <?php echo $this->lang->line('academics'); ?>
            <small>
                <?php echo $this->lang->line('student_fees1'); ?>
            </small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-search"></i>
                            <?php echo $this->lang->line('select_criteria'); ?>
                        </h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('class_timetable', 'can_add')) { ?>
                                <a href="<?php echo base_url(); ?>admin/weeklycalendarnew/create"
                                    class="btn btn-primary btn-sm" data-toggle="tooltip"
                                    title="<?php echo $this->lang->line('add_timetable'); ?>">
                                    <i class="fa fa-plus"></i>
                                    <?php echo $this->lang->line('add'); ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                    <form action="<?php echo site_url('admin/weeklycalendarnew/search') ?>" method="post"
                        accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('class'); ?>
                                        </label><small class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control">
                                            <option value="">
                                                <?php echo $this->lang->line('select'); ?>
                                            </option>
                                            <?php foreach ($classlist as $class) { ?>
                                                <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id'])
                                                                                                echo "selected=selected"; ?>>
                                                    <?php echo $class['class'] ?>
                                                </option>
                                            <?php $count++;
                                            } ?>
                                        </select>
                                        <span class="text-danger">
                                            <?php echo form_error('class_id'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('section'); ?>
                                        </label><small class="req"> *</small>
                                        <select id="section_id" name="section_id" class="form-control">
                                            <option value="">
                                                <?php echo $this->lang->line('select'); ?>
                                            </option>
                                        </select>
                                        <span class="text-danger">
                                            <?php echo form_error('section_id'); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('date'); ?>
                                        </label>
                                        <input name="date" id='month_id' type="text" class="form-control date-picker"
                                            value="<?php echo date('m-Y') ?>" />
                                        <span class="text-danger">
                                            <?php echo form_error('date'); ?>
                                        </span>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group">

                                        <label for="exampleInputEmail1">Week</label>
                                        <select id="week" name="week" class="form-control">
                                            <option value="">
                                                <?php echo $this->lang->line('select'); ?>
                                            </option>
                                            <option value="week 1" <?php if ($week_number == 'week 1')
                                                                        echo 'selected'; ?>>
                                                First Week</option>
                                            <option value="week 2" <?php if ($week_number == 'week 2')
                                                                        echo 'selected'; ?>>
                                                Second Week</option>
                                            <option value="week 3" <?php if ($week_number == 'week 3')
                                                                        echo 'selected'; ?>>
                                                Third Week</option>
                                            <option value="week 4" <?php if ($week_number == 'week 4')
                                                                        echo 'selected'; ?>>
                                                Fourth Week</option>
                                            <option value="week 5" <?php if ($week_number == 'week 5')
                                                                        echo 'selected'; ?>>
                                                Fifth Week</option>
                                        </select>
                                        <span class="text-danger">
                                            <?php echo form_error('week'); ?>
                                        </span>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right btn-sm"><i class="fa fa-search"></i>
                                <?php echo $this->lang->line('search'); ?>
                            </button>
                        </div>
                    </form>
                </div>
                <?php if ($is_search) { ?>
                    <div class="box box-primary">
                        <h3 class="titless pull-left"><i class="fa fa-money"></i>
                            <?php if ($is_weekly) {
                                echo "Weekly Report";
                            } else {
                                echo "Monthly Report";
                            }
                            ?>

                        </h3>

                        <button type="button" style="margin-right: 10px; margin-top: 10px;" name="search"
                            id="collection_print"
                            data-class="collection_report"
                            class="btn btn-sm btn-primary login-submit-cs fa fa-print pull-right">
                            Print View
                        </button>



                        <div class="box-body" id="collection_report">

                            <div class="row">

                                <div class="col-md-12 ">
                                    <!-- header  -->
                                    <div class="box-header print with-border">
                                        <div class="row">

                                            <div>
                                                <!-- <img src="<?php echo base_url(); ?>\uploads\header.png" alt="Header Image" style="width: 100%;">                                              -->
                                            </div>

                                        </div>

                                    </div>
                                    <!-- #region -->
                                    <div id='printcontent'>
                                        <div class="visible-table">
                                            <p style="margin: 0;padding-top:20px"><span>Programme And Batch: </span><b> <?php echo "$class_name $section_name" ?></b></p>
                                            <p style="margin: 0;"><span>Month And Year: </span> <b><?php echo "$month_name $year" ?></b></p>
                                            <div>
                                                <div style="width: 100%; overflow-x: auto;margin-top: 1rem;">
                                                    <?php

                                                    if ($table == 0) { ?>
                                                        <?php $week_name = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] ?>
                                                        <table class="tabledes" style="width:100%; table-layout: fixed;" border="1" h>
                                                            <!-- <h3> Month And Year: <?php echo "$week_name $year" ?></h3> -->


                                                            <thead>
                                                                <!-- <tr>
                                            <th style="padding: 5px;">Time</th>

                                            <th style="padding: 5px;"></th>

                                            <?php echo $value['date']; ?> 
                                         </tr> -->
                                                                <h4> Week: <?php echo $dateStart . '-' . $dateEnd ?></h4>

                                                                <tr>
                                                                    <th style="width: 10%;">Time</th>
                                                                    <th style="width: 20%;"></th>

                                                                    <?php $w = 0;
                                                                    foreach ($week_name as $key => $value): ?>
                                                                        <?php if ($weekcalendar[$key]['date'] != null) { ?>
                                                                            <th style="padding: 5px;">
                                                                                <?php echo $value . ' (' . $weekcalendar[$key]['date'] . ')';

                                                                                ?>
                                                                            </th>
                                                                        <?php } ?>
                                                                    <?php endforeach; ?>
                                                                </tr>


                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_one_from - $period_list->period_one_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['eight_to_nine_subject'])) !== null ? $subjectName : $value['eight_to_nine_activity']; ?>

                                                                            <br>
                                                                            <?php echo getteacheranme($value['eight_to_nine_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'eight_to_nine') ?>

                                                                        </td>

                                                                    <?php } ?>

                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_two_from - $period_list->period_two_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['nine_to_ten_subject'])) !== null ? $subjectName : $value['nine_to_ten_activity']; ?>

                                                                            <br>
                                                                            <?php echo getteacheranme($value['nine_to_ten_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'nine_to_ten') ?>
                                                                        </td>

                                                                    <?php } ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_three_from - $period_list->period_three_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['ten_to_eleven_subject'])) !== null ? $subjectName : $value['ten_to_eleven_activity']; ?>


                                                                            <br>
                                                                            <?php echo getteacheranme($value['ten_to_eleven_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'ten_to_eleven') ?>
                                                                        </td>

                                                                    <?php } ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_four_from - $period_list->period_four_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['eleven_to_twelve_subject'])) !== null ? $subjectName : $value['eleven_to_twelve_activity']; ?>


                                                                            <br>
                                                                            <?php echo getteacheranme($value['eleven_to_twelve_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'eleven_to_twelve') ?>
                                                                        </td>

                                                                    <?php } ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_five_from - $period_list->period_five_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['twelve_to_one_subject'])) !== null ? $subjectName : $value['twelve_to_one_activity']; ?>


                                                                            <br>
                                                                            <?php echo getteacheranme($value['twelve_to_one_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'twelve_to_one') ?>
                                                                        </td>

                                                                    <?php } ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_six_from - $period_list->period_six_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['two_to_three_subject'])) !== null ? $subjectName : $value['two_to_three_activity']; ?>


                                                                            <br>
                                                                            <?php echo getteacheranme($value['two_to_three_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'two_to_three') ?>
                                                                        </td>

                                                                    <?php } ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_eight_from - $period_list->period_eight_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['three_to_four_subject'])) !== null ? $subjectName : $value['three_to_four_activity']; ?>
                                                                            <br>
                                                                            <?php echo getteacheranme($value['three_to_four_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'three_to_four') ?>
                                                                        </td>

                                                                    <?php } ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_seven_from - $period_list->period_seven_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php foreach ($weekcalendar as $key => $value) { ?>

                                                                        <td style="text-align:center">
                                                                            <?php echo ($subjectName = getsubjectname($value['four_to_five_subject'])) !== null ? $subjectName : $value['four_to_five_activity']; ?>

                                                                            <br>
                                                                            <?php echo getteacheranme($value['four_to_five_teacher'])[0]->name ?>
                                                                            <br>
                                                                            <?php echo getperiodreport($value['id'], 'four_to_five') ?>
                                                                        </td>

                                                                    <?php } ?>
                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                </div>

                                            <?php } else if ($table == 1) { ?>

                                                <?php
                                                        // var_dump($weekcalendar); 
                                                        foreach ($daysarr as $key => $daysvalue) {

                                                ?>
                                                    <div style="width: 100%; overflow-x: auto;" class="page-break">
                                                        <table class="tabledesign" style="width:100%;font-size:13px" border="1">
                                                            <colgroup>
                                                                <!-- Define a fixed width for each column -->
                                                                <col style="width: 10%;">
                                                                <col style="width: 13%;">
                                                                <col style="width: 15%;">
                                                                <col style="width: 15%;">
                                                                <col style="width: 15%;">
                                                                <col style="width: 15%;">
                                                            </colgroup>
                                                            <div style="margin-bottom: 10px;"></div>
                                                            <thead>





                                                                <tr>
                                                                    <th style="padding: 5px;">Time</th>
                                                                    <!-- <th style="padding: 5px;">Time</th>                               -->
                                                                    <th style="padding: 5px;"></th>



                                                                    <?php


                                                                    $day = 0;
                                                                    // var_dump($weekcalendar);
                                                                    foreach ($weekcalendar as $value):
                                                                        if ($daysvalue[$day]) {
                                                                            $date = $daysvalue[$day]; // Date in DD/MM/YYYY format
                                                                            $timestamp = DateTime::createFromFormat('d/m/Y', $date)->getTimestamp();
                                                                            $weekday = date('l', $timestamp);
                                                                    ?>

                                                                            <th style="text-align:center;<?php echo ($weekday == 'Sunday') ? 'background-color:#dc3545;' : ''; ?>">
                                                                                <?php echo $daysvalue[$day]; ?>     
                                                                            </th>
                                                                    <?php
                                                                            $day++;
                                                                        }
                                                                    endforeach; ?>
                                                                </tr>


                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_one_from - $period_list->period_one_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {
                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {
                                                                    ?>
                                                                            <td style="text-align:center;position:relative">

                                                                                <div style="text-align:center; background-color:<?php echo getsubjectcolor($value['eight_to_nine_subject']) ?> " onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'eight_to_nine_subject','eight_to_nine_teacher','<?php echo $daysvalue[$days] ?>','eight_to_nine_activity')">


                                                                                    <?php echo ($subjectName = getsubjectname($value['eight_to_nine_subject'])) !== null ? $subjectName : $value['eight_to_nine_activity']; ?>


                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['eight_to_nine_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'eight_to_nine') ?>
                                                                                </div>
                                                                                <?php if (($value['eight_to_nine_subject'] && $value['eight_to_nine_teacher']) || $value['eight_to_nine_activity']) { ?>
                                                                                    <button class="no-print" style="z-index:999;height: 21px;padding: 0;font-size: small;width: 17px;position:absolute;right:0;bottom:0;background-color: beige;border: 0;border-radius: 5px;" onclick="merge(<?php echo $value['id'] ?>,<?php echo $value['eight_to_nine_subject'] ?>,<?php echo $value['eight_to_nine_teacher'] ?>,'nine_to_ten_subject','nine_to_ten_teacher','<?php echo $daysvalue[$days] ?>','nine_to_ten_activity','<?php echo $value['eight_to_nine_activity'] ?>','<?php echo $value['eight_to_nine_activity'] ? 'other' : 'class'; ?>')">+</button>
                                                                                <?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>


                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_two_from- $period_list->period_two_to" ?></td>
                                                                    <td style="text-align:center ">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {

                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {

                                                                    ?>

                                                                            <td style="text-align:center; position:relative">
                                                                                <div style="text-align:center; background-color:<?php echo getsubjectcolor($value['nine_to_ten_subject']) ?>" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'nine_to_ten_subject','nine_to_ten_teacher','<?php echo $daysvalue[$days] ?>','nine_to_ten_activity')">
                                                                                    <?php echo ($subjectName = getsubjectname($value['nine_to_ten_subject'])) !== null ? $subjectName : $value['nine_to_ten_activity']; ?>


                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['nine_to_ten_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'nine_to_ten') ?>
                                                                                </div>
                                                                                <?php if (($value['nine_to_ten_subject'] && $value['nine_to_ten_teacher']) || $value['nine_to_ten_activity']) { ?>
                                                                                    <button class="no-print" style="z-index:999;height: 21px;padding: 0;font-size: small;width: 17px;position:absolute;right:0;bottom:0;background-color: beige;border: 0;border-radius: 5px;" onclick="merge(<?php echo $value['id'] ?>,<?php echo $value['nine_to_ten_subject'] ?>,<?php echo $value['nine_to_ten_teacher'] ?>,'ten_to_eleven_subject','ten_to_eleven_teacher','<?php echo $daysvalue[$days] ?>','ten_to_eleven_activity','<?php echo $value['nine_to_ten_activity'] ?>','<?php echo $value['nine_to_ten_activity'] ? 'other' : 'class'; ?>')">+</button>
                                                                                <?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_three_from - $period_list->period_three_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {


                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {

                                                                    ?>

                                                                            <td style="text-align:center;position:relative">
                                                                                <div style="text-align:center;background-color:<?php echo getsubjectcolor($value['ten_to_eleven_subject']) ?>" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'ten_to_eleven_subject','ten_to_eleven_teacher','<?php echo $daysvalue[$days] ?>','ten_to_eleven_activity')"><?php echo ($subjectName = getsubjectname($value['ten_to_eleven_subject'])) !== null ? $subjectName : $value['ten_to_eleven_activity']; ?>


                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['ten_to_eleven_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'ten_to_eleven') ?>
                                                                                </div><?php
                                                                                        if (($value['ten_to_eleven_subject'] && $value['ten_to_eleven_teacher']) || $value['ten_to_eleven_activity']) { ?>
                                                                                    <button class="no-print" style="z-index:999;height: 21px;padding: 0;font-size: small;width: 17px;position:absolute;right:0;bottom:0;background-color: beige;border: 0;border-radius: 5px;" onclick="merge(<?php echo $value['id'] ?>,<?php echo $value['ten_to_eleven_subject'] ?>,<?php echo $value['ten_to_eleven_teacher'] ?>,'eleven_to_twelve_subject','eleven_to_twelve_teacher','<?php echo $daysvalue[$days] ?>','eleven_to_twelve_activity','<?php echo $value['ten_to_eleven_activity'] ?>','<?php echo $value['ten_to_eleven_activity'] ? 'other' : 'class'; ?>')">+</button>
                                                                                <?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_four_from - $period_list->period_four_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {


                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {

                                                                    ?>

                                                                            <td style="text-align:center; position:relative">
                                                                                <div style="text-align:center;background-color:<?php echo getsubjectcolor($value['eleven_to_twelve_subject']) ?>" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'eleven_to_twelve_subject','eleven_to_twelve_teacher','<?php echo $daysvalue[$days] ?>','eleven_to_twelve_activity')"><?php echo ($subjectName = getsubjectname($value['eleven_to_twelve_subject'])) !== null ? $subjectName : $value['eleven_to_twelve_activity']; ?>


                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['eleven_to_twelve_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'eleven_to_twelve') ?>
                                                                                </div><?php if (($value['eleven_to_twelve_subject'] && $value['eleven_to_twelve_teacher']) || $value['eleven_to_twelve_activity']) { ?>
                                                                                    <button class="no-print" style="z-index:999;height: 21px;padding: 0;font-size: small;width: 17px;position:absolute;right:0;bottom:0;background-color: beige;border: 0;border-radius: 5px;" onclick="merge(<?php echo $value['id'] ?>,<?php echo $value['eleven_to_twelve_subject'] ?>,<?php echo $value['eleven_to_twelve_teacher'] ?>,'twelve_to_one_subject','twelve_to_one_teacher','<?php echo $daysvalue[$days] ?>','twelve_to_one_activity','<?php echo $value['eleven_to_twelve_activity'] ?>','<?php echo $value['eleven_to_twelve_activity'] ? 'other' : 'class'; ?>')">+</button><?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_five_from - $period_list->period_five_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {


                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {

                                                                    ?>

                                                                            <td style="text-align:center;position:relative">
                                                                                <div style="text-align:center;background-color:<?php echo getsubjectcolor($value['twelve_to_one_subject']) ?>" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'twelve_to_one_subject','twelve_to_one_teacher','<?php echo $daysvalue[$days] ?>','twelve_to_one_activity')"><?php echo ($subjectName = getsubjectname($value['twelve_to_one_subject'])) !== null ? $subjectName : $value['twelve_to_one_activity']; ?>


                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['twelve_to_one_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'twelve_to_one') ?>
                                                                                </div><?php if (($value['twelve_to_one_subject'] && $value['twelve_to_one_teacher']) || $value['twelve_to_one_activity']) { ?>
                                                                                    <button class="no-print" style="z-index:999;height: 21px;padding: 0;font-size: small;width: 17px;position:absolute;right:0;bottom:0;background-color: beige;border: 0;border-radius: 5px;" onclick="merge(<?php echo $value['id'] ?>,<?php echo $value['twelve_to_one_subject'] ?>,<?php echo $value['twelve_to_one_teacher'] ?>,'two_to_three_subject','two_to_three_teacher','<?php echo $daysvalue[$days] ?>','two_to_three_activity','<?php echo $value['twelve_to_one_activity'] ?>','<?php echo $value['twelve_to_one_activity'] ? 'other' : 'class'; ?>')">+</button><?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_six_from - $period_list->period_six_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {


                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {

                                                                    ?>

                                                                            <td style="text-align:center;position:relative">
                                                                                <div style="text-align:center;background-color:<?php echo getsubjectcolor($value['two_to_three_subject']) ?>" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'two_to_three_subject','two_to_three_teacher','<?php echo $daysvalue[$days] ?>','two_to_three_activity')"><?php echo ($subjectName = getsubjectname($value['two_to_three_subject'])) !== null ? $subjectName : $value['two_to_three_activity']; ?>
                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['two_to_three_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'two_to_three') ?>
                                                                                </div><?php if (($value['two_to_three_subject'] && $value['two_to_three_teacher']) || $value['two_to_three_activity']) { ?>
                                                                                    <button class="no-print" style="z-index:999;height: 21px;padding: 0;font-size: small;width: 17px;position:absolute;right:0;bottom:0;background-color: beige;border: 0;border-radius: 5px;" onclick="merge(<?php echo $value['id'] ?>,<?php echo $value['two_to_three_subject'] ?>,<?php echo $value['two_to_three_teacher'] ?>,'three_to_four_subject','three_to_four_teacher','<?php echo $daysvalue[$days] ?>','three_to_four_activity','<?php echo $value['two_to_three_activity'] ?>','<?php echo $value['two_to_three_activity'] ? 'other' : 'class'; ?>')">+</button><?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_seven_from - $period_list->period_seven_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {


                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {

                                                                    ?>

                                                                            <td style="text-align:center;position:relative" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'three_to_four_subject','three_to_four_teacher','<?php echo $daysvalue[$days] ?>')">
                                                                                <div style="text-align:center;background-color:<?php echo getsubjectcolor($value['three_to_four_subject']) ?>" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'three_to_four_subject','three_to_four_teacher','<?php echo $daysvalue[$days] ?>','three_to_four_activity')"><?php echo ($subjectName = getsubjectname($value['three_to_four_subject'])) !== null ? $subjectName : $value['three_to_four_activity']; ?>

                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['three_to_four_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'three_to_four') ?>
                                                                                </div><?php if (($value['three_to_four_subject'] && $value['three_to_four_teacher']) || $value['three_to_four_activity']) { ?>
                                                                                    <button class="no-print" style="z-index:999;height: 21px;padding: 0;font-size: small;width: 17px;position:absolute;right:0;bottom:0;background-color: beige;border: 0;border-radius: 5px;" onclick="merge(<?php echo $value['id'] ?>,<?php echo $value['three_to_four_subject'] ?>,<?php echo $value['three_to_four_teacher'] ?>,'four_to_five_subject','four_to_five_teacher','<?php echo $daysvalue[$days] ?>','four_to_five_activity','<?php echo $value['three_to_four_activity'] ?>','<?php echo $value['three_to_four_activity'] ? 'other' : 'class'; ?>')">+</button><?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>

                                                                <tr>
                                                                    <td style="text-align:center"><?php echo "$period_list->period_seven_from - $period_list->period_eight_to" ?></td>
                                                                    <td style="text-align:center">
                                                                        Subject
                                                                        <br>
                                                                        Faculty
                                                                        <br>
                                                                        Topic
                                                                    </td>
                                                                    <?php
                                                                    $days = 0;
                                                                    foreach ($weekcalendar as $key => $value) {


                                                                        if ($daysvalue[$days] && $value['date'] == $daysvalue[$days]) {

                                                                    ?>

                                                                            <td style="text-align:center;position:relative">
                                                                                <div style="text-align:center;background-color:<?php echo getsubjectcolor($value['four_to_five_subject']) ?>" onclick="edit(<?php echo ($value['id']) ? $value['id'] : 'null'; ?>,'four_to_five_subject','four_to_five_teacher','<?php echo $daysvalue[$days] ?>','four_to_five_activity')"><?php echo ($subjectName = getsubjectname($value['four_to_five_subject'])) !== null ? $subjectName : $value['four_to_five_activity']; ?>


                                                                                    <br>
                                                                                    <?php echo getteacheranme($value['four_to_five_teacher'])[0]->name ?>
                                                                                    <br>
                                                                                    <?php echo getperiodreport($value['id'], 'four_to_five') ?>
                                                                                </div>
                                                                                <?php if ($value['eight_to_nine_subject'] && $value['eight_to_nine_teacher']) { ?><?php } ?>
                                                                            </td>

                                                                    <?php
                                                                            $days++;
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tr>

                                                            </tbody>

                                                        </table>





                                                    </div>

                                                <?php } ?><br>
                                            <div class="planning-table">
                                                <table border="1">
                                                    <thead>
                                                        <tr>
                                                            <th style="padding: 15px;text-align:center">Sl no</th>
                                                            <th style="padding: 15px;text-align:center">Subject</th> <!-- Added Subject column -->
                                                            <th style="padding: 15px;text-align:center">Total</th>
                                                            <th style="padding: 15px;text-align:center">Completed</th>
                                                            <th style="padding: 15px;text-align:center">Planned</th>
                                                            <th style="padding: 15px;text-align:center">Balance</th><!-- Added Faculty column -->
                                                        </tr>
                                                        <?php
                                                       
                                                        $count = 1;
                                                        foreach ($subjects_teachers as $key => $value) {
                                                        ?>
                                                            <tr>
                                                                <td style="padding: 15px;text-align:center"><?php echo $count ?></td>
                                                                <td style="padding: 15px;text-align:center"><?php echo $key ?></td>
                                                                <td style="padding: 15px;text-align:center"><?php echo getSubjectHoursByClassAndSection($class_id, $section_id, $value['subject_id'])['theory_hours'] . ' hrs' ?></td>
                                                                <td style="padding: 15px;text-align:center"><?php echo $value['completed_hours_this_month'] . " hrs"; ?></td>
                                                                <td style="padding: 15px;text-align:center"><?php echo $value['total_hours'] . " hrs"; ?></td>
                                                                <td style="padding: 15px;text-align:center"><?php echo $value['total_hours'] - $value['completed_hours_this_month'] . "hrs"; ?></td>

                                                            </tr>

                                                        <?php
                                                            $count++;
                                                        } ?>

                                                    </thead>
                                                    <tbody>
                                                       
                                                        <tr>

                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                                </div>

                                            <?php }  ?>


                                            <br>
                                            </div>


                                        </div>
                                        <div class="row print" id='signatures'>
                                            <!-- <div class="col-md-4">-->
                                            <!--    <span>Signature Class Coordinator</span>-->
                                            <!--</div>-->
                                            <!--<div class="col-md-4">-->
                                            <!--    <span>UG Coordinator</span>-->
                                            <!--</div>-->
                                            <!--<div class="col-md-4">-->
                                            <!--    <span>Signature Principal</span>-->
                                            <!--</div> -->
                                            <br> <br>
                                            <table style="width:100%;">
                                                <tr>
                                                    <td>Signature Class Coordinator</td>
                                                    <td>UG Coordinator</td>
                                                    <td style="text-align: right;">Signature Principal</td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            <?php } ?>
                            </div>


    </section>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Timetable</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group text-center">
                        <label for="typeofperiod">Class</label>
                        <input type="radio" name="periodtype" class="periodtype-radio" value="class" checked id="type-class">
                        <label for="typeofperiod">Other</label>
                        <input type="radio" name="periodtype" class="periodtype-radio" value="other" id="type-other">
                    </div>
                    <form action="<?php echo site_url('admin/weeklycalendarnew/edittimetable') ?>" method="post"
                        accept-charset="utf-8" id="editform">
                        <input type="hidden" name="class" id="class">
                        <input type="hidden" name="section" id="section">
                        <input type="hidden" name="subjectKey" id="subjectKey">
                        <input type="hidden" name="teacherKey" id="teacherKey">
                        <input type="hidden" name="id" id="timetable_id">
                        <input type="hidden" name="date" id="selected_date">
                        <input type="hidden" name="activityKey" id="activityKey">
                        <div id="class-div">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label for="exampleInputEmail1">Subject</label>
                                    <select id="subject" name="subject" class="form-control">

                                    </select>
                                    <span class="text-danger">
                                        <?php echo form_error('week'); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label for="exampleInputEmail1">Teacher</label>
                                    <select id="teacher-class" name="teacher" class="form-control teacher">

                                    </select>
                                    <span class="text-danger">
                                        <?php echo form_error('week'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: none;" id="other-div">
                            <div class="form-group col-md-6">

                                <label for="exampleInputEmail1">Activity</label>
                                <input type="text" id="activity" name="activity" class="form-control">
                                <span class="text-danger">
                                    <?php echo form_error('week'); ?>
                                </span>
                            </div>

                            <div class="form-group col-md-6">

                                <label for="exampleInputEmail1">Teacher</label>
                                <select id="teacher-other" name="teacher" class="form-control teacher">

                                </select>
                                <span class="text-danger">
                                    <?php echo form_error('week'); ?>
                                </span>
                            </div>

                        </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="edittimetable()">Save changes</button>
            </div>
        </div>
    </div>
</div>



<?php

function getdateformat($date)
{

    $date_string = $date;
    $date_format = 'd/m/Y';
    $dateformat = DateTime::createFromFormat($date_format, $date_string);
    return $dateformat->format('l') . ' (' . $dateformat->format('d/m/Y') . ')';
}
function getDateWithoutDay($date)
{
    $date_format = 'd/m/Y';
    $dateformat = DateTime::createFromFormat($date_format, $date);
    return $dateformat->format('d/m/Y');
}



?>


<script type="text/javascript">
    $(document).on('ready', function() {
        $(function() {

            $(".date-picker").datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
            })


        });



    });

    $(document).on('change', '#subject', function(e) {


        var subject_id = $(this).val();

        var base_url = '<?php echo base_url() ?>';
        $('#teacher-class').html('');
        var div_data = '<option value="">Select</option>';
        $.ajax({
            type: "POST",
            url: base_url + "admin/teacher/get_subjectteachers",
            data: {
                'subject_id': subject_id
            },
            dataType: "json",
            success: function(data) {
                $.each(data, function(i, obj) {
                    // console.log(obj)
                    div_data += "<option value=" + obj.id + ">" + obj.name + " " +
                        "</option>";
                });
                $('#teacher-class').append(div_data);
            }
        });
    });

    function edittimetable() {
        var id = $('#timetable_id').val()
        var teacherKey = $('#teacherKey').val()
        var subjectKey = $('#subjectKey').val()
        var activityKey = $('#activityKey').val()
        var section = $('#section').val()
        var class_id = $('#class').val()
        var subject = $('#subject').val()
        var teacher_class = $('#teacher-class').val()
        var teacher_other = $('#teacher-other').val()
        var date = $('#selected_date').val()
        var activity = $('#activity').val()

        var type = $('input[name="periodtype"]:checked').val();
        if (type == "class") {
            activity = "";
            var teacher = teacher_class;
        } else if (type == "other") {
            subject = "";
            var teacher = teacher_other;
        }

        $.ajax({
            type: "POST",
            url: base_url + "admin/weeklycalendarnew/edittimetable",
            data: {
                'id': id,
                'teacherKey': teacherKey,
                'subjectKey': subjectKey,
                'section': section,
                'class_id': class_id,
                'teacher': teacher,
                'subject': subject,
                'date': date,
                'subject': subject,
                'teacher': teacher,
                'type': type,
                'activity': activity,
                'activityKey': activityKey,
            },
            dataType: "json",
            success: function(data) {

                window.location.reload();
            }
        });


    }

    function merge(id, subject, teacher, subjectKey, teacherKey, date, activityKey, activity, type) {
        $.ajax({
            type: "POST",
            url: base_url + "admin/weeklycalendarnew/edittimetable",
            data: {
                'id': id,
                'teacherKey': teacherKey,
                'subjectKey': subjectKey,
                'teacher': teacher,
                'subject': subject,
                'date': date,
                'type': type,
                'activityKey': activityKey,
                'activity': activity,
            },
            dataType: "json",
            success: function(data) {
                window.location.reload();
            }
        });
    }

    function edit(id, subjectKey, teacherKey, selected_date, activityKey) {
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var type = $('#periodtype-radio').val();
        $.ajax({
            type: "POST",
            url: base_url + "admin/weeklycalendarnew/getWeeklycalanderById",
            data: {
                'id': id,
                'subjectKey': subjectKey,
                'teacherKey': teacherKey,
                'class_id': class_id,
                'section_id': section_id,
            },
            dataType: "json",
            success: function(data) {
                subjectDiv = `<option value="">Select</option>`
                $('#subject').html("")
                teacherDiv = `<option value="">Select</option>`
                $('.teacher').html("")
                $('#exampleModal').modal('show');
                $.each(data.subjects, function(index, subject) {
                    var selected = "";
                    if (data.result) {
                        selected = subject.id == data.result[subjectKey] ? "selected=selected" : "";
                    }
                    subjectDiv += `<option value="${subject.id}" ${selected}>${subject.name}</option>`
                });
                $.each(data.teachers, function(index, teacher) {
                    var selected = "";
                    if (data.result) {
                        selected = teacher.id == data.result[teacherKey] ? "selected=selected" : "";
                    }
                    teacherDiv += `<option value="${teacher.id}" ${selected}>${teacher.name+" "+teacher.surname}</option>`
                });

                $('#subject').append(subjectDiv)
                $('.teacher').append(teacherDiv)
                $('#subjectKey').val(subjectKey)
                $('#teacherKey').val(teacherKey)
                $('#activityKey').val(activityKey)
                $('#class').val(data.class_id)
                $('#section').val(data.section_id)
                $('#selected_date').val(selected_date)
                $('#type').val(type)
                if (data.result) {
                    $('#timetable_id').val(data.result.id)
                    $('#activity').val(data.result[activityKey])
                    if (data.result[activityKey]) {
                        $(`#type-other`).prop('checked', true);
                        $(`#type-class`).prop('checked', false);
                        $('#other-div').show();
                        $('#class-div').hide();
                    } else {

                        $(`#type-class`).prop('checked', true);
                        $(`#type-other`).prop('checked', false);
                        $('#other-div').hide();
                        $('#class-div').show();
                    }
                }


            }
        });

    }

    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section +
                            "</option>";
                    });

                    $('#section_id').append(div_data);
                }
            });
        }
    }
    $(document).ready(function() {
        $(document).on('change', '#class_id', function(e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        div_data += "<option value=" + obj.section_id + ">" + obj
                            .section + "</option>";
                    });

                    $('#section_id').append(div_data);
                }
            });
        });


        $(document).on('change', '.periodtype-radio', function(e) {

            var type = $(this).val();
            if (type == "other") {
                $('#other-div').show();
                $('#class-div').hide();
            } else if (type == "class") {
                $('#other-div').hide();
                $('#class-div').show();
            }
        });

        // $(document).on('change', '#class_id', function(e) {
        //     $('#section_id').html("");
        //     var class_id = $(this).val();
        //     var base_url = '<?php echo base_url() ?>';
        //     var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        //     $.ajax({
        //         type: "GET",
        //         url: base_url + "sections/getByClass",
        //         data: {
        //             'class_id': class_id
        //         },
        //         dataType: "json",
        //         success: function(data) {
        //             $.each(data, function(i, obj) {
        //                 div_data += "<option value=" + obj.section_id + ">" + obj
        //                     .section + "</option>";
        //             });

        //             $('#section_id').append(div_data);
        //         }
        //     });
        // });

        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        $(document).on('change', '#feecategory_id', function(e) {
            $('#feetype_id').html("");
            var feecategory_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "feemaster/getByFeecategory",
                data: {
                    'feecategory_id': feecategory_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        div_data += "<option value=" + obj.id + ">" + obj.type +
                            "</option>";
                    });

                    $('#feetype_id').append(div_data);
                }
            });
        });
    });

    $(document).on('change', '#section_id', function(e) {
        $("form#schedule-form").submit();
    });
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function printDiv(elem) {
        var cls = $("#class_id option:selected").text();
        var sec = $("#section_id option:selected").text();
        $('.cls').html(cls + '(' + sec + ')');
        Popup(jQuery(elem).html());
    }

    function Popup(data) {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({
            "position": "absolute",
            "top": "-1000000px"
        });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0]
            .contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');


        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function() {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }
</script>


<!-- <script type="text/javascript">
   $(document).on('click', '#collection_print', function () {
    var printContents = '<link rel="stylesheet" type="text/css" href="print.css" media="print">' + document.getElementById('collection_report').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
});


     
</script>  -->


<script>
    // function redirectToPrintPage() {
    //     window.location.href = 'http://localhost/caritas/admin/weeklycalendarnew/index2';
    // }
</script>

<script type="text/javascript">
    $(document).on('click', '#collection_print', function() {
        
        $tables = $('.tabledesign');
        $planning_table = $('.planning-table').html();
        $row_print = $('#signatures').html();
        $horizontalTR = [];

        $tables.each((idx, table) => {
            // Optionally, you can hide empty rows or columns as needed
            hideEmptyRows(table);
            hideEmptyCols(table);

            $trel = $(table).find('tr');

            $trel.each((tridx, el) => {
                $row = $(el);


                $row.find('td, th').each((tdidx, cell) => {

                    if (idx > 0) {
                        if (tdidx > 1) {
                            if (!$horizontalTR[idx]) {
                                $horizontalTR[idx] = [];
                            }
                            if (!$horizontalTR[idx][tdidx]) {
                                $horizontalTR[idx][tdidx] = [];
                            }


                            $horizontalTR[idx][tdidx][tridx] = cell;
                        }
                    } else {
                        if (!$horizontalTR[idx]) {
                            $horizontalTR[idx] = [];
                        }
                        if (!$horizontalTR[idx][tdidx]) {
                            $horizontalTR[idx][tdidx] = [];
                        }


                        $horizontalTR[idx][tdidx][tridx] = cell;
                    }
                });
            });
        });

        redrawTable($horizontalTR)


        function splitArrayIntoChunks(arr) {
            let result = [];
            let chunkSize = 6;

            arr = [...arr].filter(Boolean)
            for (let i = 0; i < arr.length; i += chunkSize) {
                let chunk = arr.slice(i, i + chunkSize);
                if (chunk.length > 0) {
                    result.push(chunk);
                }
            }

            return result;
        }

        function transposeArray(arr) {
            return arr[0].map((_, colIndex) => arr.map(row => row[colIndex]));
        }

        function convertColumnsToRows(nestedArray) {
            return nestedArray.map(table => transposeArray(table));
        }



        function redrawTable(hrz) {
            

            var single_hrz = [].concat(...hrz);


            let $splitedArr = splitArrayIntoChunks(single_hrz);


            let $convertedTRS = [];


            $splitedArr.forEach((splited_el, splited_idx) => {

                splited_el.forEach((tdel, tdidx) => {

                    if (!$convertedTRS[splited_idx]) {
                        $convertedTRS[splited_idx] = [];
                    }


                    if (!$convertedTRS[splited_idx][tdidx]) {
                        $convertedTRS[splited_idx][tdidx] = [];
                    }


                    $convertedTRS[splited_idx][tdidx] = tdel;
                });
            });


            let tablemodified = `<p style="margin: 0;padding-top:20px"><span>Programme And Batch: </span><b> <?php echo "$class_name $section_name" ?></b></p>
                                            <p style="margin: 0;"><span>Month And Year: </span> <b><?php echo "$month_name $year" ?></b></p>
                                            <div>
                                                <div style="width: 100%; overflow-x: auto;margin-top: 1rem;">`;


            $timings = $convertedTRS[0].slice(0, 1)[0]
            $heading = $convertedTRS[0].slice(1, 2)[0]

            $convertedTRS[0].splice(0, 2)

            $convertedTRS.forEach(element => {
                element.unshift($heading);
                element.unshift($timings);

            });

            transposedTable = convertColumnsToRows($convertedTRS)

            transposedTable.forEach((trdata, tridx) => {

                tablemodified += `
                
                    <table class="tabledesign" style="width:100%;font-size:13px;margin-bottom:20px" border="1">
                                                                <colgroup> 
                                                                    <col style="width: 10%;">
                                                                    <col style="width: 13%;">
                                                                    <col style="width: 15%;">
                                                                    <col style="width: 15%;">
                                                                    <col style="width: 15%;">
                                                                    <col style="width: 15%;">
                                                                </colgroup>
                                                                <thead>
                                                                <tr>
                                                                `



                tablemodified += `</tr></thead>`
                tablemodified += `<tbody>`

                trdata.forEach((tds, tdid) => {
                    tablemodified += `<tr>`
                    tds.forEach((td, tdidx) => {
                        // if(tdidx!=0){ 
                        tablemodified += `${$(td).prop('outerHTML')}`

                        // }


                    });

                    tablemodified += `</tr>`

                })
                tablemodified += `</tbody>`
                tablemodified += `</table>`





            })
            tablemodified += `</div></div>`
            tablemodified += $planning_table;
            tablemodified += $row_print;

            $('.visible-table').html('')
            $('.visible-table').html(tablemodified) 
            $tables = $('.tabledesign')
            console.log($tables)

            $tables.each((idx, table) => {
                hideEmptyRowsFinal(table);
            });




        }


        function hideEmptyCols(table) {
            $trel = $(table).find('tr')
            tr_count = ($trel.length) - 1

            tr_empty_arr = []
            tr_empty_els = []

            $trel.each((rIdx, row) => {
                if (rIdx != 0) {

                    $(row).find('td').each((tdIdx, tdel) => {

                        $tdcontent = $(tdel).find('div')

                        if ($tdcontent.length != 0) {

                            if ($($tdcontent).text().trim() == '') {
                                tr_empty_els.push(tdel)


                                var empty_val = {
                                    "id_val": $(tdIdx)[0],
                                    "elem": tdel,
                                }

                                tr_empty_arr.push(empty_val)

                            }

                        }

                    })

                }
            })

            const uniqueValues = new Set(tr_empty_arr.map(v => v.id_val));

            var heading = $($trel[0]).find('th')


            uniqueValues.forEach(element => {


                var sameelem = tr_empty_arr.filter((x) => x.id_val == element);


                var samecount = sameelem.length;


                if (samecount == tr_count) {

                    sameelem.forEach(elem => {
                        $(elem.elem).remove()


                        $(heading).each((hd_idx, elm) => {

                            if (hd_idx == element) {

                                $(elm).remove()
                            }
                        })


                    });
                }

            });
        }




        function hideEmptyRows(table) {
            $(table).find('tr').each((rowIdx, row) => {

                const $row = $(row);
                rowtext = $row.html().trim()
                rowtextPeriod = rowtext.split('\n')[0]


                if (rowtextPeriod == '<td style="text-align:center"> - </td>') {
                    $row.remove()
                }
            });

        }

        function hideEmptyRowsFinal(table) {
            $(table).find('tr').each((rowIdx, row) => {

                const $row = $(row);
                rowtext = $row.html().trim()

                // rowtextPeriod = rowtext.split('\n')[0]


                // if(rowtextPeriod=='<td style="text-align:center"> - </td>'){
                //     $row.remove()
                // }
                let textcount = 0;
                let totalitems = ($row.find('td').length)
                $row.find('td').each((tdid, tds) => {
                    if ($(tds).text().trim() == '') {
                        textcount += 1;
                    }
                    console.log($row, textcount, totalitems)
                    if (textcount > totalitems - 3) {

                        $row.remove()
                    }
                })
            });

        }
        // Get the class value from the data attribute of the button
        let content = $('#printcontent').html();
        content = btoa(content);
        // Make an AJAX request to the 'printwithheaderandfooter' method
        $.ajax({
            url: '<?php echo base_url('admin/weeklycalendarnew/printWeeklyCalendar'); ?>',
            method: 'post',
            data: {
                data: content
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Content-Encoding', 'gzip');
            },

            success: function(data) {
                console.log(data)
                data = data.replace(/['"]+/g, '')
                // Redirect to the generated PDF URL
                let linkpdf = document.createElement('a');
                linkpdf.target = '_blank';
                linkpdf.href = "<?php echo base_url() ?>" + data;
                linkpdf.click();
                window.location.reload()
                //  window.location.href = "<?php echo base_url() ?>" + data;
            },
            error: function(xhr, status, error) {
                console.error('xhr:', xhr);
                console.error('status:', status);
                console.error('error:', error);
            }
        });
    });
</script>