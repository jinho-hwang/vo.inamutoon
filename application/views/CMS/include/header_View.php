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
    <script src="<?echo(ASSETS_ROOT);?>/addon/sb-admin/dist/js/sb-admin-2.js?<?echo(rand());?>"></script>

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
    <link href="<?echo(ASSETS_ROOT);?>/addon/sb-admin/dist/css/sb-admin-2.css?<?echo(rand());?>" rel="stylesheet">

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

    <script src="<?echo(ASSETS_ROOT);?>/js/default.js?rand=<?echo(rand());?>"></script>


</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation"  >
            <div class="navbar-header" style="margin-bottom: 0;height:90px; background-color:#63dd14;text-align: center;width:100%;">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?echo(ROOT_URL);?>Main" style="margin-left: 30px;"><img src="/assets/img/n_logo.jpg" /></a>
            </div>
            <!-- /.navbar-header -->
            <br><br>

            <div class="navbar-default sidebar" role="navigation" style="margin-top: 50px;">
                <div class="sidebar-nav navbar-collapse" >
                    <ul class="nav" id="side-menu" >
                    <?foreach($grade as $d){?>
                        <?if($d['mbool']==1){?>
                        <li>
                            <a href="javascript://"><?echo($d['label']);?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            <?foreach($d['item'] as $c){?>
                                <li>
                                    <a href="<?echo($c['surl']);?>"><?echo($c['slable']);?></a>
                                </li>
                            <?}?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?}?>
                    <?}?>
                        <li>
                            <a href="<?echo(ROOT_URL);?>Login/Logout">로그아웃</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
