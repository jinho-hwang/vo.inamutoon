<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?echo(C_TITLE);?></title>

    <link rel="stylesheet" href="<?echo(ASSETS_ROOT);?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?echo(ASSETS_ROOT);?>/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="<?echo(ASSETS_ROOT);?>/css/bootstrapValidator.min.css" />

    <script type="text/javascript" src="<?echo(ASSETS_ROOT);?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?echo(ASSETS_ROOT);?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?echo(ASSETS_ROOT);?>/js/bootstrapValidator.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?echo(ASSETS_ROOT);?>/js/html5shiv.min.js"></script>
      <script src="<?echo(ASSETS_ROOT);?>/js/respond.min.js"></script>
    <![endif]-->
</head>
<body style="background-color:#63dd14;">
<form id="defaultForm" method="post" class="form-horizontal" action="<?echo(ROOT_URL);?>Login/Login_do">
<table border="0" cellspacing="0" cellpadding="0" width="100%" >
    <tr><td height="100px">&nbsp;</td></tr>
    <tr>
        <td align="center" style="vertical-align: middle;">
            <table width="1220" border="0" cellspacing="0" cellpadding="0" style="background-color: #FFFFFF;">
                <tr>
                    <td><img src="/assets/img/n_top1.jpg" width="1220" height="123" /></td>
                </tr>
                <tr>
                    <td><table width="1220" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="303"><img src="/assets/img/n_left.jpg" width="304" height="491" /></td>
                                <td><table width="61" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td><img src="/assets/img/n_m1.jpg" width="611" height="149" /></td>
                                        </tr>
                                        <tr>
                                            <td height="172" width="611" align="center">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="90">&nbsp;</td>
                                                        <td>
                                                            <div class="form-group" >
                                                                <div class="col-lg-5" style="width:441px;">
                                                                    <input type="text" class="form-control" name="uid" value=""/>
                                                                </div>
                                                            </div>

                                                            <div class="form-group" >
                                                                <div class="col-lg-5" style="width:441px;">
                                                                    <input type="password" class="form-control" name="pwd" value=""/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td width="90">&nbsp;</td>
                                                    </tr>
                                                 </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"><button type="submit"  style="width:440px;height:60px;background:url(/assets/img/n_btn-ok.jpg) 0 0 no-repeat;border: 0;color:#FFFFFF;font-size: 19px;">로그인</button></td>
                                        </tr>

                                        <tr>
                                            <td height="90">&nbsp;</td>
                                        </tr>
                                    </table></td>
                                <td width="306"><img src="/assets/img/n_right.jpg" width="305" height="491" /></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td><img src="/assets/img/n_foot1.jpg" width="1220" height="126" /></td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</form>



<script type="text/javascript">
 $(document).ready(function() {
    $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                uid: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: '아이디는 필수 입력입니다.'
                        },
                        stringLength: {
                            min: 5,
                            max: 20,
                            message: '아이디는 5자 이상 20자 미만이어야 합니다.'
                        },
                        /*remote: {
                            url: 'remote.php',
                            message: 'The username is not available'
                        },*/
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: '아이디는 영문자, 숫자로만 구성되어야 합니다.'
                        }
                    }
                },
                pwd: {
                    validators: {
                        notEmpty: {
                            message: '비밀번호는 필수 입력입니다.'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                if (result.login) {
                    location.reload();
                } else {
                    alert('아이디와 비밀번호가 일치하지 않습니다.');
                }
            }, 'json');
        });
});
</script>
    <script type="text/javascript" src="<?echo(ASSETS_ROOT);?>/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
