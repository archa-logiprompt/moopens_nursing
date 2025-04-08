<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title>School Management System</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/style-main.css">
</head>

<body style="background: #ededed;">
    <div class="container">
        <div class="row">
            <div class="paddtop20">
                <div class="col-md-8 col-md-offset-2 text-center">

                    <img src="<?php echo base_url('uploads/school_content/logo/' . $setting[0]['image']); ?>" style="width: 15%;">

                </div>
                <div class="col-md-6 col-md-offset-3 mt20">
                    <div class="paymentbg">
                        <div class="invtext">Fees Payment Details</div>
                        <div class="padd2 paddtzero">
                            <table class="table2" width="100%">
                                <tr>
                                    <th>Decription</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                                <tr>
                                    <td> <?php
                                            echo $params['payment_detail']->fee_group_name . "<br/><span>" . $params['payment_detail']->code;
                                            ?></span></td>
                                    <td class="text-right"><?php echo $setting[0]['currency_symbol'] . $params['total']; ?></td>

                                </tr>
                                <?php if ($params['fine'] != 0) {
                                ?>
                                    <tr>
                                        <td> <?php
                                                echo "Fine" . "<br/><span>";
                                                ?></span></td>
                                        <td class="text-right"><?php echo $setting[0]['currency_symbol'] . $params['fine']; ?></td>
                                    </tr>
                                <?php } ?>

                                <tr class="bordertoplightgray">
                                    <td colspan="2" bgcolor="#fff" class="text-right">
                                        Total: <?php echo $setting[0]['currency_symbol'] . ($params['total'] + $params['fine']); ?>
                                    </td>

                                </tr>
                            </table>
                            <div class="divider"></div>

                            <form class="paddtlrb" action="<?php echo site_url('parent/WorldLine/complete'); ?>" method="POST" id="form">
                                <button type="button" onclick="window.history.go(-1); return false;" name="search" value="" class="btn btn-info"><i class="fa fa fa-chevron-left"></i> Back</button>
                                <button type="button" id="btnSubmit" class="btn btn-info pull-right"><i class="fa fa fa-money"></i> Pay</button>
                                <input type="hidden" name="student_fees_master_id" value="<?php echo $params['student_fees_master_id']; ?>">
                                <input type="hidden" name="fee_groups_feetype_id" value="<?php echo $params['fee_groups_feetype_id']; ?>">
                                <input type="hidden" name="student_id" value="<?php echo $params['student_id']; ?>">
                                <!-- <input type="hidden" name="mrctCode" value="T206030"> -->
                                <!-- <input type="hidden" name="mrctCode" value="L1020487"> -->
                                <input type="hidden" name="incomename" value="<?php echo $params['payment_detail']->fee_group_name ?>">
                                <input type="hidden" name="incometype" value="<?php echo $params['payment_detail']->code ?>">
                                <input type="hidden" name="amount" value="<?php echo $params['total']; ?>">
                                <!-- <input type="hidden" name="scheme" value="FIRST"> -->
                                <!-- <input type="hidden" name="scheme" value="test"> -->
                                <!-- <input type="hidden" name="custID" value="c345802"> -->
                                <input type="hidden" name="currency" value="INR">
                                <input type="hidden" name="fine" value="<?php echo $params['fine']; ?>">
                                <input type="hidden" name="txn_id" value="<?php echo time(); ?>">

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:none">
        <form id="sendFormReq"
            action="https://invoicexpressnew.yesbank.in/pay/web/pushapi/index" method="post">

            <input type="hidden" name="request" value="" id="request" />
            <input type="hidden" name="merchant_code" value="dmed_101_tjuhX" />
        </form>

    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://pgtest.atomtech.in/staticdata/ots/js/atomcheckout.js"></script>
<!--    <script src="https://psa.atomtech.in/staticdata/ots/js/atomcheckout.js"></script>  for production-->
<script type="text/javascript">
    $(document).ready(function() {

        $("#btnSubmit").click(function(e) {
            e.preventDefault();

            var str = $("#form").serialize();

            $.ajax({
                type: 'POST',
                cache: false,
                data: str,
                url: "<?php echo base_url('parent/nttdata/payment') ?>",
                success: function(response) {
                    console.log(response)
                    document.getElementById('request').value=response;
                    document.getElementById('sendFormReq').submit();

                }
            });
        });
    });
</script>

</html>