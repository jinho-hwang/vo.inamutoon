
<script>
    var initBody;


    function pageprint(mapId)
    {
        window.onbeforeprint = beforePrint(mapId);
        window.print();
        window.onafterprint = afterPrint();
    }
    function beforePrint(mapId)
    {
        initBody = document.body.innerHTML;
        document.body.innerHTML = document.all[mapId].innerHTML;
    }

    function afterPrint()
    {
        document.body.innerHTML = initBody;
    }
</script>


<script>
	$(document).ready(function(){
		$('#search').click(function(){
			if($('#wid').val()==''){
				alert('Choice Writer.');
			}else{
				$('#writer').submit();
			}
		});

        $('#search2').click(function(){
            var url = '<?echo(ROOT_URL);?>Pay/WriterDetailList/<?echo($wid);?>/' + $('#pcode').val() + '/' + $('#year').val() + '/' + $('#month').val();
            $(location).attr('href',url);
        });


        $('#excel').click(function(){
            if($('#wid').val()==''){
                alert('Please choose Writer.');
            }else {
                var url = '<?echo(ROOT_URL);?>Pay/dnWriterExcel/<?echo($wid);?>/<?echo($pcode);?>/' + $('#year').val() + '/' + $('#month').val();
                $(location).attr('href',url);
            }
        });
	});
</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">작가별  판매내역</h1>
            <div class="form-group">
                <table>
                	<tr>
                        <form id="writer" method="post" auction="<?echo(ROOT_URL);?>Pay/WriterList">
                        <td  align="center" width="100">검색월</td>
                        <td>
                            <select id="year" name="year" class="form-control">
                                <?for($i=-1;$i<=1;$i++){
                                    if($year==(date('Y')+$i)){
                                        ?>
                                        <option selected><?echo(date('Y')+$i);?></option>
                                        <?
                                    }else{
                                        ?>
                                        <option ><?echo(date('Y')+$i);?></option>
                                        <?
                                    }
                                }?>
                            </select>
                        </td>
                        <td width="20" align="center">/</td>
                        <td>
                            <select id="month" name="month" class="form-control">
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
                		<td  align="center" width="100">작가</td>
                		<td>
            			    <select id="wid" name="wid" class="form-control">
                                <option value="">선택하세요</option>
            			    	<?foreach($Writer as $val){
            			    			if($val['code']==$wid){?>
            			    		?>
                                <option selected value="<?echo($val['code']);?>"><?echo($val['wname']);?></option>
                                <?	}else{?>
                                <option  value="<?echo($val['code']);?>"><?echo($val['wname']);?></option>
                                <?	}
                                	}
                                ?>
                            </select>
                		</td>
                        <?if($wid!=''){?>
                        <td  align="center" width="100">작품</td>
                        <td>
                            <select id="pcode" name="pcode" class="form-control">
                                <option  value="0">All</option>
                                <?foreach($cartoon as $val){
                                    if($val['code']==$pcode){?>
                                        ?>
                                        <option selected value="<?echo($val['code']);?>"><?echo($val['title']);?></option>
                                    <?	}else{?>
                                        <option  value="<?echo($val['code']);?>"><?echo($val['title']);?></option>
                                    <?	}
                                }
                                ?>
                            </select>
                        </td>
                        <?}?>
                		<td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                        </form>
                        <td width="100" align="center"><button id="excel" class="btn btn-default">엑셀추출</button></td>
                        <td width="100" align="center"><button id="btn_prn" class="btn btn-default" onClick="javascript:pageprint('printArea');">인쇄하기</button></td>
                	</tr>
				</table>                    
            </div>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
     <?if($wid!=''){?>
    <div id="printArea">
        <div class="row" >
            <div class="col-lg-5">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        판매 내역
                    </div>
                    <div class="panel-body">
                        <p>1.총판매수 : <?echo(number_format($cashCnt));?> (유료:<?echo(number_format($cashCnt-$freeCnt-$splitCnt));?>건 / 부분유료 :<?echo(number_format($splitCnt));?>건 /  무료:<?echo(number_format($freeCnt));?>건) </p>
<!--                        <p>2.총 뷰수  : --><?//echo(number_format($viewCnt));?><!--건</p>-->
                        <p>2.정산 금액  : <?echo(number_format($charge['total_share']));?>원</p>
                    </div>
                    <div class="panel-footer">
                        <button id="search2" class="btn btn-default">상세내역 보기</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
             <div class="col-lg-2">
                 <div class="panel panel-success">
                     <div class="panel-heading">
                         총매출액(VAT 제외)
                     </div>
                     <div class="panel-body">
                         <p>1.<?echo(CHARGE1_NAME);?> : <?echo(number_format($charge['charge1_vat']));?>원</p>
                         <p>2.<?echo(CHARGE2_NAME);?> : <?echo(number_format($charge['charge2_vat']));?>원</p>
                         <p>3.<?echo(CHARGE3_NAME);?> : <?echo(number_format($charge['charge3_vat']));?>원</p>
                         <p>4.<?echo(CHARGE4_NAME);?> : <?echo(number_format($charge['charge4_vat']));?>원</p>

                     </div>
                     <div class="panel-footer">
                         합계 :  <?echo(number_format($charge['total_vat']));?>원
                     </div>
                 </div>
             </div>
             <div class="col-lg-2">
                 <div class="panel panel-success">
                     <div class="panel-heading">
                         총수수료액 - (PG사 수수료)
                     </div>
                     <div class="panel-body">
                         <p>1.<?echo(CHARGE1_NAME);?>(<?echo(CHARGE1_RATE);?>%) : <?echo(number_format($charge['charge1_rate']));?>원</p>
                         <p>2.<?echo(CHARGE2_NAME);?>(<?echo(CHARGE2_RATE);?>%) : <?echo(number_format($charge['charge2_rate']));?>원</p>
                         <p>3.<?echo(CHARGE3_NAME);?>(<?echo(CHARGE3_RATE);?>%) : <?echo(number_format($charge['charge3_rate']));?>원</p>
                         <p>4.<?echo(CHARGE4_NAME);?>(<?echo(CHARGE4_RATE);?>%) : <?echo(number_format($charge['charge4_rate']));?>원</p>

                     </div>
                     <div class="panel-footer">
                         합계 :  <?echo(number_format($charge['total_rate']));?>원
                     </div>
                 </div>
             </div>
             <div class="col-lg-2">
                 <div class="panel panel-success">
                     <div class="panel-heading">
                         총결정액
                     </div>
                     <div class="panel-body">
                         <p>1.<?echo(CHARGE1_NAME);?>(<?echo(CHARGE1_RATE);?>%) : <?echo(number_format($charge['charge1_dicision']));?>원</p>
                         <p>2.<?echo(CHARGE2_NAME);?>(<?echo(CHARGE2_RATE);?>%) : <?echo(number_format($charge['charge2_dicision']));?>원</p>
                         <p>3.<?echo(CHARGE3_NAME);?>(<?echo(CHARGE3_RATE);?>%) : <?echo(number_format($charge['charge3_dicision']));?>원</p>
                         <p>4.<?echo(CHARGE4_NAME);?>(<?echo(CHARGE4_RATE);?>%) : <?echo(number_format($charge['charge4_dicision']));?>원</p>

                     </div>
                     <div class="panel-footer">
                         합계 :  <?echo(number_format($charge['total_dicision']));?>원
                     </div>
                 </div>
             </div>
             <div class="col-lg-2">
                 <div class="panel panel-success">
                     <div class="panel-heading">
                         총정산액
                     </div>
                     <div class="panel-body">
                         <p>1.<?echo(CHARGE1_NAME);?> : <?echo(number_format($charge['charge1_share']));?>원</p>
                         <p>2.<?echo(CHARGE2_NAME);?> : <?echo(number_format($charge['charge2_share']));?>원</p>
                         <p>3.<?echo(CHARGE3_NAME);?> : <?echo(number_format($charge['charge3_share']));?>원</p>
                         <p>4.<?echo(CHARGE4_NAME);?> : <?echo(number_format($charge['charge4_share']));?>원</p>

                     </div>
                     <div class="panel-footer">
                         합계 :  <?echo(number_format($charge['total_share']));?>원
                     </div>
                 </div>
             </div>
        </div>
    </div>
     <?}?>
</div>
