<script>
    $(function(){
        $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>AMember/Data_Load2',
                editurl: '<?echo(ROOT_URL);?>AMember/Data_Update2',
                datatype: "json",
                postData : {tstr:'<?echo($tstr);?>',wid:'<?echo($wid);?>'},
                loadonce: false,
                colNames:['당당자','작품명'],
                height: 250,
                colModel:[
                    {name:'uid',index:'uid', width:200,align: 'center', editable: false,search: false,editrules: {required: true}},
                    {name: 'code', index: 'code', align: 'center', sortable: false, editable: true,sortable: false, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $p_Caregory?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $p_Caregory?>},
                        }, formatter: 'select'}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'c.title',
                viewrecords: true,
                sortorder: 'asc',
                multiselect: false,
                caption: "할당 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });


            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                view: true,
                edit:false,
                search:false,
                refresh:true
            },{
                editCaption: '할당 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                beforeInitData: function(form) {
                    $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:true}});
                }
            },{
                addCaption: '할당 등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>AMember/Data_Add2/<?echo($wid);?>',
                beforeInitData: function(form) {
                }

            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>AMember/Data_Delete2',
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

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">작품할당</h1>
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

