<script>
    $(function(){
        $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>Cartoon_Tendency/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Cartoon_Tendency/Data_Update',
                datatype: "json",
                postData : {tstr:'<?echo($tstr);?>'},
                loadonce: false,
                colNames:['작품명','감성','액션', '일상', '스포츠', '판타지', '학습', 'SF'],
                height: 250,
                colModel:[
                    {name: 'pcode', index: 'pcode', align: 'center', sortable: false, editable: true,sortable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $p_Caregory?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $p_Caregory?>},
                        }, formatter: 'select'},
                    {name: 'TField1', index: 'TField1', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'TField2', index: 'TField2', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'TField3', index: 'TField3', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'TField4', index: 'TField4', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'TField5', index: 'TField5', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'TField6', index: 'TField6', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'TField7', index: 'TField7', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'}

                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'title',
                viewrecords: true,
                sortorder: 'asc',
                multiselect: false,
                caption: "성향 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });


            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                view: true,
                search:false,
                refresh:true
            },{
                editCaption: '성향 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                beforeInitData: function(form) {
                    $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:true}});
                }
            },{
                addCaption: '성향 등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon_Tendency/Data_Add',
                beforeInitData: function(form) {
                }

            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon_Tendency/Data_Delete',
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
            <h1 class="page-header">작품 성향 관리</h1>
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

