<style>
	#graph {
	  height: 250px;
	  margin: 20px auto 0 auto;
	}
</style>
<script>
	$(document).ready(function(){
		$('#search').click(function(){
			location.href = '<?echo(ROOT_URL);?>DashBoard/Data/' + $('#year').val() + '/' + $('#month').val();
		});
		
		$('#showpop1').click(function(){
			location.href = '<?echo(ROOT_URL);?>DashBoard/DataList/' + $('#year').val() + '/' + $('#month').val();
		});
		
		$('#showpop2').click(function(){
			location.href = '<?echo(ROOT_URL);?>DashBoard/DataList/' + $('#year').val() + '/' + $('#month').val();
		});
		
	});
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">월간 데이터</h1>
            <div class="form-group">
                <table>
                	<tr>
                		<td  align="center" width="100">검색월</td>
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
                	</tr>
				</table>                    
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
	<div>
		<h1><?echo($year.'년 '.$month.'월 ');?>가입 차트(총 : <?echo(number_format($totalmember));?>명 / <?echo($today);?> : <?echo($totalToday);?>명)</h1>
		<div id="container" style="min-width:9.68em;width:100%;height:350px;margin: 0 auto"></div>
	</div>
	<div>
		<h1><?echo($year.'년 '.$month.'월 ');?> 매출(총매출 : <?echo(number_format($charge));?>원 / Coin : <?echo(number_format($coin));?>원 / Free : <?echo(number_format($free));?>원)</h1>
		<div id="container1" style="min-width:9.68em;width:100%;height:350px;margin: 0 auto"></div>
	</div>
	<div>
		<h1><?echo($year.'년 '.$month.'월 ');?> 무료쿠폰(총사용량 : <?echo(number_format($couponTotal));?>개 )</h1>
		<div id="container2" style="min-width:9.68em;width:100%;height:350px;margin: 0 auto"></div>
	</div>
<!--	<div>-->
<!--		<h1>독립운동가 웹툰 통계</h1>-->
<!--		<div>-->
<!--			<table>-->
<!--				<tr>-->
<!--			--><?//$atotal = 0;?>
<!--			--><?//for($i=1;$i<=9;$i++){?>
<!--				--><?//if(ArrayCount(${'dRs'.$i})>0){?>
<!--					<td valign="top">-->
<!--						<table border="1">-->
<!--							<tr>-->
<!--								<td colspan="2" align="center" width="200px">--><?//echo(${'dRs'.$i}[0]['title']);?><!--</td>-->
<!--							</tr>-->
<!--							--><?//$dtotal = 0;?>
<!---->
<!--							--><?//foreach(${'dRs'.$i} as $v){?>
<!--							<tr>-->
<!--								<td align="center" width="100px">--><?//echo($v['sdate']);?><!--</td>-->
<!--								<td align="center" width="100px">--><?//echo($v['cnt']);?><!--</td>-->
<!--							</tr>-->
<!--								--><?//$dtotal = $dtotal + $v['cnt'];?>
<!--							--><?//}?>
<!--							<tr><td colspan="2" height="10"></td></tr>-->
<!--							<tr>-->
<!--								<td align="center" width="100px">합계</td>-->
<!--								<td align="center" width="100px">--><?//echo($dtotal);?><!--</td>-->
<!--							</tr>-->
<!--						</table>-->
<!--					</td>-->
<!--					--><?//$atotal = $atotal + $dtotal;?>
<!--				--><?//}?>
<!--					<td width="20px;"></td>-->
<!--			--><?//}?>
<!--				</tr>-->
<!--				<tr><td height="100"><strong>총 : --><?//echo($atotal);?><!-- 건</strong></td></tr>-->
<!--			</table>-->
<!--		</div>-->
<!--	</div>-->
<!--	<br><br><br><br><br>-->
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type='text/javascript'>//<![CDATA[
	$(function() {
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
						return Highcharts.numberFormat(this.value,0) + '일'
					},
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Day',
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
					name: 'inamutoon',
					yAxis: 0,
					data: <?echo($MCnt1);?>
				},{
					name: 'Naver',
					yAxis: 0,
					data: <?echo($MCnt2);?>
				},{
					name: 'Google',
					yAxis: 0,
					data: <?echo($MCnt3);?>
				},{
					name: 'Kakao',
					yAxis: 0,
					data: <?echo($MCnt4);?>
				},{
					name: 'Facebook',
					yAxis: 0,
					data: <?echo($MCnt5);?>
				},{
					name: '조선일보',
					yAxis: 0,
					data: <?echo($MCnt6);?>
                },{
                    name: '교원',
                    yAxis: 0,
                    data: <?echo($MCnt7);?>
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
						return Highcharts.numberFormat(this.value,0) + '일'
					},
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Day',
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

		$('#container2').highcharts({
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
						return Highcharts.numberFormat(this.value,0) + '일'
					},
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Day',
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
						return Highcharts.numberFormat(this.value,0) + '개'
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
				name: '갯수',
				yAxis: 0,
				data: <?echo($coupon);?>
			}]
		});
	});

</script>
