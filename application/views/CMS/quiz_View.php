<script>
    $(function(){
        var btnFormat = function(cellValue, options, rowObject) {
            if(cellValue == ''){
                return '';
            }else{
                return "<a  href=\"javascript:View_Answer('" + cellValue + "');\">답관리</a>";
            }
        }

        $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>/Quiz/Data_Load/<?echo($pcode);?>',
                editurl: '<?echo(ROOT_URL);?>/Quiz/Data_Update/<?echo($pcode);?>',
                datatype: "json",
                loadonce: false,
                colNames:['번호','카툰회차','타입','오픈유무','퀴즈문제','답관리'],
                height: 250,
                colModel:[
                    {name:'qnum',index:'qnum', align: 'center',width:20, editable: false, editrules: {required: true},search: true},
                    {name: 'scode',index:'scode', align: 'center',width:20, editable: true, editrules: {required: true},search: true},
                    {name: 'aType', index: 'aType',width:50, align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'사지선다','1':'OX풀이'}},formatter: 'select'},
                    {name: 'isOpen', index: 'isOpen',width:20, align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'quiz',index:'quiz', align: 'center', editable: true, sortable: false, editrules: {required: true},search: true},
                    {name:'qnum',index:'qnum', align: 'center',width:20, editable: false, sortable: false,search: false,formatter: btnFormat}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'qnum',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "퀴즈 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });
            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                //viewtext: '보기',
                //edittext: '수정',
                //addtext:  '등록',
                //deltext:  '삭제',
                //searchtext: '검색',
                //refreshtext: '새로고침',

            },{
                editCaption: '퀴즈 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
            },{
                addCaption: '퀴즈 등록',
                width:'400',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>/Quiz/Data_Add/<?echo($pcode);?>',
                beforeShowForm: function(form) {
                }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>/Quiz/Data_Delete',
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


    function View_Answer(val){

        var url ='<?echo(ROOT_URL);?>Quiz/Answer/' + val
        window.open(url,null, "top=50,left=100,height=800,width=600,status=yes,toolbar=no,menubar=no,location=no");
    }


</script>

<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<script type="text/javascript">
    function ini_Data(){
        $(location).attr('href',"<?echo(ROOT_URL);?>/Quiz")
    }
</script>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">작품명:<?echo($c_name);?> >퀴즈 관리</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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

