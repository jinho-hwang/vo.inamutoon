<script>
          $(function(){

            var btn_Sub = function(cellValue, options, rowObject) {
                return "<a href='javascript:View_Sub(" + cellValue + ");'>소속작가</a>";
            }


            $("#list").jqGrid({
                mtype:"POST",
                url: '<?echo(ROOT_URL);?>Company/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Company/Data_Update',
                datatype: "json",
                postData : {tstr:'<?echo($tstr);?>'},
                loadonce: false,
                colNames:['code','아이디','업체명','전화번호','모바일','주소','활성','임시키','소속작가','등록일자'],
                height: 250,
                colModel:[
                    {name:'code',index:'code', width:30,align: 'center', sorttype: 'int',editable: false, editoptions:{readonly:true, size: 10}},
                    {name:'email',index:'email', align: 'center', editable: true, editrules: {email: true}, search:false},
                    {name:'cname',index:'cname',width:'150', align: 'center', editable: true, editrules: {required: true}},
                    {name:'tel',index:'tel', align: 'center',width:'80', editable: true, search:false},
                    {name:'mobile',index:'mobile', width:'80',align: 'center', editable: true, search:false},
                    {name:'address',index:'address',width:'200', align: 'center', editable: true, search:false},
                    {name: 'isActive', index: 'isActive', width:'30',align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'SKey',index:'SKey',width:'80', align: 'center', editable: false, search:false},
                    {name: 't_bg', index: 't_bg', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_Sub},
                    {name:'regidate',index:'regidate',width:'100', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: '#pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'code',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "작가 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });
            
            $("#list").jqGrid('navGrid', '#pager', {
            	cloneToTop:true,
                view: true,
                search:false
               //viewtext: '보기',
               //edittext: '수정',
               //addtext:  '등록',
               //deltext:  '삭제',
               //searchtext: '검색',
               //refreshtext: '새로고침',
            },{ 
                editCaption: '작가정보 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
            },{
                addCaption: '작가 등록',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                width:'600',
                url: '<?echo(ROOT_URL);?>Company/Data_Add',
                beforeShowForm: function(form) { $('#code', form).hide(); }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Company/Data_Delete',
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


        function View_Sub(val){
            var url = '/Company/GroupList/' + val;
            $(location).attr('href',url);        
        };

</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>

 <script>
     $(document).ready(function() {
         $('#search').click(function () {
             if($.trim($('#tstr').val()) == ''){
                 alert("검색어를 입력하세요.");
             }else{
                 $("#fsearch").submit();
             }
         });

         $('#dataini').click(function () {
             $('#tstr').val('');
             $(location).attr('href',"<?echo(ROOT_URL);?>Writer");
         });
     })
 </script>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">업체 관리</h1>
                <div class="form-group">
                    <table>
                        <tr>
                            <form name="fsearch" id="fsearch" method="post" action="<?echo(ROOT_URL);?>Writer">
                                <td width="100" align="center">업체아이디 : </td>
                                <td width="20" align="center">&nbsp;</td>
                                <td>
                                    <input type="text" id="tstr" name="tstr" value="<?echo($tstr);?>" />
                                </td>
                                <td width="100" align="center"><button type="button" id="search" class="btn btn-default">검 색</button></td>
                                <td width="100" align="center"><button type="button" id="dataini" class="btn btn-default">초기화</button></td>
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col-lg-12 -->
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
