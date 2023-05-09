<script>
    $(function(){

        var imgFormat = function(cellValue, options, rowObject) {
            if(cellValue ==''){
                return '';
            }else{
                return "<a href=\"javascript:View_Scene('" + cellValue + "');\"><img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/banner/" + cellValue + "' /></a>";
            }
        }

        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");

            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_banner_img4/',
                    secureuri: false,
                    fileElementId:'imgname',
                    dataType: 'json',
                    iframe: true,
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

                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_banner_img5/',
                    secureuri: false,
                    fileElementId:'imgname2',
                    dataType: 'json',
                    iframe: true,
                    data : {sn : returnData.code,key:'imgname2'},
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
                url: '<?echo(ROOT_URL);?>Cartoon/AdData_Load2/<?echo($pcode);?>',
                editurl: '<?echo(ROOT_URL);?>Cartoon/AdData_Update2/<?echo($pcode);?>',
                datatype: "json",
                loadonce: false,
                colNames:['SN','이미지','이미지','title','배너위치','링크','배경','배경','오픈유무','등록일'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn', align: 'center', editable: false},
                    {name: 'image', index: 'image', align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name: 'imgname', index: 'imgname', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
                    {name:'title',index:'title', align: 'center', editable: true},
                    {name: 'location', index: 'location', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'선택','3':'PC','4':'Mobile'}},formatter: 'select'},
                    {name:'Link',index:'Link', align: 'center', editable: true},
                    {name: 'image', index: 'image', align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name: 'imgname2', index: 'imgname2', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
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
                caption: "배너등록",
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
                editCaption: '배너 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:true});
                }
            },{
                addCaption: '배너등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon/AdData_Add2/<?echo($pcode);?>',
                afterSubmit: uploadFile,
                beforeInitData:function(form){
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:false});
                },
                beforeShowForm: function(form) {
                }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon/AdData_Del2',
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
        $(location).attr('href',"<?echo(ROOT_URL);?>Cartoon")
    }
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?echo($title);?> - 광고배너관리</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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
