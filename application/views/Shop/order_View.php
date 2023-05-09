<script>
    $(function(){
        var btnFormat = function(cellValue, options, rowObject) {
            return "<a href=\"javascript:View_Product('" + cellValue + "');\">주문내역보기</a>";
        }

        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");
            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_banner_img/',
                    secureuri: false,
                    fileElementId:'imgname',
                    dataType: 'json',
                    data : {sn : returnData.code,key:'imgname'},
                    success: function(data, status) {
                        if (data.result == true) {
                            $('#list').trigger("reloadGrid");
                        }else if (data.result == false) {
                            //alert(data.message);
                            $('#list').trigger("reloadGrid");
                            return [data.result, data.message];
                        }
                    },
                    error: function(data, status, e) {
                        //alert(e);
                        $('#list').trigger("reloadGrid");
                    }
                });
            }
            $(this).jqGrid('setGridParam', {datatype:'json'});
            //$('#list').trigger("reloadGrid");
            //var result = eval("(" + response.responseText + ")");
            return [returnData.result, returnData.message];
        }



        $(function(){
            $("#list").jqGrid({
                mtype:"POST",
                url: '<?echo(SHOP_ROOT_URL);?>Order/Data_Load',
                datatype: "json",
                postData: {'sdate':'<?echo($sdate);?>','edate':'<?echo($edate);?>'},
                loadonce: false,
                colNames:['SN','주문코드','주문자명','총결제가격','총상품가','총택배비','총Sale가격','사용포인트','결제종류','결제상태','결제일자','구매일자','내역보기'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn', align: 'center', editable: false},
                    {name:'oCode',index:'oCode', align: 'center', editable: false},
                    {name:'oCode',index:'oCode', align: 'center', editable: false},
                    {name:'total',index:'total', align: 'center', editable: false},
                    {name:'totalprice',index:'totalprice', align: 'center', editable: false},
                    {name:'totaldelivery',index:'totaldelivery', align: 'center', editable: false},
                    {name:'totalsale',index:'totalsale', align: 'center', editable: false},
                    {name:'totalpoint',index:'totalpoint', align: 'center', editable: false},
                    {name:'payType', index: 'payType', align: 'center', sortable: false, editable: false, search: false, edittype: 'select', editoptions: {value: {'0':'신용카드','1':'휴대폰','2':'상품권'}},formatter: 'select'},
                    {name:'payComplete', index: 'payComplete', align: 'center', sortable: false, editable: false, search: false, edittype: 'select', editoptions: {value: {'0':'미결제','109':'결제완료'}},formatter: 'select'},
                    {name:'paydate',index:'paydate', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name:'oCode',index:'oCode', align: 'center', editable: false,search: false,formatter: btnFormat}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'a.sn',
                viewrecords: true,
                sortorder: 'asc',
                multiselect: false,
                caption: "배너등록",
                autowidth: true,
                shrinkToFit: true,
                height: 600,
                emptyrecords: '자료가 없습니다.'
            });
            $("#list").jqGrid('navGrid', '#pager', {
                cloneToTop:true,
                add : false,
                edit : false,
                view: true,
                search:false,
                refresh:false,
                del : false
            },{
                editCaption: '주문 수정',
                url: '<?echo(SHOP_ROOT_URL);?>Order/Data_Update',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:true});
                }
            },{
                addCaption: '회차등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Banner/Data_Add',
                afterSubmit: uploadFile,
                beforeInitData:function(form){
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:false});
                },
                beforeShowForm: function(form) {
                }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Banner/Data_Del',
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
    });

    $(document).ready(function(){
        $('#search').click(function(){

            var sdate = $("#syear option:selected").val() + '-' + $("#smonth option:selected").val()  +'-' + $("#sday option:selected").val();
            var edate = $("#eyear option:selected").val() + '-' + $("#emonth option:selected").val()  +'-' + $("#eday option:selected").val();


            $.redirect('/Shop/Order', {'sdate': sdate, 'edate': edate});
        });

        $('#ini_data').click(function(){
            $(location).attr('href',"<?echo(ROOT_URL);?>Shop/Order")
        });

    });

    function View_Product(val){
        var url = '/Shop/Order/Product/' +val;
        var width=1200;
        var height=700;

        Popup(url,width,height);
    }


    function Popup(url,width,height){
        window.open(url,"_blank","top=0,left=0,width="+width+",height="+height+",toolbar=0,status=0,scrollbars=1,resizable=0");
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
            <h1 class="page-header">주문 관리</h1><br>
            <div class="form-group">
                <table>
                    <tr>
                        <td  align="center" width="100">검색</td>
                        <td>
                            <select id="syear" class="form-control">
                                <?echo($syear);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="smonth" class="form-control">
                                <?echo($smonth);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="sday" class="form-control">
                                <?echo($sday);?>
                            </select>
                        </td>
                        <td width="10" align="center">~</td>
                        <td>
                            <select id="eyear" class="form-control">
                                <?echo($eyear);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="emonth" class="form-control">
                                <?echo($emonth);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="eday" class="form-control">
                                <?echo($eday);?>
                            </select>
                        </td>
                        <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                        <td width="100" align="center"><button id="ini_data" class="btn btn-default">초기화</button></td>
                    </tr>
                </table>
            </div>
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

