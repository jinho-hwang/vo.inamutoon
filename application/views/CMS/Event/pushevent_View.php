<script>
    $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>Event/PushEvent_Load',
            editurl: '<?echo(ROOT_URL);?>Event/PushEvent_Update',
            datatype: "json",
            loadonce: false,
            colNames:['sn','제목','지급캐시액','시작시간','종료시간','수령기간','오픈','등록일자','받은인원수'],
            height: 250,
            colModel:[
                {name:'sn', width:20,index:'sn', align: 'center', editable: false},
                {name:'title', width:100,index:'userid', align: 'center', editable: true},
                {name:'cash',index:'title', width:100,align: 'center', editable: true},
                {name:'s_date',index:'s_date', width:100,align: 'center', editable: true},
                {name:'e_date',index:'e_date', width:100,align: 'center', editable: true},
                {name: 'adddate', index: 'sType', align: 'center', width:50,sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'1':'1일','2':'2일','3':'3일','4':'4일','5':'5일'}}, edittype: 'select',
                    editoptions: {
                        value: {'1':'1일','2':'2일','3':'3일','4':'4일','5':'5일'},
                    }, formatter: 'select',search: true},
                {name: 'isUse', index: 'sType', align: 'center', width:50,sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'미오픈','1':'오픈'}}, edittype: 'select',
                    editoptions: {
                        value: {'0':'미오픈','1':'오픈'},
                    }, formatter: 'select',search: true},
                {name:'regidate',index:'regidate', width:100,align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                {name:'tCnt', width:100,index:'sn', align: 'center', editable: false}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: '#pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'sn',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "푸쉬이벤트 관리",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });

        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            view: true,
            search:false
            //viewtext: '보기',
            //edittext: '수정',
            //addtext:  '등록',
            //deltext:  '삭제',
            //searchtext: '검색',
            //refreshtext: '새로고침',
        },{
            editCaption: '푸쉬이벤트 수정',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
        },{
            addCaption: '푸쉬이벤트 등록',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            width:'600',
            url: '<?echo(ROOT_URL);?>Event/PushEvent_Add',
            beforeShowForm: function(form) { $('#code', form).hide(); }
        },{
            closeOnEscape: true,
            url: '<?echo(ROOT_URL);?>Event/PushEvent_Del',
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
            <h1 class="page-header">푸쉬이벤트 관리</h1>
        </div>
        <div>
            <h1><font color="red"><strong>※시작시간,종료시간은 (2016-12-12 23:00) 폼으로 등록 하여주세요.</strong></font></h1>
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
