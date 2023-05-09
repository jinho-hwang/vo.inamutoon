<script>
       
        $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>Cartoon/Sub_Data_Load',
            datatype: "json",
            postData : {pcode : '<?echo($pcode);?>'},
            loadonce: false,
            colNames:['회차','서브타이틀','회차썸네일','Scene','TXT'],
            height: 250,
            colModel:[
                {name:'cnum',index:'cnum', align: 'center',width:100, editable: true,search: false},
                {name:'sub_Title',index:'sub_Title', align: 'center', editable: true,search: false,sortable: false},
                {name: 'image', index: 'image', align: 'center',width:60, sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                {name: 'scene', index: 'scene', align: 'center', width:80,sortable: false, editable: false, edittype: 'text',search: false, formatter: formatOpt1},
                {name: 'scene', index: 'scene', align: 'center', width:80,sortable: false, editable: false, edittype: 'text',search: false, formatter: formatOpt2}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: 'pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'a.sn',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "작품별 회차 관리",
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
        },{
        },{
        },{
            sopt: ['eq']
        });

            $(window).bind('resize', function () {
            var width = $('.jqGrid_wrapper').width();
            $('#list').setGridWidth(width);
        });

    });


    function imgFormat(cellValue, options, rowObject) {
        if(cellValue!='') {
            return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/detail_banner/" + cellValue + "' />";
        }else{
            return '';
        }
    }

    function formatOpt1(cellvalue, options, rowObject) {
        var str = "";
        var row_id = options.rowId;
        var idx = rowObject.idx;

        str += "<div class=\"btn-group\">";
        str += "<button type='button' class='btn btn-default btn-sm'  onclick=\"javascript:free_View('" + row_id + "','" + cellvalue + "' )\">보기</button>";
        str += "</div>";

        return str;
    }

    function formatOpt2(cellvalue, options, rowObject) {
        var str = "";
        var row_id = options.rowId;
        var idx = rowObject.idx;

        str += "<div class=\"btn-group\">";
        str += "<button type='button' class='btn btn-default btn-sm'  onclick=\"javascript:free_View2('" + row_id + "','" + cellvalue + "' )\">TXT보기</button>";
        str += "</div>";

        return str;
    }

    function free_View(pcode,cnum){
        var URL = "<?echo(ROOT_URL);?>Cartoon/fView/" + pcode + "/" + cnum;

        window.open(URL);
    }

    function free_View2(pcode,cnum){
        var URL = "<?echo(ROOT_URL);?>Cartoon/fView2/" + pcode + "/" + cnum;

        window.open(URL);
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
                <h1 class="page-header">작품명:<?echo($c_name);?> > 회차 관리</h1>
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
