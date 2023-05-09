<script>
    $(function(){
        $("#list").jqGrid({
            mtype:'POST',
            url: '<?echo(SHOP_ROOT_URL);?>Category/AData_Load',
            datatype: "json",
            loadonce: false,
            colNames:['코드','카테고리명','사용유무','등록일자'],
            height: 250,
            colModel:[
                {name:'aCode',index:'aCode', align: 'center', editable: false, editrules: {required: true},search: true},
                {name:'cName',index:'cName', align: 'center', editable: true, editrules: {required: true},search: true},
                {name:'isUse', index: 'isUse', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'사용안함','1':'사용'}}, edittype: 'select',
                    editoptions: {
                        value: {'0':'사용안함','1':'사용'},
                    }, formatter: 'select',search: true},
                {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: 'pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'aCode',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "대카테고리 관리",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });


        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            view: false,
            search:false,
            refresh:false
        },{
            editCaption: '대카테고리 수정',
            url: '<?echo(SHOP_ROOT_URL);?>Category/AData_Update',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
            beforeInitData: function(form) {
                $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:true}});
            }
        },{
            addCaption: '대카테고리 등록',
            width:'400',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Category/AData_Add',
            beforeInitData: function(form) {
                $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:false}});
            }

        },{
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Category/AData_Delete',
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
</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<script type="text/javascript">
    function ini_Data(){
        $(location).attr('href',"<?echo(SHOP_ROOT_URL);?>/Category/AGroup")
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">대카테고리 관리</h1><div align="right"><input type="button" value="Reset"  onclick="javascrip:ini_Data();" /></div>
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

