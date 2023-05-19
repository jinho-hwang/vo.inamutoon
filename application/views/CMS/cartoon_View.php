 <script>
    $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>Cartoon/Data_Load',
            editurl: '<?echo(ROOT_URL);?>Cartoon/Data_Update',
            datatype: "json",
            postData : {typ : '<?echo($typ);?>',tstr:'<?echo($tstr);?>'},
            loadonce: false,
            colNames:['code','썸네일','제목','회차'],
            height: 250,
            colModel:[
                {name:'code',index:'code', width:100,align: 'center', sorttype: 'int', editable: false,search: false, editoptions:{readonly:true, size: 10}},
                {name: 'image', index: 'image',width:60, align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                {name:'title',index:'title', width:500,align: 'center', editable: true,search: false,editrules: {required: true}},
                {name: 'scene', index: 'scene', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: formatOpt1}
            ],
            rowNum: 60,
            rowList: [20, 40, 60],
            pager: 'pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'a.code',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "작품 관리",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });
        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            add : false,
            edit : false,
            del : false,
            view: false,
            search:false
        },{},{},{}
            ,{});
        
            $(window).bind('resize', function () {
            var width = $('.jqGrid_wrapper').width();
            $('#list').setGridWidth(width);
        });
        
    });

    function imgFormat(cellValue, options, rowObject) {
        if(cellValue!='') {
            return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/cartoon_list/" + cellValue + "' />";
        }else{
            return '';
        }
    }

    function formatOpt1(cellvalue, options, rowObject) {
        var str = "";
        var row_id = options.rowId;
        var idx = rowObject.idx;

        str += "<div class=\"btn-group\">";
        str += "<button type='button' class='btn btn-default btn-sm'  onclick=\"javascript:View_Sub('" + cellvalue + "' )\">회차관리</button>";
        str += "</div>";

        return str;
    }

    function View_Sub(val){
        var URL = "<?echo(ROOT_URL);?>Cartoon/View/" + val;
        location.href = URL;
    }


</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">작품 관리</h1>
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
