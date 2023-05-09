<script>


    $(function(){
        $("#list").jqGrid({
            mtype:'POST',
            url: '<?echo(ROOT_URL);?>Event/open3_Data_Load',
            datatype: "json",
            loadonce: false,
            colNames:['아이디','이름','주소','연락처','참가 일자'],
            height: 250,
            colModel:[
                {name:'userid',index:'userid', align: 'center', editable: true, editrules: {required: true},search: true},
                {name:'uname',index:'uname', align: 'center', editable: true, editrules: {required: true},search: true},
                {name:'address',index:'address', width:300, align: 'center', editable: true, editrules: {required: true},search: true},
                {name:'mobile',index:'mobile', width:300, align: 'center', editable: true, editrules: {required: true},search: true},
                {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
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
            caption: "이벤트 관리",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });


        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            view: false,
            search:false,
            refresh:false,
            del:false,
            edit:false,
            add:false
        },{},{},{},{
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
        $(location).attr('href',"<?echo(ROOT_URL);?>Event")
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">말랑말랑 무브먼트</h1><div align="right"><input type="button" value="Reset"  onclick="javascrip:ini_Data();" /></div>
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

