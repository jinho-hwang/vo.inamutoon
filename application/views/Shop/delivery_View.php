<script>
    $(function(){

        $("#list").jqGrid({
            mtype:'POST',
            url: '<?echo(SHOP_ROOT_URL);?>Company/Delivery_Load',
            datatype: "json",
            loadonce: false,
            colNames:['택배코드','택배명','연락처','가격','배송확인','등록일자'],
            height: 250,
            colModel:[
                {name:'dCode',index:'dCode', align: 'center',width:40, editable: false, editrules: {required: true},search: false},
                {name:'dTitle',index:'dTitle', align: 'center',width:60, editable: true, editrules: {required: true}},
                {name:'dTel',index:'dTel', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'dPrice',index:'dPrice', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'delivery_url',index:'delivery_url', align: 'center',width:200, editable: true, editrules: {required: true},search: false},
                {name:'regidate',index:'regidate',width:80, align: 'center', search:false, editable: false, editoptions: {readonly: true}}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: 'pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'dCode',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "상품 관리",
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
            url: '<?echo(SHOP_ROOT_URL);?>Company/Delivery_Update',
            editCaption: '택배 수정',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
            beforeInitData: function(form) {}
        },{
            addCaption: '택배 등록',
            width:'400',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Company/Delivery_Add',
            beforeInitData: function(form) {}

        },{
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Company/Delivery_Del',
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
</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<script type="text/javascript">
    function ini_Data(){
        $(location).attr('href',"<?echo(SHOP_ROOT_URL);?>Company/AMember")
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">택배 관리</h1><div align="right"><input type="button" value="Reset"  onclick="javascrip:ini_Data();" /></div>
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

