
<style type="text/css">
    .radio {
        padding-left: 20px; }
    .radio label {
        display: inline-block;
        vertical-align: middle;
        position: relative;
        padding-left: 5px; }
    .radio label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: -20px;
        border: 1px solid #cccccc;
        border-radius: 50%;
        background-color: #fff;
        -webkit-transition: border 0.15s ease-in-out;
        -o-transition: border 0.15s ease-in-out;
        transition: border 0.15s ease-in-out; }
    .radio label::after {
        display: inline-block;
        position: absolute;
        content: " ";
        width: 11px;
        height: 11px;
        left: 3px;
        top: 3px;
        margin-left: -20px;
        border-radius: 50%;
        background-color: #555555;
        -webkit-transform: scale(0, 0);
        -ms-transform: scale(0, 0);
        -o-transform: scale(0, 0);
        transform: scale(0, 0);
        -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33); }
    .radio input[type="radio"] {
        opacity: 0;
        z-index: 1; }
    .radio input[type="radio"]:focus + label::before {
        outline: thin dotted;
        outline: 5px auto -webkit-focus-ring-color;
        outline-offset: -2px; }
    .radio input[type="radio"]:checked + label::after {
        -webkit-transform: scale(1, 1);
        -ms-transform: scale(1, 1);
        -o-transform: scale(1, 1);
        transform: scale(1, 1); }
    .radio input[type="radio"]:disabled + label {
        opacity: 0.65; }
    .radio input[type="radio"]:disabled + label::before {
        cursor: not-allowed; }
    .radio.radio-inline {
        margin-top: 0; }
    .radio-primary input[type="radio"] + label::after {
        background-color: #337ab7; }
    .radio-primary input[type="radio"]:checked + label::before {
        border-color: #337ab7; }
    .radio-primary input[type="radio"]:checked + label::after {
        background-color: #337ab7; }
    .radio-danger input[type="radio"] + label::after {
        background-color: #d9534f; }
    .radio-danger input[type="radio"]:checked + label::before {
        border-color: #d9534f; }
    .radio-danger input[type="radio"]:checked + label::after {
        background-color: #d9534f; }
    .radio-info input[type="radio"] + label::after {
        background-color: #5bc0de; }
    .radio-info input[type="radio"]:checked + label::before {
        border-color: #5bc0de; }
    .radio-info input[type="radio"]:checked + label::after {
        background-color: #5bc0de; }
    </style>

    <div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('attendance'); ?> </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">  
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                   
                    <form id='form1' action="<?php echo site_url('admin/live_class/live_class_attendance') ?>"  method="post" accept-charset="utf-8">
                   
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                                ?>
                                                <option value="<?php echo $class['id'] ?>" <?php
                                                if ($class_id == $class['id']) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php echo $class['class'] ?></option>
                                                        <?php
                                                        $count++;
                                                    }
                                                    ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                                
                                
                                
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('subject'); ?></label><small class="req"> *</small>
                                        <select  id="subject_id" name="subject_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('subject_id'); ?></span>
                                    </div>
                                </div>
                                <?php
                                $admin=$this->session->userdata('admin');
			
			if(!$admin['roles']['Teacher']) { ?>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('teacher'); ?></label>
                                        <select  id="teacher_id" name="teacher_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('teacher_id'); ?></span>
                                    </div>
                            
                         </div>
                                
                            <?php } ?>    
                                
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('attendance'); ?>
                                            <?php echo $this->lang->line('date'); ?>
                                        </label>
                                        <input id="date" name="date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly"/>
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="search" value="search" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($resultlist)) {
                    ?>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-users"></i> <?php echo $this->lang->line('attendance'); ?> <?php echo $this->lang->line('list'); ?> </h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <div class="box-body">
                            <?php
                            if (!empty($resultlist)) {
                                ?>
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div>
                                </div>
                                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                                <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
                                <input type="hidden" name="date" value="<?php echo $date; ?>">
                                <div class="download_label"><?php echo $this->lang->line('attendance'); ?> <?php echo $this->lang->line('list'); ?></div>
                                <div class="table-responsive">    
                                    <table class="table table-hover table-striped example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $this->lang->line('admission_no'); ?></th>
                                               
                                                <th><?php echo $this->lang->line('name'); ?></th>
                                                <th class="text-right"><?php echo $this->lang->line('attendance'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $row_count = 1;
                                            foreach ($resultlist as $key => $value) {
                                                ?>
                                                <tr>
                                                
                                                 
                                                    <td> <?php echo $row_count; ?></td>
                                                    <td>     <?php echo $value['admission_no']; ?>   </td>
                                                    
                                                    <td>
                                                        <?php echo $value['firstname'] . " " . $value['lastname']; ?>
                                                    </td>
                                                    <td class="pull-right">
                                                        <?php if($value['type']=='Present'){ ?>
                                                         <small class="label label-success">
                                                                Present
                                                                        </small>
                                                                       <?php }
																	   
																	    else if($value['type']=='Late')
																		{?>
                                                                         <small class="label label-warning">
																		
                                                                           Late
																		<?php }  else {
																	   ?>
                                                                       <small class="label label-danger">
                                                                           Absent
                                                                        </small>
                                                                       <?php } ?>
                                                                  
                                                              

                                                    </td>
                                                </tr>
                                                <?php
                                                $row_count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <?php
                                }else {
                                    ?>
                                    <div class="alert alert-info">
                                       No record found
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div></div> 
                    <?php
                }
                ?>
                </section>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    var section_id_post = '<?php echo $section_id; ?>';
                    var class_id_post = '<?php echo $class_id; ?>';
					var sub_id_post = '<?php echo $subject_id; ?>';
					var teacher_id='<?php echo $teacher_id ?>';
                    populateSection(section_id_post, class_id_post);
					getSubjectByClassandSection(class_id_post, section_id_post, sub_id_post);
					getSubjectTeachers(class_id_post, section_id_post, sub_id_post,teacher_id);
					
                    function populateSection(section_id_post, class_id_post) {
                        $('#section_id').html("");
                        var base_url = '<?php echo base_url() ?>';
                        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                        $.ajax({
                            type: "GET",
                            url: base_url + "sections/getByClass",
                            data: {'class_id': class_id_post},
                            dataType: "json",
                            success: function (data) {
                                $.each(data, function (i, obj)
                                {
                                    var select = "";
                                    if (section_id_post == obj.section_id) {
                                        var select = "selected=selected";
                                    }
                                    div_data += "<option value=" + obj.section_id + " " + select + ">" + obj.section + "</option>";
                                });

                                $('#section_id').append(div_data);
                            }
                        });
                    }
                    $(document).on('change', '#class_id', function (e) {
                        $('#section_id').html("");
                        var class_id = $(this).val();
                        var base_url = '<?php echo base_url() ?>';
                        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                        $.ajax({
                            type: "GET",
                            url: base_url + "sections/getByClass",
                            data: {'class_id': class_id},
                            dataType: "json",
                            success: function (data) {
                                $.each(data, function (i, obj)
                                {
                                    div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                                });
                                $('#section_id').append(div_data);
                            }
                        });
                    });
                    var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
                    $('#date').datepicker({
                        format: date_format,
                        autoclose: true
						
                    });
					
					
	function getSubjectByClassandSection(class_id_post, section_id_post, sub_id_post) {
        
        if (class_id_post != "" && section_id_post != "" && sub_id_post != "") {
            $('#subject_id').html("");
            var class_id = $('#class_id').val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
			 //console.log(div_data);
            $.ajax({
                type: "POST",
                url: base_url + "admin/teacher/getSubjctByClassandSection",
                data: {'class_id': class_id, 'section_id': section_id_post},
                dataType: "json",
                success: function (data) {
				
                    $.each(data, function (i, obj)
                    {
						
                        var sel = "";
                        if (sub_id_post == obj.id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name + " (" + obj.type + ")" + "</option>";
						
                    });

                    $('#subject_id').append(div_data);
                }
            });
        }
    }
					
					
		
		
		
		function getSubjectTeachers(class_id, section_id, subject_id,teacher_id) {
        console.log("rrrr");
        if (class_id != "" && section_id != "" && subject_id != ""&& teacher_id != "") {
            $('#teacher_id').html("");
            var class_id = $('#class_id').val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "POST",
                url: base_url + "admin/teacher/get_subjectteachers",
                data: {'subject_id': subject_id},
                dataType: "json",
                success: function (data) {
					
					console.log(data);
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (teacher_id == obj.id) {
                            sel = "selected";
                        }
      div_data += "<option value=" + obj.id + " " + sel + ">" + obj.name +" "+obj.surname + "</option>";
                    });

                    $('#teacher_id').append(div_data);
                }
            });
        }
    }
	
		
		
					
					
					
					
                });
				
				
				
				
		 $(document).on('change', '#section_id', function (e) {
            $('#subject_id').html("");
            var section_id = $(this).val();
            var class_id = $('#class_id').val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
			
			 var url = "<?php
       $admin=$this->session->userdata('admin');
       if($admin['roles']['Teacher']) {
            echo "get_subByteacher";
        } else {
            echo "getSubjctByClassandSection";
        }
        ?>";
			
            $.ajax({
                type: "POST",
                url: base_url + "admin/teacher/"+url,
                data: {'class_id': class_id, 'section_id': section_id},
                dataType: "json",
                success: function (data) {
					console.log(data);
					
                    $.each(data, function (i, obj)
                    {
                        div_data += "<option value=" + obj.id + ">" + obj.name + " (" + obj.type + ")" + "</option>";
                    });

                    $('#subject_id').append(div_data);
                }
            });
        });
   		
				
				
				
		$(document).on('change', '#subject_id', function (e) {
            $('#teacher_id').html("");
            var subject_id = $('#subject_id').val();
			//var section_id = $('#section_id').val();
            //var class_id = $('#class_id').val();
			
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "POST",
                url: base_url + "admin/teacher/get_subjectteachers",
                data: {'subject_id': subject_id},
                dataType: "json",
                success: function (data) {
					
                $.each(data, function (i, obj)
                {
                   div_data += "<option value=" + obj.id + ">" + obj.name +" "+ obj.surname + "</option>";
                });
                $('#teacher_id').append(div_data);
                }
            });
        });		
				
				
				
				
				
				
				
            </script>