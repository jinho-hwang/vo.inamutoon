 <script>
        
          $(function(){
            $("#list").jqGrid({
                mtype:"POST",
                url: '<?echo(ROOT_URL);?>Category/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Category/Data_Update',
                datatype: "json",
                loadonce: false,
                colNames:['카테고리코드','카테고리명','활성유무','등록일자'],
                height: 250,
                colModel:[
                    {name:'code',index:'code', align: 'center', editable: true, editrules: {required: true}},
                    {name:'cname',index:'cname', align: 'center', editable: true, editrules: {required: true}},
                    {name: 'isActive', index: 'isActive', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'code',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "카테고리 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });
            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                view: true,
                search:false,
                refresh:false
            },{
                editCaption: '카테고리 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
            },{
                addCaption: '카테고리 등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Category/Data_Add',
                beforeShowForm: function(form) { 
                }    
             },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Category/Data_Delete',
                afterSubmit: function(response, postdata) {
                    var result = eval("(" + response.responseText + ")");
                    return [result.result, result.message];
                }
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
         $(location).attr('href',"<?echo(ROOT_URL);?>Board/Env")
     }
 </script>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">카테고리 관리</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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
