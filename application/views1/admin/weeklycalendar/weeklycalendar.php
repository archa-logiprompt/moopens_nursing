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

    .tabledesign td {
        width: 30px;
    }

    .tabledes td {
        width: 30px;
        height: 80px;
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
                                        </label><small class="req"> *</small>
                                        <input name="date" id='month_id' type="text" class="form-control date-picker"
                                            value="<?php echo date('m-Y') ?>" />
                                        <span class="text-danger">
                                            <?php echo form_error('date'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <br>
                                        <!-- <label for="exampleInputEmail1">Week</label><small class="req"> *</small> -->
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
                                </div>
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
                            <?php if($is_weekly){
                                                    echo "Weekly Report";
                                                }
                                                else {
                                                    echo "Monthly Report";
                                                }
                                                ?>

                        </h3>

                        <button type="button" style="margin-right: 10px;margin-top: 10px;" name="search"
                            id="collection_print" value=""
                            class="btn btn-sm btn-primary login-submit-cs fa fa-print pull-right">
                            <?php echo $this->lang->line('print'); ?>
                        </button>


                        <div class="box-body" id="collection_report">

                            <div class="row">

                                <div class="col-md-12 ">
                                    <!-- header  -->
                                    <div class="box-header print with-border">
                                        <div class="row">
                                            <div class="col-sm-2" style="width:20%;">

                                            </div>
                                            <div class="col-sm-8">
                                                <h3>
                                                    <img src="<?php echo base_url(); ?>\uploads\header.png"
                                                        alt="Header Image" style="width: 100%;">
                                                    <!-- <?php echo strtoupper($this->setting_model->getCurrentSchoolName()); ?> -->
                                                </h3>
                                                <div class="col-sm-8">
                                            
                                            <h3> Month And Year: <?php  echo "$month_name $year" ?></h3>


                                        </div>

                                            </div>
                                        </div>

                                    </div>
                                    <!-- #region -->

                                    <div style="width: 100%; overflow-x: auto;">
                                        <?php


                                        if ($table == 0) { ?>
                                            <?php $week_name = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'friday', 'Saturday', 'Sunday'] ?>

                                            <table class="tabledes" style="width:100%;" border="1" h>

                                                <thead>
                                                    <!-- <tr>
                                            <th style="padding: 5px;">Time</th>

                                            <th style="padding: 5px;"></th>

                                            <?php echo $value['date']; ?> 
 
                                        </tr> -->
                                                    <tr>
                                                        <th style="padding: 5px;">Time</th>
                                                        <th style="padding: 5px;"></th>

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
                                                    <?php //var_dump($weekcalendar[0]['date']);?>

                                                    <tr>
                                                        <td style="text-align:center">08:09 AM</td>
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
                                                        <td style="text-align:center">09:10 AM</td>
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

                                                                <!-- <?php echo getsubjectname($value['nine_to_ten_subject']) !== null ? $value['nine_to_ten_activity'] : ''; ?> -->
                                                                <br>
                                                                <?php echo getteacheranme($value['nine_to_ten_teacher'])[0]->name ?>
                                                                <br>
                                                                <?php echo getperiodreport($value['id'], 'nine_to_ten') ?>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:center">10:11 AM</td>
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

                                                                <!-- <?php echo getsubjectname($value['ten_to_eleven_subject']) !== null ? $value['ten_to_eleven_activity'] : ''; ?> -->
                                                                <br>
                                                                <?php echo getteacheranme($value['ten_to_eleven_teacher'])[0]->name ?>
                                                                <br>
                                                                <?php echo getperiodreport($value['id'], 'ten_to_eleven') ?>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:center">11:12 PM</td>
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

                                                                <!-- <?php echo getsubjectname($value['eleven_to_twelve_subject']) !== null ? $value['eleven_to_twelve_activity'] : ''; ?> -->
                                                                <br>
                                                                <?php echo getteacheranme($value['eleven_to_twelve_teacher'])[0]->name ?>
                                                                <br>
                                                                <?php echo getperiodreport($value['id'], 'eleven_to_twelve') ?>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:center">12:01 PM</td>
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

                                                                <!-- <?php echo getsubjectname($value['twelve_to_one_subject']) !== null ? $value['twelve_to_one_activity'] : ''; ?> -->
                                                                <br>
                                                                <?php echo getteacheranme($value['twelve_to_one_teacher'])[0]->name ?>
                                                                <br>
                                                                <?php echo getperiodreport($value['id'], 'twelve_to_one') ?>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:center">02:03 PM</td>
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

                                                                <!-- <?php echo getsubjectname($value['two_to_three_subject']) !== null ? $value['two_to_three_activity'] : ''; ?> -->
                                                                <br>
                                                                <?php echo getteacheranme($value['two_to_three_teacher'])[0]->name ?>
                                                                <br>
                                                                <?php echo getperiodreport($value['id'], 'two_to_three') ?>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:center">03:04 PM</td>
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

                                                                <!-- <?php echo getsubjectname($value['three_to_four_subject']) !== null ? $value['three_to_four_activity'] : ''; ?> -->
                                                                <br>
                                                                <?php echo getteacheranme($value['three_to_four_teacher'])[0]->name ?>
                                                                <br>
                                                                <?php echo getperiodreport($value['id'], 'three_to_four') ?>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align:center">04:05 PM</td>
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

                                                                <!-- <?php echo getsubjectname($value['four_to_five_subject']) !== null ? $value['four_to_five_activity'] : ''; ?> -->
                                                                <br>
                                                                <?php echo getteacheranme($value['four_to_five_teacher'])[0]->name ?>
                                                                <br>
                                                                <?php echo getperiodreport($value['id'], 'four_to_five') ?>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>

                                                </tbody>

                                            </table>



                                        <?php } else if ($table == 1) { ?>

                                            </div>
                                            <?php
                                            // var_dump($weekcalendar); 
                                            foreach ($daysarr as $key => $daysvalue) {

                                                ?>
                                                <div style="width: 100%; overflow-x: auto;">
                                                    <table class="tabledesign" style="width:100%;" border="1">
                                                        <colgroup>
                                                            <!-- Define a fixed width for each column -->
                                                            <col style="width: 10%;">
                                                            <col style="width: 10%;">
                                                            <col style="width: 15%;">
                                                            <col style="width: 15%;">
                                                            <col style="width: 15%;">
                                                            <col style="width: 16%;">
                                                        </colgroup>
                                                        <div style="margin-bottom: 20px;"></div>
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
                                                                        ?>

                                                                        <td>
                                                                        <?php echo $daysvalue[$day] ?>
                                                                        </td>
                                                                        <?php
                                                                        $day++;
                                                                    }
                                                                endforeach; ?>
                                                            </tr>


                                                        </thead>
                                                        <tbody>


                                                            <tr>
                                                                <td style="text-align:center">08:09 AM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['eight_to_nine_subject'])) !== null ? $subjectName : $value['eight_to_nine_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['eight_to_nine_subject']) != null ? $value['eight_to_nine_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['eight_to_nine_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'eight_to_nine') ?>
                                                                        </td>

                                                                        <?php
                                                                        $days++;
                                                                    }
                                                                }
                                                                ?>


                                                            </tr>

                                                            <tr>
                                                                <td style="text-align:center">09:10 AM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['nine_to_ten_subject'])) !== null ? $subjectName : $value['nine_to_ten_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['nine_to_ten_subject']) != null ? $value['nine_to_ten_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['nine_to_ten_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'nine_to_ten') ?>
                                                                        </td>

                                                                        <?php
                                                                        $days++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align:center">10:11 AM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['ten_to_eleven_subject'])) !== null ? $subjectName : $value['ten_to_eleven_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['ten_to_eleven_subject']) != null ? $value['ten_to_eleven_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['ten_to_eleven_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'ten_to_eleven') ?>
                                                                        </td>

                                                                        <?php
                                                                        $days++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align:center">11:12 PM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['eleven_to_twelve_subject'])) !== null ? $subjectName : $value['eleven_to_twelve_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['eleven_to_twelve_subject']) != null ? $value['eleven_to_twelve_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['eleven_to_twelve_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'eleven_to_twelve') ?>
                                                                        </td>

                                                                        <?php
                                                                        $days++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align:center">12:01 PM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['twelve_to_one_subject'])) !== null ? $subjectName : $value['twelve_to_one_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['twelve_to_one_subject']) != null ? $value['twelve_to_one_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['twelve_to_one_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'twelve_to_one') ?>
                                                                        </td>

                                                                        <?php
                                                                        $days++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align:center">02:03 PM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['two_to_three_subject'])) !== null ? $subjectName : $value['two_to_three_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['two_to_three_subject']) != null ? $value['two_to_three_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['two_to_three_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'two_to_three') ?>
                                                                        </td>

                                                                        <?php
                                                                        $days++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align:center">03:04 PM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['three_to_four_subject'])) !== null ? $subjectName : $value['three_to_four_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['three_to_four_subject']) != null ? $value['three_to_four_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['three_to_four_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'three_to_four') ?>
                                                                        </td>

                                                                        <?php
                                                                        $days++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tr>

                                                            <tr>
                                                                <td style="text-align:center">04:05 PM</td>
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

                                                                        <td style="text-align:center">
                                                                        <?php echo ($subjectName = getsubjectname($value['four_to_five_subject'])) !== null ? $subjectName : $value['four_to_five_activity']; ?>

                                                                            <!-- <?php echo getsubjectname($value['four_to_five_subject']) != null ? $value['four_to_five_activity'] : ''; ?> -->
                                                                            <br>
                                                                        <?php echo getteacheranme($value['four_to_five_teacher'])[0]->name ?>
                                                                            <br>
                                                                        <?php echo getperiodreport($value['id'], 'four_to_five') ?>
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

                                        <?php } ?>
                                    <?php } ?>


                                </div>


                            </div>


                            <div class="box-header print with-border">
                                <div class="row">
                                    <!-- <style>
                                        .div_pdf_footer {
                                            position: relative;
                                        }

                                        .div_pdf_footer_img {
                                            position: absolute;
                                            bottom: 0;
                                            left: 0;
                                            right: 0;
                                        }
                                    </style> -->
                                    <div class="col-sm-8 div_pdf_footer">

                                        <img src="<?php echo base_url(); ?>/uploads/footer.png" alt="Footer Image"
                                            style="width: 100%;" class="div_pdf_footer_img">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            <?php } ?>
        </div>

    </section>
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
    $(document).on('ready', function () {
        $(function () {

            $(".date-picker").datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
            })


        });

    });

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
                success: function (data) {
                    $.each(data, function (i, obj) {
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
    $(document).ready(function () {
        $(document).on('change', '#class_id', function (e) {
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
                success: function (data) {
                    $.each(data, function (i, obj) {
                        div_data += "<option value=" + obj.section_id + ">" + obj
                            .section + "</option>";
                    });

                    $('#section_id').append(div_data);
                }
            });
        });
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        $(document).on('change', '#feecategory_id', function (e) {
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
                success: function (data) {
                    $.each(data, function (i, obj) {
                        div_data += "<option value=" + obj.id + ">" + obj.type +
                            "</option>";
                    });

                    $('#feetype_id').append(div_data);
                }
            });
        });
    });

    $(document).on('change', '#section_id', function (e) {
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
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }
</script>


<script type="text/javascript">
    $(document).on('click', '#collection_print', function () {


        var printContents = document.getElementById('collection_report').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;


    });
</script>