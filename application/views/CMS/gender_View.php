<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>
    $(document).ready(function(){
        $('#search').click(function(){
            location.href = '<?echo(ROOT_URL);?>Data/Gender/' + $('#gender').val();
        });
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="page-header">성별 선호 작품</h1>
                    <div class="form-group">
                        <table>
                            <tr>
                                <td  align="center" width="100">성별</td>
                                <td>
                                    <select id="gender" class="form-control">
                                        <?if($gender==1){?>
                                            <option value="1" selected>남자</option>
                                            <option value="2" >여자</option>
                                        <?}else{?>
                                            <option value="1">남자</option>
                                            <option value="2" selected>여자</option>
                                        <?}?>
                                    </select>
                                </td>
                                <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="container" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>
                </div>
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
                                    <td><? echo(fnPercent("alice",$total,$d['Cnt'])); ?>%</td>
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
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
    </div>
</div>

<script type='text/javascript'>
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
</script>