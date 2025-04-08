<style>
    /*:root {
--primary-color: 19, 122, 249;
}*/

    .clockpicker-popover .popover-header {

        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        background-color: #e8ecf1 !important;
        color: #337ab7 !important;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        font-size: 3rem;
        font-weight: 400;
        letter-spacing: normal;
        text-align: center;
        padding: .5rem;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;

    }
</style>





<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-clock-o"></i> <?php echo "Internal Marks" ?>
        </h1>
    </section>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>






    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/djibe/clockpicker@1d03466e3b5eebc9e7e1dc4afa47ff0d265e2f16/dist/bootstrap4-clockpicker.min.css">
    <script src="https://cdn.jsdelivr.net/gh/djibe/clockpicker@6d385d49ed6cc7f58a0b23db3477f236e4c1cd3e/dist/bootstrap4-clockpicker.min.js"> </script>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('internal_marks', 'can_add')) {
            ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "Add Internal Marks"; ?></h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo base_url() ?>admin/internal_mark/index" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <?php echo $this->customlib->getCSRF(); ?>




                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo "Subject Type" ?></label> <small class="req">*</small>
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="theory">Theory</option>
                                        <option value="practical">Practical</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('type'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo "Mark Type" ?></label> <small class="req">*</small>
                                    <select name="mark_type" id="mark_type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="examination">Examination</option>
                                        <option value="continuous_assessment">Continuous Assessment</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('mark_type'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo "Sub Type" ?></label> <small class="req">*</small>
                                    <select name="sub_type" id="sub_type" class="form-control">
                                    </select>
                                    <span class="text-danger"><?php echo form_error('sub_type'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req">*</small>
                                    <select autofocus="" id="class_id" name="class_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($classlist as $class) {
                                        ?>
                                            <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) {
                                                                                            echo "selected=selected";
                                                                                        }
                                                                                        ?>>
                                                <?php echo $class['class'] ?></option>
                                        <?php
                                            $count++;
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req">*</small>
                                    <select id="section_id" name="section_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo "Maximum Mark" ?></label> <small class="req">*</small>
                                    <input name="max_mark" id="max_mark" class="form-control">
                                    <span class="text-danger"><?php echo form_error('max_mark'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo "Name" ?></label> <small class="req">*</small>
                                    <input name="name" id="name" class="form-control">
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>




                            </div>





                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
                                if ($this->rbac->hasPrivilege('minutes', 'can_add')) {
                                    echo "8";
                                } else {
                                    echo "12";
                                }
                                ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo "Internal Mark" ?> <?php echo $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo "Internal Mark"; ?> <?php echo $this->lang->line('list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Type</th>
                                        <th>Mark Type </th>
                                        <th>Sub Type</th>
                                        <th>Maximum Mark </th>




                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($internalGroup as $list) {

                                    ?>
                                        <tr>

                                            <td class="mailbox-name">
                                                <?php echo $list['name']; ?>

                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list['class']; ?>

                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list['section']; ?>

                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list['type']; ?>

                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list['mark_type']; ?>

                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list['sub_type']; ?>

                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $list['max_mark']; ?>

                                            </td>





                                            <td class="mailbox-date pull-right">
                                                <?php
                                                if ($this->rbac->hasPrivilege('internal_marks', 'can_edit')) {
                                                ?>
                                                    <a href="<?php echo base_url(); ?>admin/internal_mark/edit/<?php echo $list['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php } ?>
                                                <?php
                                                if ($this->rbac->hasPrivilege('internal_marks', 'can_delete')) {
                                                ?>
                                                    <a href="<?php echo base_url(); ?>admin/internal_mark/delete/<?php echo $list['id'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function() {


        $(document).on('change', '#class_id', function(e) {

            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            var url = "<?php
                        $userdata = $this->customlib->getUserData();
                        if (($userdata["role_id"] == 2)) {
                            echo "getClassTeacherSection";
                        } else {
                            echo "getByClass";
                        }
                        ?>";
            $.ajax({
                type: "GET",
                url: base_url + "sections/" + url,
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {

                        div_data += "<option value=" + obj.section_id + ">" + obj
                            .section +
                            "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        });



        $(document).on('change', '#mark_type', function(e) {
            var value = $(this).val();
            $('#sub_type').html("");
            if (value == "examination") {
                var div = `
        <option value=''>Select</option>
        <option value='assignment'>Assignment</option>
        <option value='clinical_evaluation'>Clinical Evaluation</option>
        <option value='eo5'>EO5</option>
        <option value='pc'>PC</option>`;
            } else if (value == "continuous_assessment") {
                var div = `
        <option value=''>Select</option>
        <option value="os">OS</option>
        <option value="dop">DOP</option>`;
            }

            $('#sub_type').html(div);



        });



    });
</script>