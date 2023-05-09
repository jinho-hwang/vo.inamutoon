<script>
    $(function(){

        $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>Notice/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Notice/Data_Update',
                datatype: "json",
                loadonce: false,
                colNames:['sn','title','content','오픈여부','등록일자'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn',width:'20', align: 'center', editable: false, editrules: {required: true},search: true},
                    {name:'title',index:'title',width:'50', align: 'left', editable: true, editrules: {required: true},search: true},
                    {name: 'content', index: 'content', align: 'left', sortable: false, editable: true, search: false, edittype: 'textarea', editoptions: {rows: 5, cols: 50}, editrules: {edithidden: true}},
                    {name: 'isOpen', index: 'isOpen',width:'10', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'대기','1':'오픈'}},formatter: 'select'},
                    {name:'regidate',index:'regidate',width:'30', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
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
                caption: 'FAQ 관리',
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
                editCaption: '내용 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                beforeInitData: function(form) {

                }
            },{
                addCaption: '내용 등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Notice/Data_Add',
                beforeInitData: function(form) {

                }

            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Notice/Data_Delete',
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

    function View_Board(id){
        window.open('<?echo(ROOT_URL);?>Board/BList/' + id);
    }

</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<script type="text/javascript">
    function ini_Data(){
        $(location).attr('href',"<?echo(ROOT_URL);?>Notice")
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">FAQ 관리</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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

