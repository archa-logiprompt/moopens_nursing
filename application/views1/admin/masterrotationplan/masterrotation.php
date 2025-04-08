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
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>



</head>

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
                <div class="box box-primary" id="pdf_view">
                    <h3 class="titless pull-left"><i class="fa fa-money"></i> <?php echo 'Monthly Academic Report'; ?>

                    </h3>

                    <button type="button" style="margin-right: 10px;margin-top: 10px;" name="search"
                        id="collection_print" value=""
                        class="btn btn-sm btn-primary login-submit-cs fa fa-print pull-right">
                        <?php echo $this->lang->line('print'); ?></button>



                        <a href="<?php echo site_url('admin/masterrotation/getExportData')?>" style="margin-right: 10px;margin-top: 10px;" name="search"
                          
                        class="btn btn-sm btn-primary login-submit-cs fa fa-print pull-right">
                        <?php echo $this->lang->line(''); ?></a>
                    <div class="box-body" id="collection_report">

                        <div class="row">

                            <div class="col-md-12 ">


                                <div class="box-header print  with-border">
                                    <div class="row text-center">
                                        <div class="col-sm-2" style="width:20%;">

                                        </div>
                                        <div class="col-sm-8">
                                        <img src="<?php echo base_url(); ?>\uploads\header.png"   alt="Header Image" style="width: 100%;">

                                            <!-- <h3><?php echo strtoupper($this->setting_model->getCurrentSchoolName()); ?> -->
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




                                <table style=" width: 100%;border-collapse: collapse;" border="1" id="collection">

                                    <thead>
                                        <tr>
   
                                            <th style="text-align: left;border: 1px solid #ccc;height: 172px;transform: rotate(-90deg);text-align: right;vertical-align: middle;min-width: 1.5em;white-space: nowrap;">Date</th>

                                            <?php 
                                            // var_dump($weeks);exit;
                                            $count =1;
                                            foreach ($weekdata as $key => $value) {
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
                                           
                                            $count1 = 1; // Initialize a counter
                                            foreach (json_decode($calendar->calendar) as $key => $value) {
                                                if ($count1 < $count) { // Display only the first 52 weeks
                                                    ?>
                                                    <th id="week-id" style="background-color:<?php echo $value->color; ?>"
                                                        class="weekno"><?php echo $count1; ?></th>
                                                    <?php
                                                }
                                                $count1++;
                                            }
                                            ?>
                                            

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!-- table color -->
                                            <td></td>
                                            <?php 
                                           
                                            $count1 = 1; // Initialize a counter
                                            foreach (json_decode($calendar->calendar) as $key => $value) {
                                                if ($count1 < $count) { // Display only the first 52 weeks
                                                    ?>
                                                    <td data-color="<?php echo $value->color ?>" style="height:100px;border:none;background-color:<?php echo $value->color; ?>"
                                                id="week-td-id"> </td>
                                                    <?php
                                                }
                                                $count1++;
                                            }
                                            ?>
                                            

                                        </tr>
                                    </tbody>



                                </table>
                                <br>
                              

                                <div class="row">
                                    <div class="col-md-6">
                                        <table border='1' style=" width: 100%;" id="collection">
                                        
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
                                <!-- <button onclick="exportTableToExcel()">Export to Excel</button> -->









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



<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script> -->

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
// function exportToXLSX() {
//     // Get the table element
//     var table = document.getElementById('collection_report');

//     // Create a new workbook
//     var wb = XLSX.utils.book_new();

//     // Create a worksheet
//     var ws = XLSX.utils.table_to_sheet(table);

//     // Add the worksheet to the workbook
//     XLSX.utils.book_append_sheet(wb, ws, 'Collection Report');

//     // Create a blob with the XLSX data

//     var wopts = { bookType:'xlsx', bookSST:false, type:'binary' };

//     var wbout = XLSX.write(wb,wopts);

//     // var blob = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

//     // Create a URL for the blob
//     var url = URL.createObjectURL(new Blob([s2ab(wbout)], {type: "text/xlsx"}));

//     // Create a temporary link element to trigger the download
//     var a = document.createElement('a');
//     a.href = url;
//     a.download = 'collection_report.xlsx';
//     a.style.display = 'none';

//     // Append the link to the document and trigger a click event
//     document.body.appendChild(a);
//     a.click();

//     // Remove the link and URL
//     document.body.removeChild(a);
//     URL.revokeObjectURL(url);
// }

// function s2ab(s) {
//   var buf = new ArrayBuffer(s.length);
//   var view = new Uint8Array(buf);
//   for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
//   return buf;
// }

// $(document).on('click', '#excel', function() {
//     exportToXLSX();
// });



function exportToXLSX() {
    var table = document.getElementById('collection_report');
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.table_to_sheet(table);

    console.log("hai");
    

    XLSX.utils.book_append_sheet(wb, ws, 'Collection Report');

    var wopts = { bookType: 'xlsx', bookSST: false, type: 'binary' };
    var wbout = XLSX.write(wb, wopts);

    var url = URL.createObjectURL(new Blob([s2ab(wbout)], { type: "application/octet-stream" }));

    var a = document.createElement('a');
    a.href = url;
    a.download = 'collection_report.xlsx';
    a.style.display = 'none';

    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
    URL.revokeObjectURL(url);

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    }
}

// Trigger the export function when a button with id 'excel' is clicked
$(document).on('click', '#excel', function () {
    exportToXLSX();
});


/* //pdf view code */





// function exportToCSV() {
//     // Get the table element
//     var table = document.getElementById('collection_report');

//     // Initialize an empty CSV string
//     var csv = '';

//     // Iterate over the rows of the table
//     var rows = table.querySelectorAll('tr');
//     rows.forEach(function(row) {
//         // Iterate over the cells in each row
//         var cells = row.querySelectorAll('tr, td,th');
//         cells.forEach(function(cell, index) {
          
//             // Add cell content to the CSV string, separating values with commas
//             csv += cell.textContent.trim();
//             var color = cell.getAttribute('data-color')
//             // If the cell is a th element with class "color", add the corresponding color value
//             if (cell.hasAttribute('data-color') && color!=0) {
//                 console.log(color)
//                 // Append the background color information in a custom format
//                 csv += ' [Color: ' + color + ']';
//             }
            
//             // Add a comma if it's not the last cell in the row
//             if (index < cells.length - 1) {
//                 csv += ',';
//             }
//         });
        
//         // Add a new line character to separate rows
//         csv += '\n';
//     });
 
//     // Create a blob with the CSV data
//     var blob = new Blob([csv], {
//         type: 'text/csv'
//     });

//     // Create a URL for the blob
//     var url = URL.createObjectURL(blob);

//     // Create a temporary link element to trigger the download
//     var a = document.createElement('a');
//     a.href = url;
//     a.download = 'collection_report.csv';
//     a.style.display = 'none';

//     // Append the link to the document and trigger a click event
//     document.body.appendChild(a);
//     a.click();

//     // Remove the link and URL
//     document.body.removeChild(a);
//     URL.revokeObjectURL(url);
// }

// $(document).on('click', '#excel', function() {
//     exportToCSV();
// });

// function mapBinaryToColor(binaryColor) {
//     const colorMap = {
//         '000000': 'Black',
//         'FF0000': 'Red',
//         '00FF00': 'Green',
//         '0000FF': 'Blue',
//         '#ffadad': 'Cornflower Lilac',
//         '#ffd6a5': 'rgb(255, 214, 165)',
//         '#fdffb6':'Chiffon',
//         '#caffbf':'Pale lime green',
//         '#9bf6ff':'Pale cyan',
//         '#a0c4ff':'Pale blue',
//         '#ffadad':'Sundown',

//         // Add more mappings as needed
//     };

//     // Return the corresponding color name or the binary value if not found
//     return colorMap[binaryColor] || binaryColor;
// }

// function exportToCSV() {
//     // Get the table element
//     var table = document.getElementById('collection_report');

//     // Initialize an empty CSV string
//     var xlxs = '';

//     // Iterate over the rows of the table
//     var rows = table.querySelectorAll('tr');
//     rows.forEach(function(row) {
//         // Iterate over the cells in each row
//         var cells = row.querySelectorAll('tr, td,th');
//         cells.forEach(function(cell, index) {
//             // Add cell content to the CSV string, separating values with commas
//             var cellValue = cell.textContent.trim();

//             // If the cell has a data-color attribute, convert it to an actual color name
//             var color = cell.getAttribute('data-color');
//             if (color && color !== '0' && color != '#FFFFFF') {
//                 color = mapBinaryToColor(color); // Convert binary color to actual color name
//                 console.log(color)
//                 cellValue += ' [Color: ' + color + ']';
//             }

//             xlxs += cellValue;

//             // Add a comma if it's not the last cell in the row
//             if (index < cells.length - 1) {
//                 xlxs += ',';
//             }
//         });

//         // Add a new line character to separate rows
//         xlxs += '\n';
//     });

//     // Create a blob with the CSV data
//     var blob = new Blob([xlxs], {
//         type: 'text/xlxs'
//     });

//     // Create a URL for the blob
//     var url = URL.createObjectURL(blob);

//     // Create a temporary link element to trigger the download
//     var a = document.createElement('a');
//     a.href = url;
//     a.download = 'collection_report.xlxs';
//     a.style.display = 'none';

//     // Append the link to the document and trigger a click event
//     document.body.appendChild(a);
//     a.click();

//     // Remove the link and URL
//     document.body.removeChild(a);
//     URL.revokeObjectURL(url);
// }

// $(document).on('click', '#excel', function() {
//     exportToCSV();
// });



// function exportToExcel() {
//     var table = document.getElementById('collection_report');
//     var wb = XLSX.utils.book_new();
//     var ws = XLSX.utils.table_to_sheet(table);

//     // Customize the Excel sheet to display color values
//     for (var R = 0; R < ws['!ref'].split(':')[1].replace(/\d/g, ''); R++) {
//         for (var C = 0; C < 26; C++) {
//             var cellAddress = XLSX.utils.encode_cell({ r: R, c: C });
//             var cell = ws[cellAddress];
//             if (cell) {
//                 var color = cell.getAttribute('data-color');
//                 if (color) {
//                     // Set the cell value to the color value
//                     cell.v = color;
//                     // Set the cell type to string
//                     cell.t = 's';
//                 }
//             }
//         }
//     }

//     XLSX.utils.book_append_sheet(wb, ws, 'Collection Report');
    
//     // Default type: 'blob'
//     var blob = XLSX.write(wb, { bookType: 'xlsx' });

//     var url = URL.createObjectURL(blob);
//     var a = document.createElement('a');
//     a.href = url;
//     a.download = 'collection_report.xlsx';
//     a.style.display = 'none';

//     document.body.appendChild(a);
//     a.click();

//     document.body.removeChild(a);
//     URL.revokeObjectURL(url);
// }


// $(document).on('click', '#excel', function() {
//     console.log('Button clicked'); // Add this line for debugging
//     exportToExcel();
// });



$(document).on('click', '#collection_print', function() {


    var printContents = document.getElementById('collection_report').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;


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


<?php
// Convert your PHP data to JSON
$calendar_json = json_encode($calendar->calendar);
?>

<script>
    // Pass the JSON data to JavaScript
    var calendarData = <?php echo $calendar_json; ?>;
    console.log(calendarData)




</script>



<script type="text/javascript">

function exportTableToExcel() {
    var table = document.getElementById('collection'); // Replace with the actual ID of your table.
    var wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet 1' });

    // Modify the workbook to include cell background colors
    var sheet = wb.Sheets['Sheet 1'];
    for (var cellAddress in sheet) {
        if (sheet.hasOwnProperty(cellAddress)) {
            var cell = sheet[cellAddress];
            if (cell && cellAddress !== '!ref' && cell.style && cell.style.backgroundColor) {
                var hexColor = cell.style.backgroundColor.toUpperCase();
                cell.s = { fgColor: { rgb: (0, 255, 0) } };
            }
        }}

           

    XLSX.writeFile(wb, 'table_with_colors.xlsx');
}






</script>