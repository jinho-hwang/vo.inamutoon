<script>
    $(function(){
        $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>Data/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Re_Cartoon/Data_Update',
                datatype: "json",
                postData : {tstr:'<?echo($tstr);?>'},
                loadonce: false,
                colNames:['일련번호','아이디','카툰명','회차','구독일자'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn', align: 'center', editable: true, editrules: {required: true},search: false},
                    {name:'userid',index:'userid', align: 'center', editable: true, editrules: {required: true},search: true},
                    {name: 'pcode', index: 'pcode', align: 'center', sortable: false, editable: true,search: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $p_Caregory?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $p_Caregory?>},
                        }, formatter: 'select'},
                    {name:'ccode',index:'ccode', align: 'center', editable: true, editrules: {required: true},search: false},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'sn',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "유저별 구독현황",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });


            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                add : false,
                edit : false,
                del : false,
                search:false,
                refresh:true
            },{
                editCaption: '예약 정보 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                beforeInitData: function(form) {
                    $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:true}});
                }
            },{
                addCaption: '예약정보 등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Re_Cartoon/Data_Add',
                beforeInitData: function(form) {
                }

            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Re_Cartoon/Data_Delete',
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
                alert("아이디를 입력하세요.");
            }else{
                $("#fsearch").submit();
            }
        });
    })
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">유저별 구독현황</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <form name="fsearch" id="fsearch" method="post" action="<?echo(ROOT_URL);?>Data/User">
                            <td>아이디</td>
                            <td width="20" align="center">&nbsp;</td>
                            <td>
                                <input type="text" id="tstr" name="tstr" value="<?echo($tstr);?>" />
                            </td>
                            <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                            <td width="100" align="center"><button id="dataini" class="btn btn-default">초기화</button></td>
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

