<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>아이나무툰</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,  user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="http://www.inamutoon.com/assets/new/css/style.css" />
    <script type="text/javascript" src="http://www.inamutoon.com/assets/new/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://www.inamutoon.com/assets/new/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://www.inamutoon.com/assets/new/js/front_js.js"></script>
    <script type="text/javascript" src="http://www.inamutoon.com/assets/new/js/jquery.bxslider.js"></script>
    <script type="text/javascript" src="http://www.inamutoon.com/assets/new/js/menu.js"></script>
</head>
<style>
    body {
        padding:0px;
        margin:0px;
    }
</style>
<script>
    $(function() {
        $(".contents img, .resizablebox").each(function() {
            var oImgWidth = $(this).width();
            var oImgHeight = $(this).height();
            $(this).css({
                'max-width':oImgWidth+'px',
                'max-height':oImgHeight+'px',
                'width':'100%',
                'height':'100%'
            });
        });
    });
</script>
<body>
<div id="container" class="type">
    <header id="dHead">
        <div class="header">
            <a href="javascript:history.back(1);" class="btn_prevPg">이전</a>
            <h1 class="h1_tit"><a href="#1">미리보기</a></h1>
        </div>
    </header>
    <!-- dBody -->
    <section class="contents">
        <div class="board_view">
            <h2><?echo($data[0]['bTitle']);?></h2>
            <p class="infor"><span><?echo($data[0]['writer']);?>｜<?echo($data[0]['regidate']);?></span></p>
            <?if(!empty($data[0]['main_thumb'])){?>
            <p class="thum"><img src="<?echo(ASSETS_HOME);?>/data/board/thumb/<?echo($data[0]['main_thumb']);?>" alt="" /></p>
            <?}?>
            <div class="memo"><p><?echo($data[0]['bContent']);?></p></div>
            <p class="btn"><span class="btn_share"><a href="#">공유하기</a></span></p>
        </div>
        <div class="paging">
            <a href="이전" class="prev">이전</a>
            <p><strong>5</strong>｜<span>16</span></p>
            <a href="다음" class="next">다음</a>
        </div>
    </section>
    <!-- //dBody -->
</div><!-- //#container -->

<!-- menu -->
<div id="main-sidebar" class="main-sidebar main-sidebar-left">
    <div id="main-sidebar-wrapper" class="main-sidebar-wrapper">
        <div class="had">
            <a href="../main.html" class="btn_home">홈</a>
            <div class="infor">
                <p class="user">inamu123456</p>
                <p class="email">@inamutoon.com</p>
            </div>
            <ul>
                <li class="m01"><a href="mybook.html">내 서재</a></li>
                <li class="m02"><a href="gift.html">선물함</a></li>
                <li class="m03"><a href="charge.html">코인충전</a></li>
            </ul>
        </div>
        <nav>
            <ul class="mobile_navi">
                <li><div class="depth1"><a href="coin.html">코인 내역</a></div></li>
                <li><div class="depth1"><a href="point.html">포인트 내역</a></div></li>
                <li><div class="depth1"><a href="mypage.html">내 정보</a></div></li>
                <li><div class="depth1"><a href="#1" class="has_child">고객센터</a></div>
                    <ul class="depth2">
                        <li><a href="cus.html">온라인 문의</a></li>
                        <li><a href="service.html">서비스 소개</a></li>
                        <li><a href="policy.html">약관 및 정책</a></li>
                    </ul>
                </li>
                <li class="log"><div class="depth1"><a href="#1">로그아웃</a></div></li>
            </ul>
        </nav>
        <script type="text/javascript">
            <!--
            mobileNavi('.mobile_navi');
            //-->
        </script>
    </div>
</div>
<!--// menu -->

<!-- webResponse -->
<script type="text/javascript">
    <!--
    webResponse();
    //-->
</script>

</body>
</html>