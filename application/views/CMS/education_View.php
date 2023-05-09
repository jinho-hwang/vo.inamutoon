<script>
    $(function(){
        var imgFormat = function(cellValue, options, rowObject) {
            return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/brand/" + cellValue + "' />";
        }

        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");
            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_brand_img/',
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
                url: '<?echo(ROOT_URL);?>Category/EduData_Load',
                editurl: '<?echo(ROOT_URL);?>Category/EduData_Update',
                datatype: "json",
                loadonce: false,
                colNames:['SN','웹툰명','학습관메뉴','적용','등록일'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn', align: 'center',width:50, editable: false},
                    {name: 'code', index: 'code', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $toon?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $toon?>},
                        }, formatter: 'select',search: true},
                    {name: 'mtype', index: 'mtype', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'없음','1':'감성충만 문학 웹툰','2':'쉽게 풀리는 수학 웹툰','3':'알쏭달쏭 과학 웹툰','4':'과거로의 여행 역사 웹툰','5':'쏙쏙 들어오는 한자 웹툰'}},formatter: 'select'},
                    {name: 'isUse', index: 'isUse', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
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
                sortorder: 'asc',
                multiselect: false,
                caption: "학습관 등록",
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
                editCaption: '학습관 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:true});
                }
            },{
                addCaption: '학습관 등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Category/EduData_Add',
                afterSubmit: uploadFile,
                beforeInitData:function(form){
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:false});
                },
                beforeShowForm: function(form) {
                }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Category/EduData_Del',
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

    function View_Scene(val){
        window.open('<?echo(CONTENT_ASSETSROOT);?>/data/banner/' +val);
    }

</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<script type="text/javascript">
    function ini_Data(){
        $(location).attr('href',"<?echo(ROOT_URL);?>Banner")
    }
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">브랜드 관리</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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
