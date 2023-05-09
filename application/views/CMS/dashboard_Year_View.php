<style>
    #graph {
        height: 250px;
        margin: 20px auto 0 auto;
    }
</style>
<script>
    $(document).ready(function(){
        $('#search').click(function(){
            location.href = '<?echo(ROOT_URL);?>DashBoard/Year/' + $('#year').val() + '/' + $('#month').val();
        });

        $('#showpop1').click(function(){
            location.href = '<?echo(ROOT_URL);?>DashBoard/Year/' + $('#year').val() + '/' + $('#month').val();
        });

        $('#showpop2').click(function(){
            location.href = '<?echo(ROOT_URL);?>DashBoard/Year/' + $('#year').val() + '/' + $('#month').val();
        });

    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">년간 데이터</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <td  align="center" width="100">검색</td>
                        <td>
                            <select id="year" class="form-control">
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
                        <td width="20" align="center">년</td>
                        <td>
                        <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div>
        <h1><?echo($year.'년 ');?> 가입 차트(총 : <?echo(number_format($totalmember));?>명)</h1>
        <div id="container" style="min-width:9.68em;width:100%;height:350px;margin: 0 auto"></div>
    </div>
    <div>
        <h1><?echo($year.'년 ');?> 매출(총매출 : <?echo(number_format($charge));?>원 / Coin : <?echo(number_format($coin));?>원 / Free : <?echo(number_format($free));?>원)</h1>
        <div id="container1" style="min-width:9.68em;width:100%;height:350px;margin: 0 auto"></div>
    </div>


</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type='text/javascript'>//<![CDATA[
    $(function() {
        Highcharts.setOptions({
            lang: {
                decimalPoint: ',',
                thousandsSep: ','
            }
        });
        $('#container').highcharts({
            setOptions : {
                lang: { thousandsSep: "," }
            },
            chart: {
                alignTicks: false
            },
            title: {
                text: '',
                x: -20 //center
            },
            xAxis: {
                labels: {
                    formatter: function() {
                        return Highcharts.numberFormat(this.value,0) + '월'
                    },
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Month',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                categories: [<?echo($Xvalue);?>]
            },
            yAxis: [{ // Primary yAxis
                min: 0,
                gridLineWidth: 0,
                labels: {
                    formatter: function() {
                        return Highcharts.numberFormat(this.value,0) + '명'
                    },
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: '가입수',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, {
                min: 0,
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value:.1f}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true

            }],
            legend: {
                layout: 'horizontal',
                verticalAlign: 'top',
            },
            series: [{
                name: '총합계',
                yAxis: 0,
                data: <?echo($MCnt3);?>
            }, {
                name: 'EBSToon',
                yAxis: 0,
                data: <?echo($MCnt1);?>
            }]
        });


        Highcharts.setOptions({
            lang: {
                decimalPoint: ',',
                thousandsSep: ','
            }
        });

        $('#container1').highcharts({
            chart: {
                alignTicks: false
            },
            title: {
                text: '',
                x: -20 //center
            },
            xAxis: {
                labels: {
                    formatter: function() {
                        return Highcharts.numberFormat(this.value,0) + '월'
                    },
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Month',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                categories: [<?echo($Xvalue);?>]
            },
            yAxis: [{ // Primary yAxis
                min: 0,
                gridLineWidth: 0,
                labels: {
                    formatter: function() {
                        return Highcharts.numberFormat(this.value,0) + '원'
                    },
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: '금액',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, {
                min: 0,
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value:.1f}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true

            }],

            legend: {
                layout: 'horizontal',
                verticalAlign: 'top',
            },
            series: [{
                name: '총매출',
                yAxis: 0,
                data: <?echo($MSum1);?>
            }, {
                name: 'Coin',
                yAxis: 0,
                data: <?echo($MSum2);?>
            }, {
                name: 'Free',
                yAxis: 0,
                data: <?echo($MSum3);?>
            }]
        });
    });

</script>
