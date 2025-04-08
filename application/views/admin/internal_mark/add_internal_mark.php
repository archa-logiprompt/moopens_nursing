<div class="content-wrapper" style="min-height: 946px;">

    <section class="content-header">
        <h1>
            <i class="fa fa-map-o"></i> <?php echo "Add Internal Mark"; ?></small>
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
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg') ?>
                    <?php } ?>
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                    }


                    ?>
                    <form action="<?php echo site_url('admin/internal_mark/add_internal_mark') ?>" method="post" accept-charset="utf-8">
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
                                        <label for="exampleInputEmail1"><?php echo "Mark Type" ?></label><small class="req"> *</small>
                                        <select autofocus="" id="type" name="type" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>

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
                ?>
                    <div class="box box-info">
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix"><i class="fa fa-list"></i> <?php echo "Internal Mark" ?> </h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('exam_list'); ?></div>
                            <form action="<?php echo site_url('admin/internal_mark/add_mark') ?>" method="post" accept-charset="utf-8">
                                <input type="hidden" value="<?php echo $type; ?>" name="type_id">
                                <input type="hidden" value="<?php echo $class_id; ?>" name="class_id">
                                <input type="hidden" value="<?php echo $section_id; ?>" name="section_id">
                                <table class="table table-striped table-bordered table-hover example text-center" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">SL.NO</th>
                                            <th><?php echo "Name" ?></th>
                                            <th><?php echo "Enter Mark" ?></th>

                                        </tr>

                                    </thead>
                                    <tbody>

                                        <?php $count = 1;
                                        foreach ($students as $student) {
                                        ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo $student['firstname']; ?></td>

                                                <td><input type="number" class="form-control" name="mark[]" max="<?php echo $max_mark ?>" value="<?php echo $student['marks'] ?>">
                                                    <input type="hidden" value="<?php echo $student['id'] ?>" name="student_id[]">
                                                    <input type="hidden" value="<?php echo $student['exist_id'] ?>" name="exist_id[]">

                                                </td>


                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </form>
                        </div><!---./end box-body--->
                    </div>
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
        var type = "<?php echo $type ?>";
        if (class_id != "" && section_id != "" && type != "") {
            $('#section_id').html("");
            $('#type').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            var div_data1 = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
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


            $.ajax({
                type: "POST",
                url: base_url + "admin/internal_mark/getTypebyClassSection",
                data: {
                    'class_id': class_id,
                    'section_id': section_id,
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {

                        div_data1 += "<option value='" + obj.id + "'" +
                            (obj.id == type ? " selected='selected'" : "") +
                            ">" + obj.name + "</option>";

                    });

                    $('#type').append(div_data1);
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
        $(document).on('change', '#subject_id', function(e) {

            $('#type').html("");
            var subject_id = $(this).val();
            var class_id = $('#class_id').val();
            var section_id = $('#section_id').val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "POST",
                url: base_url + "admin/internal_mark/getTypebyClassSection",
                data: {
                    'class_id': class_id,
                    'section_id': section_id,
                    'subject_id': subject_id,
                },
                dataType: "json",
                success: function(data) {

                    $.each(data, function(i, obj) {

                        div_data += "<option value=" + obj.id + ">" + obj.name + "</option>";

                    });

                    $('#type').append(div_data);
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