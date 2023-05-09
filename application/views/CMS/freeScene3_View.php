<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>아이나무툰</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,  user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="https://www.ebstoon.com/assets/new/css/style.css" />
    <script type="text/javascript" src="https://www.ebstoon.com/assets/new/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.ebstoon.com/assets/new/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://www.ebstoon.com/assets/new/js/front_js.js"></script>
    <script type="text/javascript" src="https://www.ebstoon.com/assets/new/js/jquery.bxslider.js"></script>
    <script type="text/javascript" src="https://www.ebstoon.com/assets/new/js/menu.js"></script>
</head>
<style>
    body {
        padding:0px;
        margin:0px;
    }

    img { display: block; border: 0;vertical-align: bottom;};
</style>

<body>
    <table cellpadding="0" cellspacing="0">
    <?foreach($data as $d){?>
    <tr><td><img src="<?echo(CONTENT_ROOT);?>/assets/data/cartoon_scene2/mobile/<?echo($d['imgname']);?>" width="720" alt=""/></td></tr>
    <?}?>
    </table>
</body>
</html>