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
                location.href = '<?echo(ROOT_URL);?>Data/Analytics1/' + pcode + '/' + $('#year').val() + '/' + $('#month').val();
            }

        });


        $('#search2').click(function(){
            location.href = '<?echo(ROOT_URL);?>Data/Analytics1';
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
            <h1 class="page-header">작품 기간내 회차별 View 통계</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <td  align="center" width="100">제목</td>
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
                <?echo($title);?> ( 총 누적 : <?echo(number_format($total1));?> / 총 Unique : <?echo(number_format($total2));?>)
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped" >
                        <table class="table table-striped" style="width:300px;text-align: center;"  >
                            <thead>
                            <tr>
                                <th width="50" style="text-align: center;">회차</th>
                                <th width="100" style="text-align: center;">누적 </th>
                                <th width="100" style="text-align: center;">Unique</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?for($i=1;$i<=$maxday;$i++ ){?>
                                <tr>
                                    <td><?echo($i.'회차')?> </td>
                                    <td><?echo($data['val1_'.fn_formatZero($i,2)])?> </td>
                                    <td><?echo($data['val2_'.fn_formatZero($i,2)])?> </td>
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