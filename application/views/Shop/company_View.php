<script>
    $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(SHOP_ROOT_URL);?>Company/Data_Load',
            editurl: '<?echo(SHOP_ROOT_URL);?>Company/Data_Update',
            datatype: "json",
            postData : {tstr:'<?echo($tstr);?>'},
            loadonce: false,
            colNames:['업체코드','업체명','담당자명','전화번호','주소','택배명','사용유무','등록일자'],
            height: 250,
            colModel:[
                {name:'cCode',index:'cCode', width:30,align: 'center', sorttype: 'int',editable: false, editoptions:{readonly:true, size: 10}},
                {name:'cTitle',index:'cTitle', align: 'center', editable: true,  search:false},
                {name:'cName',index:'cName',width:'150', align: 'center', editable: true, editrules: {required: true}},
                {name:'cTel',index:'cTel', align: 'center',width:'80', editable: true, search:false},
                {name:'cAddress',index:'cAddress', width:'80',align: 'center', editable: true, search:false},
                {name: 'delivery_com', index: 'delivery_com', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $delivery?>}}, edittype: 'select',
                    editoptions: {
                        value: {<?php echo $delivery?>},
                    }, formatter: 'select',search: true},
                {name: 'isUse', index: 'isUse', width:'30',align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                {name:'regidate',index:'regidate',width:'100', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: '#pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'cCode',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "업체 관리",
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
            editCaption: '업체정보 수정',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
        },{
            addCaption: '업체 등록',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            width:'600',
            url: '<?echo(SHOP_ROOT_URL);?>Company/Data_Add',
            beforeShowForm: function(form) {  }
        },{
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Company/Data_Delete',
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
            $(location).attr('href',"<?echo(SHOP_ROOT_URL);?>Company");
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
                        <form name="fsearch" id="fsearch" method="post" action="<?echo(SHOP_ROOT_URL);?>Company">
                            <td width="100" align="center">업체명 : </td>
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
