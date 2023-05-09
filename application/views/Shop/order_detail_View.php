<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?echo(C_TITLE);?></title>

    <!-- jQuery -->
    <script src="<?echo(ASSETS_ROOT);?>/addon/sb-admin/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?echo(ASSETS_ROOT);?>/js/jquery-ui.min.js"></script>
    <script src="<?echo(ASSETS_ROOT);?>/js/jquery.redirect.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?echo(ASSETS_ROOT);?>/addon/sb-admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?echo(ASSETS_ROOT);?>/js/bootstrapValidator.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?echo(ASSETS_ROOT);?>/addon/sb-admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?echo(ASSETS_ROOT);?>/addon/sb-admin/dist/js/sb-admin-2.js"></script>

    <!-- jqgrid js -->
    <script src="<?echo(ASSETS_ROOT);?>/addon/jqgrid/js/jquery.jqGrid.min.js"></script>
    <script src="<?echo(ASSETS_ROOT);?>/addon/ajaxFileUploader/ajaxfileupload.js"></script>
    <script src="<?echo(ASSETS_ROOT);?>/js/jquery-ui-timepicker-addon.min.js"></script>
    <script src="<?echo(ASSETS_ROOT);?>/js/jquery-ui-timepicker-ko.js"></script>
    <script src="<?echo(ASSETS_ROOT);?>/addon/jqgrid/js/i18n/grid.locale-kr.js"></script>

    <!-- Charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>

    <!-- jQuery ui css -->
    <link href="<?echo(ASSETS_ROOT);?>/addon/jqgrid/css/jquery-ui/jquery-ui.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="<?echo(ASSETS_ROOT);?>/addon/sb-admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?echo(ASSETS_ROOT);?>/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?echo(ASSETS_ROOT);?>/css/bootstrapValidator.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?echo(ASSETS_ROOT);?>/addon/sb-admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?echo(ASSETS_ROOT);?>/addon/sb-admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!--link href="<?echo(ASSETS_ROOT);?>/addon/sb-admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"-->

    <!-- jqgrid CSS -->
    <link href="<?echo(ASSETS_ROOT);?>/addon/jqgrid/css/ui.jqgrid.css" rel="stylesheet">
    <link href="<?echo(ASSETS_ROOT);?>/css/admin_default.css" rel="stylesheet">

    <!-- Charts -->
    <link href="<?echo(ASSETS_ROOT);?>/css/morris.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<script>
    function Input_del(id){
        var del = $('#dnum' + id).val();
        var oCode = '<?echo($oCode);?>';
        if(del==''){
            alert('송장번호를 입력하세요.');
            $('#dnum'+id).focus();
        }else{

            $.redirect('/Shop/Order/Input_DelNum', {'sn': id, 'del': del ,'oCode':oCode});
        }
    }

    function Update_del(id){
        var del = $('#dnum' + id).val();
        var oCode = '<?echo($oCode);?>';
        if(del==''){
            alert('송장번호를 입력하세요.');
            $('#dnum'+id).focus();
        }else{

            $.redirect('/Shop/Order/Update_DelNum', {'sn': id, 'del': del ,'oCode':oCode});
        }
    }

    function Update_Complete(id){
        if(confirm("해당 배송을 완료 차리 하시겠습니까?")==true){
            var oCode = '<?echo($oCode);?>';
            $.redirect('/Shop/Order/Update_Complete', {'sn': id,'oCode':oCode});
        }
    }


    function Update_Allow_Return(id){
        if(confirm("해당 주문상품의 반품을 허가 하시겠습니까?")==true){
            var oCode = '<?echo($oCode);?>';
            $.redirect('/Shop/Order/Update_Allow_Return', {'sn': id,'oCode':oCode});
        }
    }

    function Update_Allow_Return2(id){
        if(confirm("해당 주문상품의 반품을 완료 하시겠습니까?")==true){
            var oCode = '<?echo($oCode);?>';
            $.redirect('/Shop/Order/Update_Allow_Return2', {'sn': id,'oCode':oCode});
        }
    }

    function Update_Allow_Calcel(id){
        if(confirm("해당 주문상품의 취소를 허가 하시겠습니까?")==true){
            var oCode = '<?echo($oCode);?>';
            $.redirect('/Shop/Order/Update_Allow_Cancel', {'sn': id,'oCode':oCode});
        }
    }


    function form_ini(){
        location.reload();
    }

</script>
<body>
<div id="wrapper" class="container">
    <div class="row">
        <div class="col-lg-24">
            <h1 class="page-header">주문내역(주문번호:<?echo($oCode);?>)</h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                   주문자 정보
                </div>
                <div class="panel-body">
                    <p>이 름  : <?echo($delivery[0]['sName']);?></p><br>
                    <p>이메일  : <?echo($delivery[0]['sEmail']);?></p><br>
                    <p>전화번호 : <?echo($delivery[0]['sTel1']);?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    배송자 정보
                </div>
                <div class="panel-body">
                    <p>이 름  : <?echo($delivery[0]['rName']);?></p><br>
                    <p>주소  : <?echo($delivery[0]['rAddress1']);?> <?echo($delivery[0]['rAddress2']);?></p><br>
                    <p>전화번호 : <?echo($delivery[0]['rTel1']);?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-24">
        <div class="panel panel-default">
            <div class="panel-heading">
                주문상품
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive table-bordered">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>상품코드</th>
                            <th>상품명</th>
                            <th>상품가</th>
                            <th>택배업체</th>
                            <th>배송가격</th>
                            <th>주문상태</th>
                            <th>송장번호</th>
                        </tr>
                        </thead>
                        <tbody>
                <?if(ArrayCount($product)>0){?>
                    <?foreach($product as $d){?>
                        <tr>
                            <td><?echo($d['pCode']);?></td>
                            <td><?echo($d['pTitle']);?></td>
                            <td><?echo($d['price']);?></td>
                            <td><?echo($d['dName']);?></td>
                            <td><?echo($d['delivery']);?></td>
                            <td><?echo(order_status($d['status']));?></td>
                        <?if($d['status']==0){?>
                            <td colspan="2">&nbsp;</td>
                        <?}else if($d['status']==2){?>
                            <td colspan="2"><input type="text" name="dnum<?echo($d['sn']);?>" id="dnum<?echo($d['sn']);?>" value="<?echo($d['delivery_num']);?>"/> <input type="button" value="등록" onclick="Input_del('<?echo($d['sn']);?>');" /></td>
                        <?}else if($d['status']==3){?>
                            <td><input type="text" name="dnum<?echo($d['sn']);?>" id="dnum<?echo($d['sn']);?>" value="<?echo($d['delivery_num']);?>"/> <input type="button" value="수정" onclick="Update_del('<?echo($d['sn']);?>');" /> <input type="button" value="완료처리" onclick="Update_Complete('<?echo($d['sn']);?>');" /></td>
                        <?}else if($d['status']==4){?>
                            <td><?echo($d['delivery_num']);?></td>
                            <td>&nbsp;</td>
                        <?}else if($d['status']==5){?>
                            <td colspan="2"><input type="button" value="반품허가처리" onclick="Update_Allow_Return('<?echo($d['sn']);?>');" /></td>
                        <?}else if($d['status']==7){?>
                            <td colspan="2"><input type="button" value="취소완료처리" onclick="Update_Allow_Calcel('<?echo($d['sn']);?>');" /></td>
                        <?}else if($d['status']==9){?>
                            <td colspan="2"><input type="button" value="반품완료처리" onclick="Update_Allow_Return2('<?echo($d['sn']);?>');" /></td>
                        <?}else{?>
                            <td colspan="2">&nbsp;</td>
                        <?}?>
                        </tr>
                    <?}?>
                <?}?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-6 -->
    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="form_ini();">새로 고침</button>
</div>
</body>
</html>