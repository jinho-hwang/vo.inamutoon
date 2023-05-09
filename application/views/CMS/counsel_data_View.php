<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?echo($title);?> - <?echo($pNum);?> 감수 내용</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row" style="padding-left: 20px;padding-right: 20px;">
        <h4>자문위원단</h4>
    <?if(ArrayCount($gmember)>0){?>
        <?foreach($gmember as $d){?>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?if($d['isStatus']==0){?>
                    성명 : <?echo($d['wname']);?> / 상태 : <?echo('요청 대기');?>
                    <?}else if($d['isStatus']==1){?>
                    성명 : <?echo($d['wname']);?> / 상태 : <?echo('감수 요청 완료');?>
                    <?}else if($d['isStatus']==2){?>
                    성명 : <?echo($d['wname']);?> / 상태 : <?echo('감수 진행중');?>
                    <?}else if($d['isStatus']==3){?>
                    성명 : <?echo($d['wname']);?> / 상태 : <?echo('감수 완료');?>
                    <?}?>
                </div>
                <div class="panel-body">
                    <p><?echo($d['Comment']);?></p>
                </div>
                <div class="panel-footer">
                    <?if($d['c_result']==0){?>
                    결과 : 미감수
                    <?}else if($d['c_result']==1){?>
                    결과 : 적합
                    <?}else if($d['c_result']==2){?>
                    결과 : 부적합
                    <?}?>
                    <?if($d['ctyp']==1 && $isStatus==2){?>
                        / <button class="btn btn-default" onclick="Reset_Com('<?echo($d['cid']);?>','<?echo($d['sn']);?>');">강제처리 취소</button>
                    <?}?>
                </div>
            </div>
        </div>

        <?}?>
    <?}?>
        <br><br>
        <h4>EBS위원단</h4>
        <?if(ArrayCount($emember)>0){?>
            <?foreach($emember as $d){?>
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?if($d['isStatus']==0){?>
                                성명 : <?echo($d['wname']);?> / 상태 : <?echo('요청 대기');?>
                            <?}else if($d['isStatus']==1){?>
                                성명 : <?echo($d['wname']);?> / 상태 : <?echo('감수 요청 완료');?>
                            <?}else if($d['isStatus']==2){?>
                                성명 : <?echo($d['wname']);?> / 상태 : <?echo('감수 진행중');?>
                            <?}else if($d['isStatus']==3){?>
                                성명 : <?echo($d['wname']);?> / 상태 : <?echo('감수 완료');?>
                            <?}?>
                        </div>
                        <div class="panel-body">
                            <p><?echo($d['Comment']);?></p>
                        </div>
                        <div class="panel-footer">
                            <?if($d['c_result']==0){?>
                                결과 : 미감수
                            <?}else if($d['c_result']==1){?>
                                결과 : 적합
                            <?}else if($d['c_result']==2){?>
                                결과 : 부적합
                            <?}?>
                            <?if($d['ctyp']==1  && $isStatus==5){?>
                                / <button class="btn btn-default" onclick="Reset_Com('<?echo($d['cid']);?>','<?echo($d['sn']);?>');">강제처리 취소</button>
                            <?}else if($d['ctyp']==1  && $isStatus==8){?>
                                / <button class="btn btn-default" onclick="Reset_Com('<?echo($d['cid']);?>','<?echo($d['sn']);?>');">강제처리 취소</button>
                            <?}?>
                        </div>
                    </div>
                </div>
            <?}?>
        <?}?>
    </div>
</div>
<br><br>
<?if(ArrayCount($recom) > 0){?>
<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading">
           재감수 부적격 사유
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive table-bordered">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>셩명</th>
                        <th>등록일자</th>
                        <th>사유</th>
                    </tr>
                    </thead>
                    <tbody>

                <?foreach($recom as $d){?>
                    <tr>
                        <td><?echo($d['sn']);?></td>
                        <td><?echo($d['wname']);?></td>
                        <td><?echo($d['regidate']);?></td>
                        <td><?echo($d['Comment']);?></td>
                    </tr>
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
<?}?>

