<script>
    $(function(){
        var imgFormat = function(cellValue, options, rowObject) {
            return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/brand/" + cellValue + "' />";
        }
        var btn_Sub1 = function(cellValue, options, rowObject) {
            return "<a href='javascript:member_View(1," + cellValue + ");'>멤버 확인</a>";
        }

        var btn_Sub2 = function(cellValue, options, rowObject) {
            return "<a href='javascript:member_View(2," + cellValue + ");'>멤버 확인</a>";
        }

        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");
            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_brand_img2/',
                    secureuri: false,
                    fileElementId:'imgname',
                    dataType: 'json',
                    data : {sn : returnData.code,key:'imgname',typ:1},
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
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_brand_img2/',
                    secureuri: false,
                    fileElementId:'imgname2',
                    dataType: 'json',
                    data : {sn : returnData.code,key:'imgname2',typ:2},
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
                url: '<?echo(ROOT_URL);?>Brand/Data_Load2',
                editurl: '<?echo(ROOT_URL);?>Brand/Data_Update',
                datatype: "json",
                loadonce: false,
                colNames:['code','브랜드명','브랜드 설명','순서','PC이미지','PC이미지','M이미지','M이미지','적용','등록일','웹툰','MD'],
                height: 250,
                colModel:[
                    {name:'bcode',index:'bcode', align: 'center',width:50, editable: false},
                    {name:'b_title',index:'b_title', align: 'center',width:100, sortable: false,editable: true},
                    {name:'b_content',index:'b_content', align: 'center',width:200, sortable: false,editable: true},
                    {name:'forder',index:'forder', align: 'center',width:50, editable:true},
                    {name: 'image', index: 'image', align: 'center',width:300,sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name: 'imgname', idex: 'imgname', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
                    {name: 'image2', index: 'image2', align: 'center',width:300,sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name: 'imgname2', idex: 'imgname2', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
                    {name: 'isUse', index: 'isUse', align: 'center',width:50, sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'regidate',index:'regidate', align: 'center',width:100, search:false, editable: false, editoptions: {readonly: true}},
                    {name: 'bcode', index: 'bcode', align: 'center', width:50,sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_Sub1},
                    {name: 'bcode', index: 'bcode', align: 'center', width:50,sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_Sub2}
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'forder',
                viewrecords: true,
                sortorder: 'asc',
                multiselect: false,
                caption: "브랜드 등록",
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
                add : false,
                edit : true
            },{
                editCaption: '브랜드 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:true});
                }
            },{
                addCaption: '브랜드 등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Brand/Data_Add/',
                afterSubmit: uploadFile,
                beforeInitData:function(form){
                    $("#list").jqGrid('setColProp', 'isOpen', {editable:false});
                },
                beforeShowForm: function(form) {
                }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Brand/Data_Del',
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

    function Reg_Data(){
        var url = '/Brand/Brand_Reg/';
        popupOpen(url,600,580,10,10);
    }

    function member_View(typ,bcode){
        if(typ==1) {
            $(location).attr('href', '/Brand/Member/1/' + bcode);
        }else{
            $(location).attr('href', '/Brand/Member/2/' + bcode);
        }
    }


    function popupOpen(popUrl,width,height,top,left){
        var popOption = "width=" + width + ", height=" + height + ",top=" + top + ",left=" + left + ", resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
        window.open(popUrl,"",popOption);
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
            <h1 class="page-header">브랜드 관리</h1><div align="right"><div align="right"><input type="button" value="등  록"  onclick="Reg_Data();" />&nbsp;&nbsp;&nbsp;<input type="button" value="초기화"  onclick="javascrip:ini_Data();" /></div>
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
