<script>
    $(function(){
        $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>Re_Cartoon/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Re_Cartoon/Data_Update',
                datatype: "json",
                postData : {tstr:'<?echo($tstr);?>'},
                loadonce: false,
                colNames:['카툰명','회차','적용유무','오픈일자','등록일자'],
                height: 250,
                colModel:[
                    {name: 'pcode', index: 'pcode', align: 'center', sortable: false, editable: true,search: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $p_Caregory?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $p_Caregory?>},
                        }, formatter: 'select'},
                    {name:'scode',index:'scode', align: 'center', editable: true, editrules: {required: true},search: false},
                    {name: 'isReserve', index: 'isReserve', align: 'center', sortable: false, editable: true, search: true, edittype: 'select', editoptions: {value: {'0':'미실행','1':'예약',3:'완료'}},formatter: 'select'},
                    {name:'opendate',index:'opendate', align: 'center', search:false,editable: true, editrules: {required: true}},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}}

                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'regidate',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "카툰 예약 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });


            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                view: false,
                search:false,
                refresh:true,
                add:false,
                edit:false
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
                sopt: ['cn','eq']
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
                alert("검색어를 입력하세요.");
            }else{
                $("#fsearch").submit();
            }
        });

        $('#dataini').click(function () {
            $('#tstr').val('');
            $(location).attr('href',"<?//echo(ROOT_URL);?>///Re_Cartoon");
        });

        $('#datareg').click(function () {
            var URL = "<?echo(ROOT_URL);?>Re_Cartoon/Reg_pop";
            popupOpen(URL, 650, 380, 100, 100);
        });
    })
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">웹툰 예약 관리</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <form name="fsearch" id="fsearch" method="post" action="<?echo(ROOT_URL);?>/Re_Cartoon">
                            <td width="50" align="center">카툰명 : </td>
                            <td width="20" align="center">&nbsp;</td>
                            <td>
                                <input type="text" id="tstr" name="tstr" value="<?echo($tstr);?>" />
                            </td>
                            <td width="100" align="center"><button type="button" id="search" class="btn btn-default">검 색</button></td>
                            <td width="100" align="center"><button type="button" id="dataini" class="btn btn-default">초기화</button></td>
                            <td width="100" align="center"><button type="button" id="datareg" class="btn btn-default">등 록</button></td>
                        </form>
                    </tr>
                </table>
            </div>
            <div>
                <h1><font color="red"><strong>※예약 등록시 오픈일자는 2016-12-12 폼으로 등록 하여주세요.</strong></font></h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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

