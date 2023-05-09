<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>
    $(document).ready(function(){
        $('#search').click(function(){
            location.href = '<?echo(ROOT_URL);?>Data/Part/' + $('#part').val();
        });
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="page-header">장르별 선호 작품</h1>
                    <div class="form-group">
                        <table>
                            <tr>
                                <td  align="center" width="100">장르</td>
                                <td>
                                    <select id="part" class="form-control">
                                        <?if($part==0){?>
                                        <option value="0" selected>전체</option>
                                        <?}else{?>
                                        <option value="0" >전체</option>
                                        <?}?>
                                        <?if($part==1){?>
                                        <option value="1" selected>감성</option>
                                        <?}else{?>
                                        <option value="1" >감성</option>
                                        <?}?>
                                        <?if($part==2){?>
                                            <option value="2" selected>액션</option>
                                        <?}else{?>
                                            <option value="2" >액션</option>
                                        <?}?>
                                        <?if($part==3){?>
                                            <option value="3" selected>일상</option>
                                        <?}else{?>
                                            <option value="3" >일상</option>
                                        <?}?>
                                        <?if($part==4){?>
                                            <option value="4" selected>스포츠</option>
                                        <?}else{?>
                                            <option value="4" >스포츠</option>
                                        <?}?>
                                        <?if($part==5){?>
                                            <option value="5" selected>판타지</option>
                                        <?}else{?>
                                            <option value="5" >판타지</option>
                                        <?}?>
                                        <?if($part==6){?>
                                            <option value="6" selected>학습</option>
                                        <?}else{?>
                                            <option value="6" >학습</option>
                                        <?}?>
                                        <?if($part==7){?>
                                            <option value="7" selected>SF</option>
                                        <?}else{?>
                                            <option value="7" >SF</option>
                                        <?}?>
                                    </select>
                                </td>
                                <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?if($part > 0){?>
                <div class="panel-body">
                    <div id="container" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>
                </div>
                <?}else{?>
                <div class="panel-body">
                    <div id="container1" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>
                </div>
                <?}?>
                <?if($part > 0){?>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>웹툰이름 </th>
                                <th>구독수</th>
                                <th>비율</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?$i=1;?>
                            <?foreach($data as $d){
                                if(!empty($d['title'])) {?>
                                    <tr>
                                        <td><? echo($i); ?></td>
                                        <td><? echo($d['title']); ?></td>
                                        <td><? echo(number_format($d['Cnt'])); ?></td>
                                        <td><? echo(fnPercent("slice",$total,$d['Cnt'])); ?>%</td>
                                    </tr>
                                    <?    $i++;
                                }
                            }
                            $tCnt = $i;
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <?}?>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
    </div>
</div>
<script type='text/javascript'>
    <?if($part > 0){?>
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [
            <?ArrayCount($graph) < 10 ? $tCnt = ArrayCount($graph) : $tCnt = 10;
            $i=1;
             foreach($graph as $d){
                    if(!empty($d['title'])){
            ?>
                {
                    name: '<?echo($d['title']);?>',
                    y: <? echo($d['Cnt']); ?>
                }
                <? if($i<$tCnt) echo(',');
                    $i++;
                ?>
                <?}
                }?>
            ]
        }]
    });
    <?}else{?>

    Highcharts.chart('container1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '전체 장르별 구독수'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [
                <?$i=1;
                 $tCnt = ArrayCount($tData);
                 foreach($tData as $d){?>
                {
                    name: '<?echo($d['title']);?>',
                    y: <? echo($d['Cnt']); ?>
                }
                <? if($i<$tCnt) echo(',');
                    $i++;
                }?>
            ]
        }]
    });
    <?}?>
</script>
