 <script>
        $(function(){
            var btnFormat = function(cellValue, options, rowObject) {
                return "<a href=\"javascript:View_Scene('" + cellValue + "');\">파일보기</a>";
            }
                
            var uploadFile = function(response, postdata) {
                var returnData = eval("(" + response.responseText + ")");
                if (returnData.result) {
                    $.ajaxFileUpload({
                        url: '<?echo(CONTENT_ROOT);?>/Shop/upload_Shop_banner_img/',
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
                url: '<?echo(SHOP_ROOT_URL);?>Banner/Data_Load',
                editurl: '<?echo(SHOP_ROOT_URL);?>Banner/Data_Update',
                datatype: "json",
                loadonce: false,
                colNames:['SN','이미지','설명','배너위치','링크','배경색','노출순서','오픈유무','이미지','등록일'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn', align: 'center', editable: false},

                    {name: 'imgname', index: 'imgname', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
                    {name:'Described',index:'Described', align: 'center', editable: true},
                    {name: 'mtype', index: 'mtype', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'선택','1':'메인','2':'모바일메인','3':'모바일서브상당'}},formatter: 'select'},
                    {name:'URL',index:'URL', align: 'center', editable: true},
                    {name:'bgcolor',index:'bgcolor', align: 'center', editable: true,editrules: {required: true}},
                    {name:'isNum',index:'isNum', align: 'center', editable: true,search: false,sortable: true},
                    {name: 'isOpen', index: 'isOpen', align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'img_name',index:'img_name', align: 'center', editable: false,search: false,formatter: btnFormat},
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
                url: '<?echo(SHOP_ROOT_URL);?>Banner/Data_Add',
                afterSubmit: uploadFile,
                beforeInitData:function(form){
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:false});
                },
                beforeShowForm: function(form) { 
                }    
             },{
                closeOnEscape: true,
                url: '<?echo(SHOP_ROOT_URL);?>Banner/Data_Del',
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
        window.open('<?echo(CONTENT_ASSETSROOT);?>/data/shop/banner/main/' +val);
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
                <h1 class="page-header">쇼핑몰 메인 광고 배너</h1><div align="right"><input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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
