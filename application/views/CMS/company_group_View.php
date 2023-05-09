<script>
          $(function(){
            $("#list").jqGrid({
                mtype:"POST",
                url: '<?echo(ROOT_URL);?>Company/GroupLoad/<?echo($ccode);?>',
                datatype: "json",
                loadonce: false,
                colNames:['code','아이디','작가명','등록일자'],
                height: 250,
                colModel:[
                    {name:'code',index:'code', width:30,align: 'center', sorttype: 'int',editable: false, editoptions:{size: 10}},
                    {name:'email',index:'email', align: 'center', editable: false, editrules: {email: true}, search:false},
                    {name: 'writer1', index: 'writer1', align: 'center', sortable: false, editable: true, search: false, edittype: 'select',
                    editoptions: {
                        value: {<?php echo $writer?>},
                    }, formatter: 'select',search: true},
                    {name:'regidate',index:'regidate',width:'100', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: '#pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'code',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "작가 관리",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });
            
            $("#list").jqGrid('navGrid', '#pager', {
            	cloneToTop:true,
                view: false,
                search:false,
                edit:false
               //viewtext: '보기',
               //edittext: '수정',
               //addtext:  '등록',
               //deltext:  '삭제',
               //searchtext: '검색',
               //refreshtext: '새로고침',
            },{},{
                addCaption: '작가 등록',
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                width:'600',
                url: '<?echo(ROOT_URL);?>Company/GroupAdd/<?echo($ccode);?>',
                beforeShowForm: function(form) { $('#code', form).hide(); }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Company/GroupDel/<?echo($ccode);?>',
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


        function View_Sub(val){
            var url = '/Company/GroupList/' + val;
            $(location).attr('href',url);        
        };

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
             $(location).attr('href',"<?echo(ROOT_URL);?>Writer");
         });
     })
 </script>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?echo($cname);?>업체 소속작가 관리</h1>
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
