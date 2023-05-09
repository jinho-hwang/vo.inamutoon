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
$(document).ready(function() {
    $('#btnreply').click(function(){
        if($('#content').val()==''){
            alert("문의 답변을 입력하세요.");
            $('#content').attr('placeholder','');
            $('#content').focus();
        }else{
            var currentString = $("#content").val()
            if (currentString.length > 500 )  {  
                alert("답변 내용은 500자 까지만 가능합니다.");
                $('#content').focus();
            }else if(confirm("답변 글을 등록하시겠습니까?")==true){
                $("#reply").submit();                
            }        
         }
    });
 });
</script>
<body>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">답변</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <?foreach($list as $value){?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <? echo($value['regidate']);?>
                        </div>
                        <div class="panel-body">
                            <p class="help-block"><? echo($value['content']);?></p>
                        </div>
                    </div>
                <?}?>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <form name="reply" id="reply" method="post" action="<?echo(ROOT_URL);?>/Answer/Reply_do">
                                    <input type="hidden" value="<? echo($Bnum);?>" id="Bnum" name="Bnum" />
                                    <div class="form-group">
                                        <label>답변작성</label>
                                        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                                    </div>
                                    <button type="button" id="btnreply" name="btnreply" class="btn btn-primary btn-lg btn-block">작성하기</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
</body>
</html>