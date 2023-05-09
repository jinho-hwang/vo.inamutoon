<style>
    #graph {
        height: 250px;
        margin: 20px auto 0 auto;
    }
</style>
<script>
    $(document).ready(function(){
        $('#search').click(function(){
            location.href = '<?echo(ROOT_URL);?>DashBoard/ToonView/' + $('#year').val() + '/' + $('#month').val();
        });
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">고양-EBSTOON 공모전 - 응모현황</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <td  align="center" width="100">검색월</td>
                        <td align="center" width="100">
                            <select id="year" class="form-control" style="width=100;">
                                <?for($i=-1;$i<=1;$i++){
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
                        <td width="100">
                            <select id="month" class="form-control" style="width=100;">
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
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                고양-EBSTOON 공모전 응모현황 ( 총 응모수 : <?echo(number_format($Total));?> 건)
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped" style="width:6000px;">
                        <table class="table table-striped" style="width:6000px;">
                            <thead>
                            <tr>
                                <th width="200">일자</th>
                                <?for($i=0;$i<ArrayCount($title);$i++ ){?>
                                    <th width="300"><?echo($title[$i]);?></th>
                                <?}?>
                                <th width="200">일별총합</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?for($i=1;$i<=$maxday;$i++ ){?>
                                <?$totalcnt=0;?>
                                <tr>
                                    <td><?echo($day[$i]);?></td>
                                    <?for($k=0;$k<ArrayCount($code);$k++){?>
                                        <td><?echo(number_format($data[$code[$k]][sprintf('%02d', $i)]['cnt']));?> </td>
                                        <?$totalcnt = $totalcnt + $data[$code[$k]][sprintf('%02d', $i)]['cnt'];?>
                                    <?}?>
                                    <td><?echo(number_format($totalcnt));?> </td>
                                </tr>
                            <?}?>
                            <tr>
                                <td>총합</td>
                                <?for($k=0;$k<ArrayCount($code);$k++){?>
                                    <td><?echo(number_format($Sum[$code[$k]]));?> </td>
                                <?}?>
                                <td><?echo(number_format($Total));?></td>
                            </tr>
                            </tbody>
                        </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>


</div>