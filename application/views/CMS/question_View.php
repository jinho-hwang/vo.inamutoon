 <script>
         $(function(){
            var btnFormat = function(cellValue, options, rowObject) {
                if(cellValue == ''){
                    return '';
                }else{
                    return "<a href=\"javascript:View_Image('" + cellValue + "');\">파일보기</a>";
                }
            }
            
            var btnReply = function(cellValue, options, rowObject) {
                 return "<a href=\"javascript:View_Reply('" + cellValue + "');\">답변등록</a>";
            }
            
        
          $(function(){
            $("#list").jqGrid({
                mtype:'POST',
                url: '<?echo(ROOT_URL);?>Answer/Data_Load',
                datatype: "json",
                loadonce: false,
                colNames:['회원번호','아이디','문의타입','첨부파일','답변유무','제목','내용','등록일자','답변'],
                height: 250,
                colModel:[
                    {name:'uid',index:'uid', align: 'center',width:40, editable: true, editrules: {required: true},search: false},
                    {name:'userid',index:'userid', align: 'center',width:100, editable: true, editrules: {required: true},search: false},
                    {name: 'typ', index: 'typ', align: 'center', sortable: false,width:100, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'1':'결제관련','2':'이용오류','3':'작품연재','4':'제휴관련','5':'기타문의','6':'연재문의','7':'광고문의','8':'제작문의','9':'유료등록문의'}}, edittype: 'select',
                        editoptions: {
                            value: {'1':'결제관련','2':'이용오류','3':'작품연재','4':'제휴관련','5':'기타문의','6':'연재문의','7':'광고문의','8':'제작문의','9':'유료등록문의'},
                        }, formatter: 'select'},
                    {name:'fname',index:'fname', align: 'center',width:50, editable: false,search: false,formatter: btnFormat},
                    {name: 'isAnswer', index: 'isAnswer', align: 'center',width:50, sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'title',index:'title', align: 'center', editable: true, editrules: {required: true},search: true},
                    {name:'content',index:'content', align: 'center', editable: true, editrules: {required: true},search: true},
                    {name:'regidate',index:'regidate',width:80, align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name:'reply',index:'reply', align: 'center',width:50, editable: false,search: false,formatter: btnReply}
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
                caption: "문의사항 관리",
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
                view: false,
                edit : false,
                add : false,
                search : true,
                del : true
            },{},{},{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Answer/Data_Delete',
                afterSubmit: function(response, postdata) {
                    var result = eval("(" + response.responseText + ")");
                    return [result.result, result.message];
                }
            },{
                sopt: ['eq','cn']
            });
            
             $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#list').setGridWidth(width);
            });
        });
     });
     
     function View_Image(val){
        window.open('<?echo(CONTENT_ROOT);?>/assets/data/board/' +val);
    }
    
    function View_Reply(val){

        var url ='<?echo(ROOT_URL);?>Answer/Reply/' + val
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
         $(location).attr('href',"<?echo(ROOT_URL);?>Answer")
     }
 </script>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">문의사항 관리</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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

