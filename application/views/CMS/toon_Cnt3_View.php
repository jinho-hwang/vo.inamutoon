<style>
    #graph {
        height: 250px;
        margin: 20px auto 0 auto;
    }
</style>
<script>
    $(document).ready(function(){

        $('#search').click(function(){
            var pcode = $('#Selectid').val();
            if(pcode==''){
                alert('작품을 검색하세요.');
            }else{
                location.href = '<?echo(ROOT_URL);?>Data/Analytics2/' + pcode + '/' + $('#year').val() + '/' + $('#month').val();
            }
        });

        $('#search2').click(function(){
            location.href = '<?echo(ROOT_URL);?>Data/Analytics2';
        });

        $("input[name=searchTitle]").keydown(function (key) {
            if(key.keyCode == 13){//키가 13이면 실행 (엔터는 13)
                var title = encodeURI($('#searchTitle').val());
                popupOpen('./SearchTitle/' + title,500,500,100,100);
            }
        });

    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <input type="hidden" id="Selectid" name="Selectid" value="<?echo($pcode);?>" />
            <h1 class="page-header">작품별 기간내 회차별 매출 통계</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <td  align="center" width="100">검색월</td>
                        <td  align="center" width="300">
                            <?if($pcode==''){?>
                                <input type="text" id="searchTitle" name="searchTitle"  style="width:300px;" value="" />
                            <?}else{?>
                                <input type="text" id="searchTitle" name="searchTitle"  style="width:300px;" value="<?echo($title);?>" disabled />
                            <?}?>
<!--                            <select id="pcode" class="form-control" style="width:300px;">-->
<!--                                <option value="">선택하세요.</option>-->
<!--                                --><?//echo($option);?>
<!--                            </select>-->

                        </td>
                        <td  align="center" width="100">검색월</td>
                        <td>
                            <select id="year" class="form-control">
                                <?for($i=-2;$i<=1;$i++){
                                    if($year==(date('Y')+$i)){
                                        ?>
                                        <option selected><?echo(date('Y')+$i);?></option>
                                    <?	}else{
                                        ?>
                                        <option ><?echo(date('Y')+$i);?></option>
                                    <?	}
                                }?>
                            </select>
                        </td>
                        <td width="20" align="center">/</td>
                        <td>
                            <select id="month" class="form-control">
                                <?for($i=1;$i<=12;$i++){
                                    if($month==$i){
                                        ?>
                                        <option selected><?echo(str_pad($i,2,"0",STR_PAD_LEFT));?></option>
                                        <?
                                    }else{
                                        ?>
                                        <option ><?echo(str_pad($i,2,"0",STR_PAD_LEFT));?></option>
                                        <?
                                    }
                                }?>
                            </select>
                        </td>
                        <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                        <td width="100" align="center"><button id="search2" class="btn btn-default">초기화</button></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <?if($pcode!=''){?>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?echo($title);?> ( 총 free : <?echo(number_format($total1));?> / 총 cash : <?echo(number_format($total2));?>)
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped" >
                        <table class="table table-striped" style="width:300px;text-align: center;" >
                            <thead>
                            <tr>
                                <th width="50px" style="text-align: center;">회차</th>
                                <th width="200px" style="text-align: center;">유료 / 무료</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?for($i=1;$i<=$maxday;$i++ ){?>
                                <tr>
                                    <td><?echo($i.'회차')?> </td>
                                    <td>
                                        <table class="table table-striped" >
                                        <?if(ArrayCount($data['data_'.fn_formatZero($i,2)])>0){?>
                                            <?foreach($data['data_'.fn_formatZero($i,2)] as $d){?>
                                                <tr>
                                                    <td><?echo($d['cash'])?></td>
                                                    <td><?echo($d['free'])?></td>
                                                </tr>
                                            <?}?>
                                        <?}else{?>
                                            <tr>
                                                <td>0</td>
                                                <td>0</td>
                                            </tr>
                                        <?}?>
                                        </table>
                                    </td>
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
</div>


</div>