<script type="text/javascript">

    function go_write(id){
//                popupOpen("/admin/Board/Write/" + id,420,900);
        popupOpen("<?echo(ROOT_URL);?>Board/Write/" + id,1000,900);
    }

    function go_View(id){
//                popupOpen("/admin/Board/Bview/" + id,420,1000);
        popupOpen("<?echo(ROOT_URL);?>Board/Bview/" + id,1000,1000);
    }

    function view_thumb(val){
        window.open("/assets/upload/board/thumb/" + val);
    }

    function ck_Agree(val1,val2){
        if(val2 ==1){
            msg = '게시를 승인 하시겠습니까?';
        }else{
            msg = '게시를 승인취소 하시겠습니까?';
        }

        if(window.confirm(msg)==true) {
            //window.location.href = "/admin/Board/Ch_Agree/" + val1 + "/" + val2;
            popupOpen("<?echo(ROOT_URL);?>Board/Ch_Agree/" + val1 + "/" + val2,600,300,100,100);
        }
    }

    function ck_Fix(val1,val2){
        if(val2 ==1){
            msg = '해당글을 고정 하시겠습니까?';
        }else{
            msg = '해당글을 미고정 하시겠습니까?';
        }

        if(window.confirm(msg)==true) {
            //window.location.href = "/admin/Board/Ch_Agree/" + val1 + "/" + val2;
            popupOpen("<?echo(ROOT_URL);?>Board/Ch_Fix/" + val1 + "/" + val2,600,300,100,100);
        }
    }

    function freeView(val){
        popupOpen("<?echo(ROOT_URL);?>Board/FreeView/" + val,1100,800);
    }

    function booking_View(){
        var URL = "<?echo(ROOT_URL);?>Re_Mams/View";
        window.open(URL);
    }
</script>

<?if((int)$env[0]['bType'] ==0){?>

    <?if($typ == 0){?>
        <div class="col-lg-10">
    <?}else{?>
        <div style="padding-left:300px; ">
    <?}?>
    <div class="panel panel-default">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?echo($env[0]['bname']);?></h1>
                <?if($env[0]['bid'] == 2){?>
                <div align="right"><input type="button" value="예약하기"  onclick="javascript:booking_View();" /></div>
                <?}?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td align="center">글번호</td>
                        <td align="center">글제목</td>
                        <td align="center">작성자</td>
                        <td align="center">클릭수</td>
                        <td align="center">일자</td>
                        <td align="center">승인</td>
                        <td align="center">고정</td>
                        <td align="center">업데이트일자</td>
                        <td align="center">미리보기</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($board as $key){?>
                        <tr>
                            <td align="center" width="100"><?echo($key['bcode']);?></td>
                            <td align="center"><a href="javascript:go_View('<?echo($key['bcode']);?>');"><?echo($key['bTitle']);?></a></td>
                            <td align="center" width="150"><?echo($key['writer']);?></td>
                            <td align="center" width="100"><?echo($key['bHit']);?></td>
                            <td align="center" width="200"><?echo($key['regidate']);?></td>
                            <?if($key['isAgree']){?>
                                <td align="center" width="80"><a href="javascript:ck_Agree('<?echo($key['bcode']);?>',0);"><strong><font color="BLUE">승인</font></strong></td>
                            <?}else{?>
                                <td align="center" width="80"><a href="javascript:ck_Agree('<?echo($key['bcode']);?>',1);"><strong><font color="RED">미승인</font></strong></td>
                            <?}?>
                            <?if($key['isFix']){?>
                                <td align="center" width="80"><a href="javascript:ck_Fix('<?echo($key['bcode']);?>',0);"><strong><font color="BLUE">고정</font></strong></td>
                            <?}else{?>
                                <td align="center" width="80"><a href="javascript:ck_Fix('<?echo($key['bcode']);?>',1);"><strong><font color="RED">미고정</font></strong></td>
                            <?}?>
                            <?if(is_null($key['update_date'])){?>
                            <td align="center" width="150">&nbsp;</td>
                            <?}else{?>
                                <td align="center" width="150"><?echo($key['update_date']);?></td>
                            <?}?>
                            <td align="center" width="100"><a href="javascript:freeView('<?echo($key['bcode']);?>',1);"><strong>미리보기</strong></td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
        <div align="center" style="font-size: 30px;"><?echo($page);?></div>
        <div class="panel-heading">
            <input type="button" value="글쓰기" onclick="javascript:go_write('<?echo($env[0]['bid']);?>');" />
        </div>
    </div>
    <!-- /.panel -->
<?}else{?>
    <?if($typ == 0){?>
        <div class="col-lg-10">
    <?}else{?>
        <div style="padding-left:300px; ">
    <?}?>
    <div class="panel panel-default">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?echo($env[0]['bname']);?></h1>
                <?if($env[0]['bid'] == 2){?>
                    <div align="right"><input type="button" value="예약하기"  onclick="javascript:booking_View();" /></div>
                <?}?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body" align="center">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <?$i=0;?>
                <?foreach($board as $key){
                    if(($i%4)==0){echo("<tr>");};
                    ?>
                    <td style="border: solid;border-color: #000000;border-width: 1px;width:200px;height:200px; " align="center">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td height="140" align="center"><img src="<?echo(ASSETS_HOME);?>/data/board/thumb/<?echo($key['thumb']);?>" width="180" height="180" /></td>
                            </tr>
                            <tr>
                                <td align="center"><a href="javascript:go_View('<?echo($key['bcode']);?>');"><?echo($key['bTitle']);?></a>
                                    <br /><?echo($key['bHit']);?>읽음
                                    <br /> <?echo($key['regidate']);?><br />
                                    <?if($key['isAgree']){?>
                                    <a href="javascript:ck_Agree('<?echo($key['bcode']);?>',0);"><strong><font color="BLUE">승인</font></strong>
                                        <?}else{?>
                                        <a href="javascript:ck_Agree('<?echo($key['bcode']);?>',1);"><strong><font color="RED">미승인</font></strong>
                                            <?}?>
                                            / <a href="javascript:freeView('<?echo($key['bcode']);?>',1);"><strong>미리보기</strong>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <?  if((($i%4)-3)==0){
                        echo("</tr>");
                        $i++;
                    }else {
                        $i++;
                    }
                }?>
                </tbody>
            </table>

            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
        <div align="center" style="font-size: 30px;"><?echo($page);?></div>
        <div class="panel-heading">
            <input type="button" value="글쓰기" onclick="javascript:go_write('<?echo($env[0]['bid']);?>');" />
        </div>
    </div>
    <!-- /.panel -->

<?}?>