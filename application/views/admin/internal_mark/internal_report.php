<style>
    table.table-bordered.dataTable th,
    table.table-bordered.dataTable td {
        border-left-width: 1px;

    }

    table.table-bordered.dataTable th,
    table.table-bordered.dataTable td {
        border-left-width: 1px;
    }

    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td,
    .table-bordered>tfoot>tr>td {
        border: 1px solid black;
    }
</style>
<div class="content-wrapper" style="min-height: 946px;">

    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> <?php echo "Internal Report"; ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <!-- Large modal -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>

                    </div>
                    <form action="<?php echo site_url('admin/internal_mark/internal_report') ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                            ?>
                                                <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected"; ?>><?php echo $class['class'] ?></option>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>

                                </div><!-- /.col -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select id="section_id" name="section_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('subject'); ?></label><small class="req"> *</small>
                                        <select id="subject_id" name="subject_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('subject_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('subject'); ?> <?php echo $this->lang->line('type'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="type" name="type" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <option <?php if ($sub_type == 'theory') {
                                                        echo 'selected';
                                                    } ?> value="theory">Theory</option>
                                            <option <?php if ($sub_type == 'practical') {
                                                        echo  'selected';
                                                    } ?> value="practical">Practical</option>
                                            <?php
                                            if ($centre_id == 1) {
                                            ?>
                                                <option <?php if ($sub_type == 'Cocurricular') {
                                                            echo 'selected';
                                                        } ?> value="Cocurricular">Cocurricular</option>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('type'); ?></span>

                                    </div>
                                </div>





                                <!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right btn-sm"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>
                </div>
                <?php
                if (isset($result)) {

                    if ($sub_type == "practical") {
                ?>
                        <div class="box box-info">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"><i class="fa fa-list"></i> <?php echo "Internal Mark" ?> </h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <div class="download_label"><?php echo $this->lang->line('exam_list'); ?></div>
                                <table class="table table-striped table-bordered table-hover example text-center" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">SL.NO</th>
                                            <th><?php echo "Name" ?></th>
                                            <th colspan="<?php echo count($marks) + count($clinical) + 10 ?>"><?php echo "CONTINIOUS ASSMESSMENT - 10 MARK" ?></th>
                                            <th colspan="4"><?php echo "EXAMINATION - 15 MARK" ?></th>
                                            <!-- <th class="text-right"><?php echo $this->lang->line('action'); ?></th> -->
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th colspan="2">AT</th>
                                            <th colspan="<?php echo count($marks) + 2 ?>">ASSIGNMENT</th>
                                            <th colspan="<?php echo count($clinical) + 2 ?>">CLINICAL EV</th>
                                            <th><?php echo $eo5->name ?></th>
                                            <th><?php echo $pc->name ?></th>
                                            <th><?php echo "" ?></th>
                                            <th><?php echo "" ?></th>
                                            <th><?php echo $os->name ?></th>
                                            <th><?php echo $dop->name ?></th>
                                            <th><?php echo "TOT" ?></th>
                                            <th><?php echo "" ?></th>
                                            <th><?php echo "" ?></th>





                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>%</th>
                                            <th>2</th>
                                            <!-- assignment start -->
                                            <?php
                                            $assignmentMax = 0;
                                            foreach ($marks as $markIndex => $examname) { ?>
                                                <th><?php echo $examname['name'];
                                                    $assignmentMax += $examname['max'] ?></th>
                                            <?php } ?>
                                            <th>T/<?php echo $assignmentMax ?></th>
                                            <th>10</th>
                                            <!-- assignment end -->
                                            <!-- clinical start -->

                                            <?php
                                            $clinicalMax = 0;
                                            foreach ($clinical as $markIndex => $examname) { ?>
                                                <th><?php echo $examname['name'];
                                                    $clinicalMax += $examname['max'] ?></th>
                                            <?php } ?>
                                            <th>T/<?php echo $clinicalMax ?></th>
                                            <th>10</th>
                                            <!-- clinical end -->
                                            <th><?php echo $eo5->max ?></th>
                                            <th><?php echo $pc->max ?></th>
                                            <th>30</th>
                                            <th>10</th>
                                            <th><?php echo $os->max ?></th>
                                            <th><?php echo $dop->max ?></th>
                                            <th>30</th>
                                            <th>15</th>
                                            <th>25</th>




                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1;

                                        foreach ($attendance as $key => $student) {
                                        ?>
                                            <?php $total30 = 0 ?>

                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo $student['firstname']; ?></td>
                                                <td><?php $att_percentage = ($student['present_count'] / $student['total']) * 100;
                                                    echo $att_percentage; ?></td>
                                                <td><?php if ($att_percentage >= 95) {
                                                        echo 2;
                                                        $total30 += 2;
                                                    } elseif ($att_percentage >= 90) {
                                                        echo 1.5;
                                                        $total30 += 1.5;
                                                    } elseif ($att_percentage >= 85) {
                                                        $total30 += 1;
                                                        echo 1;
                                                    } elseif ($att_percentage < 80) {
                                                        echo 0;
                                                    } ?></td>
                                                <!-- assignment start -->

                                                <?php $assignmentTotal = 0;
                                                foreach ($marks as $mark) {
                                                ?>
                                                    <td><?php echo $mark['marks'][$key]['marks'];
                                                        $assignmentTotal += $mark['marks'][$key]['marks']; ?></td>

                                                <?php
                                                } ?>
                                                <td><?php echo $assignmentTotal; ?></td>
                                                <td><?php echo round(($assignmentTotal / $assignmentMax) * 10, 1);
                                                    $total30 += round(($assignmentTotal / $assignmentMax) * 10, 1); ?></td>

                                                <!-- assignment end -->
                                                <!-- clinical Start -->

                                                <?php $clinicalTotal = 0;
                                                foreach ($clinical as $mark) {
                                                ?>
                                                    <td><?php echo $mark['marks'][$key]['marks'];
                                                        $clinicalTotal += $mark['marks'][$key]['marks']; ?></td>

                                                <?php
                                                } ?>
                                                <td><?php echo $clinicalTotal; ?></td>
                                                <td><?php echo round(($clinicalTotal / $clinicalMax) * 10, 1);
                                                    $total30 += round(($clinicalTotal / $clinicalMax) * 10, 1); ?></td>
                                                <!-- clinical end -->

                                                <td><?php echo $eo5->marks[$key]['marks'];
                                                    $total30 += $eo5->marks[$key]['marks']; ?></td>
                                                <td><?php echo $pc->marks[$key]['marks'];
                                                    $total30 += $pc->marks[$key]['marks']; ?></td>
                                                <td><?php echo $total30; ?></td>
                                                <td><?php echo round($total30 / 3, 1); ?></td>
                                                <?php $examTotal = 0; ?>
                                                <td><?php echo $os->marks[$key]['marks'];
                                                    $examTotal += $os->marks[$key]['marks'];
                                                    ?></td>
                                                <td><?php echo $dop->marks[$key]['marks'];
                                                    $examTotal += $dop->marks[$key]['marks']; ?></td>
                                                <td><?php echo $examTotal; ?></td>
                                                <td><?php echo round($examTotal / 2, 1); ?></td>
                                                <td><?php echo round($examTotal / 2, 1) + round($total30 / 3, 1); ?></td>





                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                </table>
                            </div><!---./end box-body--->
                        </div>
                    <?php
                    } elseif ($sub_type == "theory") {                    ?>
                        <div class="box box-info">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"><i class="fa fa-list"></i> <?php echo "Internal Mark" ?> </h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <div class="download_label"><?php echo $this->lang->line('exam_list'); ?></div>
                                <table class="table table-striped table-bordered table-hover example text-center" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">SL.NO</th>
                                            <th><?php echo "Name" ?></th>

                                            <th colspan="<?php echo count($marks) + 11 ?>"><?php echo "CONTINIOUS ASSMESSMENT - 10 MARK" ?></th>
                                            <th colspan="4"><?php echo "EXAMINATION - 15 MARK" ?></th>


                                            <!-- <th class="text-right"><?php echo $this->lang->line('action'); ?></th> -->
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th colspan="2">AT</th>
                                            <th colspan="<?php echo count($marks) + 2 ?>">ASSIGNMENT</th>
                                            <th><?php echo $sm->name ?></th>
                                            <th><?php echo $mt1->name ?></th>
                                            <th><?php echo $mt2->name ?></th>
                                            <th><?php echo $pj->name ?></th>
                                            <th><?php echo $mm->name ?></th>
                                            <th><?php echo "" ?></th>
                                            <th><?php echo "" ?></th>
                                            <th colspan="<?php echo count($unit_test) + 2 ?>"><?php echo "UNIT TEST" ?></th>
                                            <th colspan="<?php echo count($unit_test) + count($sessional) + 4 ?>"><?php echo "SESSIONAL" ?></th>
                                            <th><?php echo "" ?></th>



                                            <?php /*
                                            <th colspan="<?php echo count($clinical) + 2 ?>">CLINICAL EV</th>
                                            <th><?php echo $eo5->name ?></th>
                                            <th><?php echo $pc->name ?></th>
                                            <th><?php echo "" ?></th>
                                            <th><?php echo "" ?></th>
                                            <th><?php echo $os->name ?></th>
                                            <th><?php echo $dop->name ?></th>
                                            <th><?php echo "TOT" ?></th>
                                            <th><?php echo "" ?></th>
                                            <th><?php echo "" ?></th> -->
                                            */ ?>





                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>%</th>
                                            <th>2</th>
                                            <!-- assignment start -->

                                            <?php
                                            $assignmentMax = 0;
                                            foreach ($marks as $markIndex => $examname) { ?>
                                                <th><?php echo $examname['name'];
                                                    $assignmentMax += $examname['max'] ?></th>
                                            <?php } ?>
                                            <th>T/<?php echo $assignmentMax ?></th>
                                            <th>10</th>
                                            <?php $otherMax = 0 ?>
                                            <th><?php echo $sm->max;
                                                $otherMax += $sm->max ?></th>
                                            <th><?php echo $mt1->max;
                                                $otherMax += $mt1->max ?></th>
                                            <th><?php echo $mt2->max;
                                                $otherMax += $mt2->max ?></th>
                                            <th><?php echo $pj->max;
                                                $otherMax += $pj->max ?></th>
                                            <th><?php echo $mm->max;
                                                $otherMax += $mm->max ?></th>
                                            <th>T/<?php echo $otherMax ?></th>
                                            <th>10</th>

                                            <?php
                                            $unitMax = 0;
                                            foreach ($unit_test as $markIndex => $examname) { ?>
                                                <th><?php echo $examname['name'];
                                                    $unitMax += $examname['max'] ?></th>
                                            <?php } ?>
                                            <th>T/<?php echo $unitMax ?></th>
                                            <th>5</th>
                                            <?php
                                            $sessionalMax = 0;
                                            foreach ($sessional as $markIndex => $examname) { ?>
                                                <th><?php echo $examname['name'];
                                                    $sessionalMax += $examname['max'] ?></th>
                                            <?php } ?>
                                            <th>T/<?php echo $sessionalMax ?></th>
                                            <th>10</th>
                                            <th>25</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1;

                                        foreach ($attendance as $key => $student) {
                                        ?>
                                            <?php $grandTotal = 0 ?>

                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo $student['firstname']; ?></td>
                                                <td><?php $att_percentage = ($student['present_count'] / $student['total']) * 100;
                                                    echo $att_percentage; ?></td>
                                                <td><?php if ($att_percentage >= 95) {
                                                        echo 2;
                                                    } elseif ($att_percentage >= 90) {
                                                        echo 1.5;
                                                    } elseif ($att_percentage >= 85) {
                                                        echo 1;
                                                    } elseif ($att_percentage < 80) {
                                                        echo 0;
                                                    } ?></td>
                                                <!-- assignment start -->

                                                <?php $assignmentTotal = 0;
                                                foreach ($marks as $mark) {
                                                ?>
                                                    <td><?php echo $mark['marks'][$key]['marks'];
                                                        $assignmentTotal += $mark['marks'][$key]['marks']; ?></td>

                                                <?php
                                                } ?>
                                                <td><?php echo $assignmentTotal; ?></td>
                                                <td><?php echo round(($assignmentTotal / $assignmentMax) * 10, 1);
                                                    ?></td>
                                                <?php $otherTotal = 0 ?>
                                                <td><?php echo $sm->marks[$key]['marks'];
                                                    $otherTotal += $sm->marks[$key]['marks']; ?></td>
                                                <td><?php echo $mt1->marks[$key]['marks'];
                                                    $otherTotal += $mt1->marks[$key]['marks']; ?></td>
                                                <td><?php echo $mt2->marks[$key]['marks'];
                                                    $otherTotal += $mt2->marks[$key]['marks']; ?></td>
                                                <td><?php echo $pj->marks[$key]['marks'];
                                                    $otherTotal += $pj->marks[$key]['marks']; ?></td>
                                                <td><?php echo $mm->marks[$key]['marks'];
                                                    $otherTotal += $mm->marks[$key]['marks']; ?></td>
                                                <td><?php echo $otherTotal; ?></td>
                                                <td><?php echo round(($otherTotal / $otherMax) * 10, 1);
                                                    $grandTotal += round(($otherTotal / $otherMax) * 10, 1); ?></td>


                                                <?php $unit_test_total = 0;
                                                foreach ($unit_test as $mark) {
                                                ?>
                                                    <td><?php echo $mark['marks'][$key]['marks'];
                                                        $unit_test_total += $mark['marks'][$key]['marks']; ?></td>

                                                <?php
                                                } ?>
                                                <td><?php echo $unit_test_total; ?></td>

                                                <td><?php echo round(($unit_test_total / $unitMax) * 5, 1);
                                                    $grandTotal += round(($unit_test_total / $unitMax) * 5, 1); ?></td>


                                                <?php $sessional_total = 0;
                                                foreach ($sessional as $mark) {
                                                ?>
                                                    <td><?php echo $mark['marks'][$key]['marks'];
                                                        $sessional_total += $mark['marks'][$key]['marks']; ?></td>

                                                <?php
                                                } ?>
                                                <td><?php echo $sessional_total; ?></td>

                                                <td><?php echo round(($sessional_total / $sessionalMax) * 10, 1);
                                                    $grandTotal += round(($sessional_total / $sessionalMax) * 10, 1); ?></td>
                                                <td><?php echo round($grandTotal, 1); ?></td>




                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                </table>
                            </div><!---./end box-body--->
                        </div>
                    <?php
                    }
                    ?>



            </div>

            <!-- right column -->

        </div> <!-- /.row -->
    <?php
                } else {
                }
    ?>

    </section><!-- /.content -->
</div>

<script type="text/javascript">
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
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";

                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }
    $(document).ready(function() {
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
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

                        div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";

                    });

                    $('#section_id').append(div_data);
                }
            });
        });

        $(document).on('change', '#section_id', function(e) {

            $('#subject_id').html("");
            var section_id = $(this).val();
            var class_id = $('#class_id').val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';

            $.ajax({
                type: "Post",
                url: base_url + "admin/teacher/getSubjctByClassandSectionNew",
                data: {
                    'class_id': class_id,
                    'section_id': section_id,
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {

                        div_data += "<option value=" + obj.id + ">" + obj
                            .name +
                            "</option>";
                    });
                    $('#subject_id').append(div_data);
                }
            });
        });

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

                        div_data += "<option value=" + obj.id + ">" + obj.type + "</option>";

                    });

                    $('#feetype_id').append(div_data);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy',]) ?>';
    $(document).on('click', '.schedule_modal', function() {
        $('.modal-title').html("");
        var exam_id = $(this).data('examid');
        var examname = $(this).data('examname');
        var section_id = $(this).data('sectionid');
        var class_id = $(this).data('classid');
        var classname = $(this).data('classname');
        var sectionname = $(this).data('sectionname');
        var sub_type = '<?php echo $sub_type ?>';

        $('.modal-title').html("<?php echo $this->lang->line('exam'); ?> " + examname);
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            type: "post",
            url: base_url + "admin/examschedule/getexamscheduledetail",
            data: {
                'exam_id': exam_id,
                'section_id': section_id,
                'class_id': class_id,
                'sub_type': sub_type
            },
            dataType: "json",
            success: function(response) {
                var data = "";
                data += '<div class="table-responsive">';
                data += "<p class='lead titlefix pt0'><?php echo $this->lang->line('class'); ?>: " + classname + "(" + sectionname + ")</p>";
                data += '<table class="table table-bordered table-hover sss">';
                data += '<thead>';
                data += '<tr>';
                data += "<th><?php echo $this->lang->line('subject'); ?></th>";
                data += "<th><?php echo $this->lang->line('date'); ?></th>";

                data += "<th class='text text-center'><?php echo $this->lang->line('start_time'); ?></th>";
                data += "<th class='text text-center'><?php echo $this->lang->line('end_time'); ?></th>";
                data += "<th class='text text-center'><?php echo $this->lang->line('room'); ?></th>";
                data += "<th class='text text-center'><?php echo $this->lang->line('full_marks'); ?></th>";
                data += "<th class='text text-center'><?php echo $this->lang->line('passing_marks'); ?></th>";
                data += "<th class='text text-center'><?php echo 'Teacher_assigned' ?></th>";
                data += "<th class='text text-center'><?php echo 'Topics' ?></th>";

                data += '</tr>';
                data += '</thead>';
                data += '</div>'
                data += '<tbody>';
                $.each(response, function(i, obj) {
                    console.log(obj);
                    var now = new Date(obj.date_of_exam);
                    var str = now.toString(date_format);
                    var date = Date.parse(str);
                    date_formatted = (date.toString(date_format));
                    data += '<tr>';
                    data += '<td class="">' + obj.name + ' (' + obj.type.substring(2, 0) + '. - ' + obj.code + ')</td>';

                    data += '<td style="width:100px;" class="text text-center">' + date_formatted + '</td> ';
                    data += '<td style="width:100px;" class="text text-center">' + obj.start_to + '</td> ';
                    data += '<td style="width:100px;" class="text text-center">' + obj.end_from + '</td> ';
                    data += '<td class="text text-center">' + obj.room_no + '</td> ';
                    data += '<td class="text text-center">' + obj.full_marks + '</td>';
                    data += '<td class="text text-center">' + obj.passing_marks + '</td>';
                    data += '<td class="text text-center">' + obj.teacher + '</td>';

                    data += '<td class="text text-center">' + obj.topics + '</td>';


                    data += '</tr>';
                });
                data += '</tbody>';
                data += '</table>';

                $('.modal-body').html(data);

                //===========

                var dtable = $('.sss').DataTable();
                $('div.dataTables_filter input').attr('placeholder', 'Search...');
                new $.fn.dataTable.Buttons(dtable, {

                    buttons: [

                        {
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },

                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },

                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },

                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },

                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },

                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            titleAttr: 'Columns',
                            postfixButtons: ['colvisRestore']
                        },
                    ]
                });

                dtable.buttons(0, null).container().prependTo(
                    dtable.table().container()
                );

                //===========

                $("#scheduleModal").modal('show');
            }
        });
    });
</script>
<div id="scheduleModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
            </div>
        </div>
    </div>
</div>