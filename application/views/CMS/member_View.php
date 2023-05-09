 <script>
         $(function(){
            var imgFormat = function(cellValue, options, rowObject) {
                return "<img class='thmb_img' src='" + cellValue + "' width='100' height='100' />";
            }

            var viewFamily = function(cellValue, options, rowObject) {

                var uid = rowObject[0];

                if(cellValue == 2) {
                    return "<a href=\"javascript:view_family('" + uid + "');\">보호자</a>";
                }else if(cellValue == 1){
                    return "피보호자";
                }else{
                    return "준회원";
                }
            }
            var uploadFile = function(response, postdata) {
                var returnData = eval("(" + response.responseText + ")");
                if (returnData.result) {
                    $.ajaxFileUpload({
                        url: '<?echo(ROOT_URL);?>Cartoon/upload_main_img/',
                        secureuri: false,
                        fileElementId:'imgname', 
                        dataType: 'json',
                        data : {code : returnData.code,key:'imgname'},
                        success: function(data, status) {
                            if (data.result == true) {
                               $('#list').trigger("reloadGrid");
                            }else if (data.result == false) {
                                alert(data.message);
                                return [data.result, data.message];
                            }
                        },
                        error: function(data, status, e) {
                            alert(e);
                        }
                    });
                  }
                $(this).jqGrid('setGridParam', {datatype:'json'});
                //$('#list').trigger("reloadGrid");
                //var result = eval("(" + response.responseText + ")");
                return [returnData.result, returnData.message];
            }      
        
        
          $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>Member/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Member/Data_Update',
                datatype: "json",
                postData : {typ : '<?echo($typ);?>',tstr:'<?echo($tstr);?>'},
                loadonce: false,
                colNames:['회원번호','썸네일','아이디','이름','종류','보유코인','인증업체','인증업체번호','본인인증','등록일자'],
                height: 250,
                colModel:[
                    {name:'uid',index:'uid', width:50,align: 'center', sorttype: 'int', editable: false, editoptions:{readonly:true, size: 10}},
                    {name:'pic', index: 'pic', width:100,align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name:'userid',index:'userid', align: 'center', editable: true, editrules: {required: true},search: true},
                    {name:'uname',index:'uname',width:50, align: 'center', editable: true, editrules: {required: true},search: true},
                    {name:'superID',index:'superID',width:50, align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'일반ID','1':'SuperID'}},formatter: 'select'},
                    {name:'cash', index:'cash',width:50, align: 'center', sortable: true, sorttype: 'number', editable: true, search: false, editoptions: {size: 4}, editrules: {integer: true}, formoptions: {elmsuffix: '원'}, formatter: 'currency', formatoptions: {decimalPlaces: 0, suffix: '원'}},
                    {name:'auth', index: 'auth',width:50, align: 'center', sortable: false, editable: false, search: false},
                    {name:'secret', index: 'secret', align: 'center', sortable: false, editable: false, search: false},
                    {name: 'isCert', index: 'isCert', width:50,align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'regidate',index:'regidate',width:80, align: 'center', search:false, editable: false, editoptions: {readonly: true}}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'uid',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "회원정보 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 800,
                emptyrecords: '자료가 없습니다.'
            });
            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                view: true,
                search:false
            },{
                editCaption: '회원정보 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true
            },{
                addCaption: '회원정보 등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Member/Data_Add',
                beforeShowForm: function(form) {$('#uid', form).hide()}    
                
             },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Member/Data_Delete',
                afterSubmit: function(response, postdata) {
                    var result = eval("(" + response.responseText + ")");
                    return [result.result, result.message];
                }
            },{
                sopt: ['eq','cn']
            });
            
             $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#list').setGridWidth(width);
            });
        });
     });

     function view_family(val){
         var popUrl = "/TMS/Member/family/" + val;
         var popOption = "width=800, height=800, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
         window.open(popUrl,"",popOption);

     }
</script>
<script>
     $(document).ready(function() {
         $('#search').click(function () {
             if($.trim($('#typ').val()) == ''){
                 alert("검색 조건을 선택 하세요.");
             }else if($.trim($('#tstr').val()) == ''){
                 alert("검색어를 입력하세요.");
             }else{
                 $("#fsearch").submit();
             }
         });

         $('#dataini').click(function () {
             $('#typ').val('');
             $('#tstr').val('');
             $(location).attr('href',"<?echo(ROOT_URL);?>Member");
         });
     })
</script>

<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">일반 멤버 관리</h1>
                <div class="form-group">
                    <table>
                        <tr>
                            <form name="fsearch" id="fsearch" method="post" action="<?echo(ROOT_URL);?>Member">
                            <td>
                                <select id="typ" name="typ" class="form-control">
                                    <option value="">선택하세요.</option>
                                <?if($typ==1){?>
                                    <option value="1" selected>아이디</option>
                                <?}else{?>
                                    <option value="1">아이디</option>
                                <?}?>

                                <?if($typ==2){?>
                                    <option value="2" selected>이름</option>
                                <?}else{?>
                                    <option value="2">이름</option>
                                <?}?>

                                <?if($typ==3){?>
                                    <option value="3" selected>인증업체</option>
                                <?}else{?>
                                    <option value="3">인증업체</option>
                                <?}?>

                                </select>
                            </td>
                            <td width="20" align="center">&nbsp;</td>
                            <td>
                                <input type="text" id="tstr" name="tstr" value="<?echo($tstr);?>" />
                            </td>
                            <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                            <td width="100" align="center"><button id="dataini" class="btn btn-default">초기화</button></td>
                            </form>
                        </tr>
                    </table>
                    <br />
                    <table border="1" width="">
                        <?foreach($auth as $d){?>
                            <td width="200" align="center"><?echo($d['auth']);?></td>
                            <td width="200" align="center"><?echo(number_format($d['Cnt']));?>명</td>
                        <?}?>
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

