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

table {
   
}

th {
   
}

th.rotate {
   

}

th>span {
}

 

.color-box {
   
}

.color {
   
}


.name {
   
}
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1><i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?>
            <small><?php echo $this->lang->line('student_fees1'); ?></small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?>
                        </h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('master_rotation_plan', 'can_add')) { ?>
                            <a href="<?php echo base_url(); ?>admin/masterrotation/create"
                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                title="<?php echo $this->lang->line('add_timetable'); ?>">
                                <i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?>
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <form action="<?php echo site_url('admin/masterrotation/index')?>" method="post"
                        accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small
                                            class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php foreach ($classlist as $class) { ?>
                                            <option value="<?php echo $class['id'] ?>"
                                                <?php if (set_value('class_id') == $class['id']) echo "selected=selected"; ?>>
                                                <?php echo $class['class'] ?></option>
                                            <?php $count++; } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label
                                            for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small
                                            class="req"> *</small>
                                        <select id="section_id" name="section_id" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Month</label><small class="req">
                                            *</small>
                                        <input name="date" id='month_id' type="text" class="form-control date-picker"
                                            value="<?php echo $date ?>" />
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right btn-sm"><i class="fa fa-search"></i>
                                <?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>
                </div>



                <?php  if ($is_search){?>
                <div class="box box-primary">
                    <h3 class="titless pull-left"><i class="fa fa-money"></i> <?php echo 'Monthly Academic Report'; ?>

                    </h3>

                    <button type="button" style="margin-right: 10px;margin-top: 10px;" name="search"
                        id="collection_print" value=""
                        class="btn btn-sm btn-primary login-submit-cs fa fa-print pull-right">
                        <?php echo $this->lang->line('print'); ?></button>


                    <div class="box-body" id="collection_report">

                        <div class="row">

                            <div class="col-md-12 ">


                                <div class="box-header print  with-border">
                                    <div class="row text-center">
                                        <div class="col-sm-2" style="width:20%;">

                                        </div>
                                        <div class="col-sm-8">
                                            <h3><?php echo strtoupper($this->setting_model->getCurrentSchoolName()); ?>
                                            </h3>
                                            <h3> Programme And Batch: <?php  echo "$class_name $section_name" ?></h3>
                                            <h3> Master Rotation Plan - <?php echo $date;?></h3>


                                        </div>
                                    
                                         


 
                                    </div>

                                </div>

                                <br>
                                <br>
                                <?php if($calendar){ ?>
                                <div class="color-box" style=" display: flex;margin-bottom: 10px;justify-content: space-evenly;">

                                    <?php 
                                    foreach ($plan_items as $key => $value) {
                                        
                                    ?>
                                    <div class="col">

                                        <div class="color" data-id="<?php echo $value['id'] ?>"
                                            data-color=" <?php echo $value['color'] ?>" id="plan_item_id"
                                            style=" width: 20px;height: 20px;margin: auto;border-radius: 50%;border: 2px solid #ccc;background-color: <?php echo $value['color'] ?>;">
                                        </div>
                                        <div class="name" style=" font-size: 16px;font-weight: bold;"><?php echo $value['name'] ?></div>
                                    </div>

                                    <?php }?>

                                </div>




                                <table style=" width: 100%;border-collapse: collapse;" border="1">

                                    <thead>
                                        <tr>
   
                                            <th style="text-align: left;border: 1px solid #ccc;height: 172px;transform: rotate(-90deg);text-align: right;vertical-align: middle;min-width: 1.5em;white-space: nowrap;">Date</th>

                                            <?php 
                                            $count =1;
                                            foreach ($weeks as $key => $value) {
                                                ?>

                                            <th style="text-align: left;border: 1px solid #ccc;height: 172px;transform: rotate(-90deg);text-align: right;vertical-align: middle;min-width: 1.5em;white-space: nowrap;">
   
                                                <span style=" width: 8px;display: flex;justify-content: space-around;">

                                                    <?php echo date('d.m.y', strtotime($value['start_date'])).'-'.date('d.m.y', strtotime($value['end_date'])) ; ?>
                                                </span>
                                            </th>
                                            <?php 
                                            $count++;
                                            } ?>

                                        </tr>
                                        <tr>
                                            <th>Week</th>

                                            <?php 
                                            $count =1;
                                            foreach (json_decode($calendar->calendar) as $key => $value) {
                                                ?>


                                            <th id="week-id" style="background-color:<?php echo $value->color; ?>"
                                                class="weekno"><?php echo $count; ?></th>

                                            <?php 
                                            $count++;
                                            } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td></td>
                                            <?php 
                                            $count =1;
                                            foreach (json_decode($calendar->calendar) as $key => $value) {
                                                ?>

                                            <td style="height:100px;border:none;background-color:<?php echo $value->color; ?>"
                                                id="week-td-id"> </td>

                                            <?php 
                                            $count++;
                                            } ?>

                                        </tr>
                                    </tbody>



                                </table>
                                <br>
                              

                                <div class="row">
                                    <div class="col-md-6">
                                        <table border='1' style=" width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center" rowspan='2' colspan='2'>Subjects</th>
                                                    <th style="text-align:center" colspan='2'>Required</th>
                                                    <th style="text-align:center" colspan='2'>Planned</th>
                                                </tr>
                                                <tr>

                                                    <th style="text-align:center">T</th>
                                                    <th style="text-align:center">P</th>
                                                    <th style="text-align:center">T</th>
                                                    <th style="text-align:center">P</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:center">1</td>
                                                    <td style="text-align:center">Nursing Management</td>
                                                    <td style="text-align:center">150</td>
                                                    <td style="text-align:center">200</td>
                                                    <td style="text-align:center">336</td>
                                                    <td style="text-align:center">216</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center">1</td>
                                                    <td style="text-align:center">Clinical Speciality</td>
                                                    <td style="text-align:center">150</td>
                                                    <td style="text-align:center">1450</td>
                                                    <td style="text-align:center">-</td>
                                                    <td style="text-align:center">1488</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center">1</td>
                                                    <td style="text-align:center">Nursing Reasearch</td>
                                                    <td style="text-align:center">-</td>
                                                    <td style="text-align:center">300</td>
                                                    <td style="text-align:center">-</td>
                                                    <td style="text-align:center">336</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="col-md-6">
                                        <u>
                                            <h5>Distribution of hours </h5>
                                        </u>
                                        <ol>
                                            <li>Theory 7 weeks x 8 hrs x 6 days =336 hrs</li>
                                            <li>
                                                <ol>
                                                    Practical
                                                    <li>Clinical Speciality - II 31 weeks x 8 hrs x 6 days 1488 hrs</li>
                                                    <li>Nursing Management 4 weeks x 8 hrs x 6 days (two nights 2 x 12
                                                        24 hrs) 216 hrs</li>
                                                </ol>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="row print" style="display: flex;justify-content: space-around;">
                                        <div class="col-4">
                                            <h5> Class Co Ordinator</h5>
                                            <br>
                                        </div>
                                        <div class="col-4">
                                            <h5>PG Coordinator</h5>
                                        </div>
                                        <div class="col-4">
                                            <h5> Principal</h5>
                                        </div>
                                    </div>
                                </div>




                                <?php } ?>








                            </div>


                        </div>


                    </div>
                    <div class="box-footer">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div>
                        </div>
                    </div>

                </div>

                <?php }?>
            </div>

    </section>
</div>




<?php 

function getdateformat($date){

    $date_string = $date;
    $date_format = 'd/m/Y';
    $dateformat = DateTime::createFromFormat($date_format, $date_string); 
    return $dateformat->format('l'). ' ('. $dateformat->format('d/m/Y') .')'; 
}


?>


<script type="text/javascript">
$(document).on('ready', function() {
    $(function() {

        $(".date-picker").datepicker({
            format: "yyyy",
            startView: "years",
            minViewMode: "years",
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
$(document).on('click', '#collection_print', function() {


    var printContents = document.getElementById('collection_report').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;


});
</script>