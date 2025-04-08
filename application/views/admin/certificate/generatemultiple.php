<style type="text/css">
    * {
        margin: 0;
        padding: 0;
    }

    table {
        font-family: 'arial';
        margin: 0;
        padding: 0;
        font-size: 12px;
        color: #000;
    }

    .tc-container {
        width: 100%;
        position: relative;
        text-align: center;
        margin-bottom: 60px;
        padding-bottom: 10px;
    }

    .tcmybg {
        background: top center;
        background-size: contain;
        position: absolute;
        left: 0;
        bottom: 10px;
        width: 160px;
        height: 160px;
        margin-left: auto;
        margin-right: auto;
        right: 0;
        opacity: 0.10;
    }

    /*begin students id card*/
    .studentmain {
        background: #efefef;
        width: 100%;
        margin-bottom: 30px;
    }

    .studenttop img {
        width: 30px;
        /* vertical-align: top; */
    }

    table td{
        vertical-align: top;
    }

    .studenttop {
        /* padding: 2px; */
        color: #fff;
        /* overflow: hidden; */
        /* position: relative; */
        /* z-index: 1; */
    }

    .sttext1 {
        font-size: 24px;
        font-weight: bold;
        /* line-height: 30px; */
    }

    .stgray {
        background: #efefef;
        padding-top: 5px;
        padding-bottom: 10px;
    }

    .staddress {
        margin-bottom: 0;
        padding-top: 2px;
    }

    .stdivider {
        border-bottom: 2px solid #000;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .stlist {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .stlist li {
        text-align: left;
        display: inline-block;
        width: 100%;
        padding: 0px 5px;
    }

    .stlist li span {
        width: 65%;
        float: right;
    }

    .stimg {
        /*margin-top: 5px;*/
        width: 80px;
        height: 90px;
        margin: 10px auto;
    }

    .stimg img {
        width: 100%;
        height: 100%;
        border-radius: 2px;
        border: 1px solid black;
        display: block;
        object-fit: cover;
    }

    .staround {
        padding: 3px 10px 3px 0;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .staround2 {
        position: relative;
        z-index: 9;
    }

    .stbottom {
        background: #453278;
        height: 20px;
        width: 100%;
        clear: both;
        margin-bottom: 5px;
    }

    /*.stidcard{margin-top: 0px;
        color: #fff;font-size: 16px; line-height: 16px;
        padding: 2px 0 0; position: relative; z-index: 1;
        background: #453277;
        text-transform: uppercase;}*/
    .principal {
        margin-top: -40px;
        margin-right: 10px;
        float: right;
    }

    .stred {
        color: #000;
    }

    .spanlr {
        padding-left: 5px;
        padding-right: 5px;
    }

    .cardleft {
        width: 20%;
        float: left;
    }

    .cardright {
        width: 77%;
        float: right;
    }

    /* .pt15{padding-top: 15px;}
     .p10tb{padding-bottom: 10px; padding-top: 10px;}*/
    .width32 {
        width: 204px;
        padding: 3px;
        float: left;
    }

    /*END students id card*/
    .tcmybg {
        background-color: #ff0000;
    }

    .fs-8{
        font-size: 8px !important;
        text-transform: capitalize !important;
    }

    .fs-10{
        font-size: 8px !important;
        text-transform: capitalize !important;
    }
    .bordered{
        border: 1px solid #ff0000;
    }
    .bordered tr,
    .bordered td{
        border: 1px solid #ff0000;

    }
    .cardcentre {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stud_name {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<?php
$school = $sch_setting[0];
$i = 0;
?>
<?php
// var_dump($id_card[0]->background);exit;
foreach ($students as $student) {
    $i++;
    ?>
    <div style="display: flex; gap:1rem;">  
        <table cellpadding="0" cellspacing="0" width="268px" height="452px" class="-bordered" style="margin-bottom: 1rem;">
            <tr style="background: rgb(0,128,0); background: linear-gradient(0deg, rgba(0,128,0,0) 0%, rgba(0,128,0,1) 30%); height: 80px;">
                <td valign="top" class="">
                    <div class="studenttop" style="padding:10px;text-align:center; ">
                        <div>
                            <img src="<?php echo base_url('uploads/student_id_card/logo/' . $id_card[0]->logo); ?>" width="30" height="30" />
                        </div>
                        <b>
                            <?php echo $id_card[0]->school_name ?>
                        </b>
                    </div> 
                </td>
            </tr>    

            <tr> 
                <td valign="top">
                    <div class="staround" style="display:flex; flex-direction: column; align-items: center; justify-content: center;">
                        <div class="cardcentre">
                            
                            <div class="stimg">
                                <img src="<?php echo base_url($student->image); ?>" class="img-responsive" />
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <b style="color:maroon;">
                                <?php
                                    if ($id_card[0]->enable_student_name == 1) {
                                        echo $student->firstname . " " . $student->lastname;
                                    }
                                ?>
                            </b>
                        </div>

                        <div class="carddet" style="text-align: center; margin-top: 10px;">
                            <div style="display: flex;align-items: center;justify-content: center;flex-direction: column;">

                                <table style="border-collapse:separate; border-spacing:0 10px;">
                                    <tr>
                                        <td align="left">D.O.B</td>
                                        <td style="padding:0px 10px;">:</td>
                                        <td >
                                            <b>
                                            <?php if ($id_card[0]->enable_dob == 1) {
                                                echo $student->dob;
                                            } ?>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">COURSE</td>
                                        <td style="padding:0px 10px;">:</td>
                                        <td >
                                            <b>
                                            <?php if ($id_card[0]->enable_class == 1) {
                                                echo $student->class ;
                                            } ?>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">BATCH</td>
                                        <td style="padding:0px 10px;">:</td>
                                        <td >
                                            <b>
                                            <?php
                                            if ($id_card[0]->enable_class == 1) {
                                                $admissionDate = $student->admission_date;
                                                $admissionYear = date('Y', strtotime($admissionDate));
                                                
                                                // Add 5 years to the admission year
                                                $courseDurationYear = $admissionYear + 5;
                                                
                                                echo $admissionYear.'-'. $courseDurationYear;
                                            }
                                            ?>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">ADMISSION NO</td>
                                        <td style="padding:0px 10px;">:</td>
                                        <td >
                                            <b>
                                            <?php if ($id_card[0]->enable_admission_no == 1) {
                                                echo $student->admission_no;
                                            } ?>
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <ul class="stlist">
                                <?php
                                /* if ($id_card[0]->enable_student_name == 1) { ?>
                                    <li align="center">
                                            <span style="justify-content: center"
                                                ;>
                                                <?php echo $student->firstname . " " . $student->lastname; ?>
                                            </span>
                                    </li>
                                    <?php } 
                                
                                ?>

                                <?php if ($id_card[0]->enable_dob == 1) { ?>
                                    <li>
                                        <div>
                                            D.O.B:
                                            <span>
                                                <?php echo $student->dob; ?>
                                            </span>
                                        </div>
                                    </li>
                                <?php } ?>

                                <li>
                                    <?php if ($id_card[0]->enable_class == 1) { ?>Class:<span>
                                            <?php echo $student->class . ' - ' . $student->section; ?>
                                        </span>
                                    </li>
                                <?php } ?>

                                <li>
                                    <?php if ($id_card[0]->enable_class == 1) { ?>Batch:<span>
                                            <?php echo $school['current_session']['session']; ?>
                                        </span>
                                    </li>
                                <?php } ?>

                                <li>
                                    <?php if ($id_card[0]->enable_admission_no == 1) { ?>Admission No:<span>
                                            <?php echo $student->admission_no; ?>
                                        </span>
                                    </li>
                                <?php } 
                                */
                                ?>

                                <!-- Add more details as needed -->
                                <li>
                                    <div
                                        style="display: flex;align-items: center;justify-content: center;flex-direction: column;">
                                        <img style="text-align:center;"
                                            src="<?php echo base_url('uploads/student_id_card/signature/' . $id_card[0]->sign_image); ?>"
                                            width="50" />
                                        <p style="font-size: 10px;color:maroon;">Principal</p>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </td>
            </tr> 

            <tr> 
                <td align="center" style="height: 50px; padding: 10px; background: rgb(0,128,0)">
                    <p style="font-size: 10px; color: white;">
                        <?php echo $id_card[0]->school_address ?>
                    </p>
                </td>
            </tr>

        </table>

        <table cellpadding="0" cellspacing="0" width="268px" height="452px" class="-bordered" style="margin-bottom: 1rem;">
            <tr style="background: rgb(0,128,0); height: 80px;">
                <td valign="top" class="">                 
                    <div class="studenttop" ></div>                        
                </td>
            </tr> 

            <tr >
                <td valign="top">
                    <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; padding:10px; height: 100%; position: relative;">
                        <table style="border-collapse:separate; border-spacing:0 10px;position: relative;z-index: 1;">
                            <tr style="margin:30px;">
                                <td align="left" style="width: 100px;">Father's Name</td>
                                <td style="padding:0px 6px;">:</td>
                                <td>
                                    <b >
                                    <?php if ($id_card[0]->enable_dob == 1) {
                                        echo $student->father_name;
                                    } ?>
                                    </b>
                                </td>
                            </tr>

                            <tr style="margin:30px;">
                                <td align="left" style="width: 100px;">Mobile No</td>
                                <td style="padding:0px 6px;">:</td>
                                <td>
                                    <b >
                                    <?php if ($id_card[0]->enable_dob == 1) {
                                        echo $student->mobile_no;
                                    } ?>
                                    </b>
                                </td>
                            </tr>

                            <tr style="margin:30px;">
                                <td align="left" style="width: 100px;">Mother's Name</td>
                                <td style="padding:0px 6px;">:</td>
                                <td>
                                    <b >
                                    <?php if ($id_card[0]->enable_class == 1) {
                                        echo $student->mother_name ;
                                    } ?>
                                    </b> 
                                </td>
                            </tr>

                            <tr style="margin:30px;">
                                <td align="left" style="width: 100px;">Address</td>
                                <td style="padding:0px 6px;">:</td>
                                <td>
                                    <b >
                                    <?php
                                    if ($id_card[0]->enable_class == 1) {
                                        $admissionDate = $student->current_address;
                                        // $admissionYear = date('Y', strtotime($admissionDate));
                                        
                                        // Add 5 years to the admission year
                                        // $courseDurationYear = $admissionYear + 5;
                                        
                                        echo $admissionDate;
                                    }
                                    ?>

                                    </b>
                                </td>
                            </tr>
                            
                            <tr>
                                <td align="left" style="width: 100px;">Blood</td>
                                <td style="padding:0px 6px;">:</td>
                                <td>
                                    <b >
                                    <?php if ($id_card[0]->enable_admission_no == 1) {
                                        echo $student->blood_group;
                                    } ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                        <img src="<?php echo base_url('uploads/student_id_card/logo/' . $id_card[0]->logo); ?>" width="100%"  style="position: absolute;top:50%;left: 50%;transform: translate(-50%,-50%);z-index: 0;opacity: .1;"/>
                    </div> 
                </td> 
            </tr>  

            <tr>
                <td valign="top" align="center" style="height: 50px; padding: 10px; background: rgb(0,128,0)">
                </td>
            </tr>
        </table>
    </div>

    <?php
    if ($i == 3) {
        // three items in a row. Edit this to get more or less items on a row
        ?>
        </tr>
        <tr>
            <?php
            $i = 0;
    }
    ?>
    </tr>

    </table>
    <?php
    }
    ?>