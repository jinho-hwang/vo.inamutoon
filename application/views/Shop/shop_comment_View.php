<script>
    $(function(){

        $("#list").jqGrid({
            mtype:'POST',
            url: '<?echo(WEB_URL);?>/Answer/Product_Load',
            datatype: "json",
            loadonce: false,
            colNames:['SN','상품코드','상품명','등록일자','글종류','등록일자'],
            height: 250,
            colModel:[
                {name:'sn',index:'sn', align: 'center',width:40, editable: false, editrules: {required: true},search: false},
                {name:'cTitle',index:'cTitle', align: 'center',width:60, editable: true, editrules: {required: true}},
                {name:'cName',index:'cName', align: 'center',width:60, editable: true, editrules: {required: true}},
                {name:'cTel',index:'cTel', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'cAddress',index:'cAddress', align: 'center', editable: true, editrules: {required: true},search: false},
                {name: 'delivery_com', index: 'delivery_com',width:100, align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $select_box?>}}, edittype: 'select',
                    editoptions: {
                        value: {<?php echo $select_box?>},
                    }, formatter: 'select',search: true},
                {name: 'dPrice', index: 'dPrice',width:80, align: 'right', sortable: true, sorttype: 'number', editable: false, search: false, editoptions: {size: 4}, editrules: {integer: true}, formoptions: {elmsuffix: '%'}, formatter: 'currency', formatoptions: {decimalPlaces: 0, suffix: '원'}},
                {name:'regidate',index:'regidate',width:80, align: 'center', search:false, editable: false, editoptions: {readonly: true}}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: 'pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'cCode',
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
            refresh:false,
            add : false
        },{
        },{
        },{
            closeOnEscape: true,
            url: '<?echo(WEB_URL);?>/Answer/Product_Del',
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
        $(location).attr('href',"<?echo(CMS_ROOT);?>/AMember")
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">업체관리</h1><div align="right"><input type="button" value="Reset"  onclick="javascrip:ini_Data();" /></div>
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

