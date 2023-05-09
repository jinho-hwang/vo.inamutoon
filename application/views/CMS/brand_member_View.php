<script>
    $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>Brand/Data_Load3/<?echo($typ);?>/<?echo($bcode);?>',
            editurl: '<?echo(ROOT_URL);?>Brand/Data_Update/<?echo($typ);?>/<?echo($bcode);?>',
            datatype: "json",
            loadonce: false,
            colNames:['code','업체명','활성화','등록일자'],
            height: 250,
            colModel:[
                {name:'ccode',index:'ccode', align: 'center',width:'50', editable: false, search:false},
                {name: 'ccode', index: 'ccode', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $selecter?>}}, edittype: 'select',
                    editoptions: {
                        value: {<?php echo $selecter?>},
                    }, formatter: 'select',search: true},
                {name: 'isUse', index: 'isUse', width:'30',align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'미사용','1':'사용'}},formatter: 'select'},
                {name:'regidate',index:'regidate',width:'80', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
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
            caption: "관리",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });

        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            view: false,
            search:false,
            edit : false
            //viewtext: '보기',
            //edittext: '수정',
            //addtext:  '등록',
            //deltext:  '삭제',
            //searchtext: '검색',
            //refreshtext: '새로고침',
        },{
            editCaption: '정보 수정',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
        },{
            addCaption: '멤버 등록',
            width:'600',
            jqModal: true,
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            url: '<?echo(ROOT_URL);?>Brand/Data_Member_Add/<?echo($typ);?>/<?echo($bcode);?>'
        },{
            closeOnEscape: true,
            url: '<?echo(ROOT_URL);?>Brand/Data_Member_Del/<?echo($typ);?>/<?echo($bcode);?>',
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
            $(location).attr('href',"<?echo(ROOT_URL);?>/Counsel");
        });
    })
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?echo($title);?></h1>
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
