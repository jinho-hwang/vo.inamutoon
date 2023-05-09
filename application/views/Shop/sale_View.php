 <script>
         $(function(){

             var btnFormat = function(cellValue, options, rowObject) {
                 return "<a href=\"javascript:View_Product('" + cellValue + "');\">주문내역보기</a>";
             }

            $("#list").jqGrid({
                mtype:"POST",
                url: '<?echo(ROOT_URL);?>Shop/DashBoard/Data_Load/<?echo($year);?>/<?echo($month);?>/<?echo($stype);?>',
                datatype: "json",
                loadonce: false,
                colNames:['sn','주문번호','아이디','상품가격','배송비','쿠폰할인액','충전사용액','결제방법','일자','내역보기'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn', width:20, align: 'center', editable: false},
                	{name:'oCode',index:'oCode', width:100, align: 'center', editable: false},
                    {name:'userid',index:'userid', width:100,align: 'center', editable: false},
                    {name:'totalprice',index:'totalprice', width:100,align: 'center', editable: false},
                    {name:'totaldelivery',index:'totaldelivery', width:100,align: 'center', editable: false},
                    {name:'totalsale',index:'totalsale', width:100,align: 'center', editable: false},
                    {name:'totalpoint',index:'totalpoint', width:100,align: 'center', editable: false},
                    {name: 'payType', index: 'payType', width:60,align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'신용카드'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'신용카드'},
                        }, formatter: 'select'},
                    {name:'regidate',index:'regidate', width:100,align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name:'oCode',index:'oCode', align: 'center',width:100, editable: false,search: false,formatter: btnFormat}
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
                height: 500,
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
                url: '<?echo(ROOT_URL);?>Shop/DashBoard/Data_Delete',
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
				location.href = '<?echo(ROOT_URL);?>Shop/DashBoard/DataList/' + $('#year').val() + '/' + $('#month').val();
			});

            $('#excel').click(function(){
                location.href = '<?echo(ROOT_URL);?>Shop/DashBoard/dnMonthExcel/' + $('#year').val() + '/' + $('#month').val();
            });
        });

         function View_Product(val){
             var url = '/Shop/Order/Product/' +val;
             var width=1200;
             var height=700;

             Popup(url,width,height);
         }


         function Popup(url,width,height){
             window.open(url,"_blank","top=0,left=0,width="+width+",height="+height+",toolbar=0,status=0,scrollbars=1,resizable=0");
         }
    
</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?echo($year);?>년<?echo($month);?>월 MD샵 결제내역</h1>
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
