<script>
    $(function(){
        var btnFormat = function(cellValue, options, rowObject) {
            return "<a href=\"javascript:View_Board('" + cellValue + "');\">게시판보기</a>";
        };

        $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>Board/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Board/Data_Update',
                datatype: "json",
                loadonce: false,
                colNames:['Code','게시판이름','게시판타입','쓰기등급','읽기등급','Page수','View수','등록일자','확인'],
                height: 250,
                colModel:[
                    {name:'bid',index:'bid',width:'50', align: 'center', editable: false, editrules: {required: true},search: true},
                    {name:'bname',index:'bname', align: 'center', editable: true, editrules: {required: true},search: true},
                    {name: 'bType', index: 'bType',width:'80', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'글','1':'이미지'}},formatter: 'select'},
                    {name: 'w_grade', index: 'w_grade',width:'80', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $grade?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $grade?>},
                        }, formatter: 'select',search: false},
                    {name: 'r_grade', index: 'r_grade',width:'80', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $grade?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $grade?>},
                        }, formatter: 'select',search: false},
                    {name:'p_cnt',index:'p_cnt',width:'50', align: 'center', editable: true, editrules: {required: true},search: true},
                    {name:'v_cnt',index:'v_cnt',width:'50', align: 'center', editable: true, editrules: {required: true},search: true},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name:'fname',index:'fname', align: 'center', editable: false,search: false,formatter: btnFormat}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'bid',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "회원정보 관리",
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
                editCaption: '게시판환경수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                beforeInitData: function(form) {

                }
            },{
                addCaption: '게시판환경등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Board/Data_Add',
                beforeInitData: function(form) {

                }

            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Board/Data_Delete',
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
        $(location).attr('href',"<?echo(ROOT_URL);?>Board/Env")
    }
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">게시판 관리</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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

