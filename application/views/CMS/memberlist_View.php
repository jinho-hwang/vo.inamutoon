 <?if($userid!=''){?>
 <script>
     $(function(){
         $("#list").jqGrid({
             mtype:"POST",
             url: '<?echo(ROOT_URL);?>Pay/MemberList_Data/<?echo($uid);?>/<?echo($year);?>/<?echo($month);?>',
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
 </script>
<?}?>
<script>
	$(document).ready(function(){
		$('#search').click(function(){
			if($('#userid').val()==''){
				alert('Please Input ID.');
			}else{
				$('#member').submit();
			}
		});

        $('#excel').click(function(){
            if($('#userid').val()==''){
                alert('Please Input ID.');
            }else {
                var url = '<?echo(ROOT_URL);?>Pay/dnMemberExcel/<?echo($uid);?>/' + $('#year').val() + '/' + $('#month').val();
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
            <h1 class="page-header">회원별 결제내역</h1>

                <div class="form-group">
                <table>

                    <tr>
                        <form id="member" method="post" auction="<?echo(ROOT_URL);?>Pay/MemberList">
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
                        </td>
                        <td  align="center" width="100">아이디</td>
                		<td><input id='userid' name='userid' class="form-control" value="<?echo($userid);?>"></td>
                		<td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                        </form>
                        <td width="100" align="center"><button id="excel" class="btn btn-default">엑셀추출</button></td>
                	</tr>
				</table>                    
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-chevron-circle-right fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?echo(number_format($cash));?>원</div>
                        </div>
                    </div>
                </div>
                <a id="showpop1" href="#">
                    <div class="panel-footer">
                        <span class="pull-left">회원 총 유료코인 구매액</span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
         <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-chevron-circle-right fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?echo(number_format($free));?>원</div>
                        </div>
                    </div>
                </div>
                <a id="showpop2" href="#">
                    <div class="panel-footer">
                        <span class="pull-left">회원 총 무료코인 구매액</span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
     <?if($userid!=''){?>
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
        <?}?>
</div>
