<script>
    $(function(){

        var imgFormat = function(cellValue, options, rowObject) {
            return "<img class='thmb_img' width='200' height='200' src='<?echo(CONTENT_ASSETSROOT);?>/data/shop/top/" + cellValue + "' />";
        }

        var btnFormat1 = function(cellValue, options, rowObject) {
            if(cellValue == ''){
                return '';
            }else{
                return "<a href=\"javascript:Mod_Data('" + cellValue + "');\">수정</a>";
            }
        }


        $("#list").jqGrid({
            mtype:'POST',
            url: '<?echo(SHOP_ROOT_URL);?>Product/Data_Load',
            datatype: "json",
            loadonce: false,
            colNames:['sn','상품코드','썸네일','상품명','대','중','소','업체명','상품가격','할인%','포인트','추천상품','판매량','수정','판매유무','등록일자'],
            height: 250,
            colModel:[
                {name:'sn',index:'sn', align: 'center',width:40, editable: true, editrules: {required: true},search: false},
                {name:'pCode',index:'pCode', align: 'center',width:60, editable: true, editrules: {required: true}},
                {name: 'image', index: 'image', align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                {name:'pName',index:'pName', align: 'center', editable: true, editrules: {required: true}},
                {name:'a-Name',index:'a-Name', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'b-Name',index:'b-Name', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'c-Name',index:'c-Name', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'cName',index:'cName', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'price',index:'price', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'sale',index:'sale', align: 'center',width:60, editable: true, editrules: {integer: true}, formoptions: {elmsuffix: '%'}, formatter: 'currency', formatoptions: {decimalPlaces: 0, suffix: '%'},search: false},
                {name:'point',index:'point', align: 'center',width:60, editable: true, editrules: {required: true},search: false},
                {name:'recom', index: 'recom', align: 'center',width:60, sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                {name:'sellCnt',index:'sellCnt',width:60, align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                {name:'pCode',index:'pCode', align: 'center',width:60, editable: false,search: false,formatter: btnFormat1},
                {name:'isUse', index: 'isUse', align: 'center',width:60, sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'사용안함','1':'사용'}}, edittype: 'select',
                    editoptions: {
                        value: {'0':'미판매중','1':'판매중'},
                    }, formatter: 'select',search: true},
                {name:'regidate',index:'regidate',width:80, align: 'center', search:false, editable: false, editoptions: {readonly: true}}
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
            caption: "상품 관리",
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
            del : false
        },{},{},{
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Answer/Data_Delete',
            afterSubmit: function(response, postdata) {
                var result = eval("(" + response.responseText + ")");
                return [result.result, result.message];
            }
        },{
            sopt: ['cn']
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
        $(location).attr('href',"<?echo(SHOP_ROOT_URL);?>Product")
    }

    function Reg_Data(){
        popupOpen("<?echo(SHOP_ROOT_URL);?>Product/Reg_View/",100,100,880,900);
    }

    function Mod_Data(val){
        popupOpen("<?echo(SHOP_ROOT_URL);?>Product/Mod_View/" + val,100,100,880,900);
    }

    function popupOpen(popUrl,top,left,width,height){
        var popOption = "top=" + top + ",left=" + left +  ",width=" + width + ", height=" + height + ", resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
        window.open(popUrl,"",popOption);
    }
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">상품관리</h1><div align="right"><input type="button" value="상품 등록"  onclick="javascrip:Reg_Data();" />&nbsp;<input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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

