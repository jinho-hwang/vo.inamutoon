 <script>
         $(function(){
            $("#list").jqGrid({
                mtype:"POST",
                url: '<?echo(ROOT_URL);?>DashBoard/Data_Load/<?echo($year);?>/<?echo($month);?>/<?echo($stype);?>',
                datatype: "json",
                loadonce: false,
                colNames:['sn','아이디','타이틀','작가명','충전방법','cash','수수료','free','log','일자'],
                height: 250,
                colModel:[
                    {name:'sn', width:20,index:'sn', align: 'center', editable: false},
                	{name:'userid', width:100,index:'userid', align: 'center', editable: false},
                    {name:'title',index:'title', width:100,align: 'center', editable: false},
                    {name:'wname',index:'wname',width:100, align: 'center', editable: false},
                    {name: 'payType', index: 'payType', width:60,align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'<?echo(CHARGE0_NAME);?>','1':'<?echo(CHARGE1_NAME);?>','2':'<?echo(CHARGE2_NAME);?>','3':'<?echo(CHARGE3_NAME);?>','4':'<?echo(CHARGE4_NAME);?>'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'<?echo(CHARGE0_NAME);?>','1':'<?echo(CHARGE1_NAME);?>','2':'<?echo(CHARGE2_NAME);?>','3':'<?echo(CHARGE3_NAME);?>','4':'<?echo(CHARGE4_NAME);?>'},
                        }, formatter: 'select'},
                    {name:'cash',index:'cash', width:30, align: 'center', editable: false},
                    {name:'rate',index:'rate', width:30, align: 'center', editable: false},
                    {name:'free',index:'free', width:30, align: 'center', editable: false},
                    {name:'log',index:'log', align: 'center', editable: false},
                    {name:'regidate',index:'regidate', width:100,align: 'center', search:false, editable: false, editoptions: {readonly: true}}
                ],
                rowNum: 40,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'sn',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "판매리스트",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });
            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                add:false,
                edit:false,
                view: false,
                search:false,
                refresh:false,
                del:false,
                excel:true
            },{},{},{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>DashBoard/Data_Delete',
                afterSubmit: function(response, postdata) {
                    var result = eval("(" + response.responseText + ")");
                    return [result.result, result.message];
                }
            },{
                sopt: ['eq']
            });

             $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#list').setGridWidth(width);
            });
        });
        
        $(document).ready(function(){
			$('#search').click(function(){
				location.href = '<?echo(ROOT_URL);?>DashBoard/DataList/' + $('#year').val() + '/' + $('#month').val() + '/' + $('#stype').val();
			});

            $('#excel').click(function(){
                location.href = '<?echo(ROOT_URL);?>DashBoard/dnMonthExcel/' + $('#year').val() + '/' + $('#month').val() + '/' + $('#stype').val();
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
                <h1 class="page-header"><?echo($year);?>년<?echo($month);?>월 결제내역</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
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
                        <td width="20" align="center">/</td>
                        <td>
                        <select id="stype"  class="form-control">
                        <?if($stype==1){?>
                            <option selected value="1">All</option>
                            <option value="2">Cash</option>
                            <option value="3">Free</option>
                        <?}else if($stype==2){?>
                            <option value="1">All</option>
                            <option selected value="2">Cash</option>
                            <option value="3">Free</option>
                        <?}else if($stype==3){?>
                            <option value="1">All</option>
                            <option value="2">Cash</option>
                            <option selected value="3">Free</option>
                        <?}?>
                        </select>
		                </td>
		                <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                        <td width="100" align="center"><button id="excel" class="btn btn-default">엑셀추출</button></td>
                	</tr>
				</table>
            </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" style="min-width:600px">
                    <div class="jqGrid_wrapper">
                        <table id='list'></table> 
                        <div id="pager"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
