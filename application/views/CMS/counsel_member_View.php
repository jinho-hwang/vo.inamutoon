<script>
    $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>CMember/Data_Load',
            editurl: '<?echo(ROOT_URL);?>CMember/Data_Update',
            datatype: "json",
            postData : {tstr:'<?echo($tstr);?>'},
            loadonce: false,
            colNames:['code','회원종류','아이디','성명','전화번호','모바일','주소','활성','임시키','등록일자'],
            height: 250,
            colModel:[
                {name:'code',index:'code', width:30,align: 'center', sorttype: 'int',editable: false, editoptions:{readonly:true, size: 10}},
                {name: 'mtyp', index: 'mtyp', width:'100',align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'자문위원','1':'EBS'}},formatter: 'select'},
                {name:'email',index:'email', align: 'center', editable: true, editrules: {email: true}, search:false},
                {name:'wname',index:'wname',width:'100', align: 'center', editable: true, editrules: {required: true}},
                {name:'tel',index:'tel', align: 'center',width:'80', editable: true, search:false},
                {name:'mobile',index:'mobile', width:'80',align: 'center', editable: true, search:false},
                {name:'address',index:'address',width:'200', align: 'center', editable: true, search:false},
                {name: 'isActive', index: 'isActive', width:'30',align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                {name:'SKey',index:'SKey',width:'80', align: 'center', editable: false, search:false},
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
            caption: "관리",
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
            editCaption: '정보 수정',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
        },{
            addCaption: '등록',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            width:'600',
            url: '<?echo(ROOT_URL);?>CMember/Data_Add',
            beforeShowForm: function(form) { $('#code', form).hide(); }
        },{
            closeOnEscape: true,
            url: '<?echo(ROOT_URL);?>CMember/Data_Delete',
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
            $(location).attr('href',"<?echo(ROOT_URL);?>CMember");
        });
    })
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">자문위원 회원 관리</h1>
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
