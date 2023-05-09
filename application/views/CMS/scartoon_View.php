<script>
    $(function(){
        var imgFormat = function(cellValue, options, rowObject) {
            if(cellValue!='') {
                return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/cartoon_list/" + cellValue + "' />";
            }else{
                return '';
            }
        }

        var btn_Sub = function(cellValue, options, rowObject) {
            return "<a href='javascript:View_Sub(" + cellValue + ");'>회차 관리</a>";
        }

        var btn_Sub_img = function(cellValue, options, rowObject) {
            return "<a href='javascript:View_Sub_img(" + cellValue + ");'>이미지 관리</a>";
        }

        var btn_notice = function(cellValue, options, rowObject) {
            return "<a href='javascript:View_Notice(" + cellValue + ");'>공지 관리</a>";
        }
        var btn_quiz = function(cellValue, options, rowObject) {
            return "<a href='javascript:View_Quiz(" + cellValue + ");'>퀴즈 관리</a>";
        }

        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");

            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_main_img/',
                    secureuri: false,
                    fileElementId:'imgname',
                    dataType: 'json',
                    iframe: true,
                    data : {code : returnData.code,key:'imgname'},
                    success: function(data, status) {
                        if (data.result == true) {
                            //$('#list').trigger("reloadGrid");
                        }else if (data.result == false) {
                            //alert(data.message);
                            //$('#list').trigger("reloadGrid");
                            return [data.result, data.message];
                        }
                    },
                    error: function(data, status, e) {
                        //alert(e);
                        $('#list').trigger("reloadGrid");
                    }
                });

                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_main_img2/',
                    secureuri: false,
                    fileElementId:'imgname2',
                    dataType: 'json',
                    iframe: true,
                    data : {code : returnData.code,key:'imgname2'},
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
                url: '<?echo(ROOT_URL);?>SCartoon/Data_Load',
                editurl: '<?echo(ROOT_URL);?>SCartoon/Data_Update',
                datatype: "json",
                postData : {typ : '<?echo($typ);?>',tstr:'<?echo($tstr);?>',wid:'<?echo($wid);?>'},
                loadonce: false,
                colNames:['code','PC썸네일','M썸네일','제목','소제목','category','연재간격','연재요일','작가','감수자','PC썸네일','M썸네일','코인','할인','할인종료일','뷰방식','뷰방향','상태','활성화','무료','상세설명','등록일자','Sub','imgse'],
                height: 250,
                colModel:[
                    {name:'code',index:'code', width:100,align: 'center', sorttype: 'int', editable: false,search: false, editoptions:{readonly:true, size: 10}},
                    {name: 'image', index: 'image', align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name: 'image2', index: 'image2', align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name:'title',index:'title', width:200,align: 'center', editable: true,search: false,editrules: {required: true}},
                    {name:'sub_title',index:'title', width:200,align: 'center', sortable: false,editable: true,search: false,editrules: {required: true}},
                    {name: 'category', index: 'category', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $category?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $category?>},
                        }, formatter: 'select',search: true},
                    {name: 'cat_month', index: 'cat_month', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'1':'매주','2':'격주'}}, edittype: 'select',
                        editoptions: {
                            value: {'1':'매주','2':'격주'},
                        }, formatter: 'select',search: true},
                    {name: 'cat_week', index: 'cat_week', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'없음','1':'월요일','2':'화요일','3':'수요일','4':'목요일','5':'금요일','6':'토요일','7':'일요일'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'없음','1':'월요일','2':'화요일','3':'수요일','4':'목요일','5':'금요일','6':'토요일','7':'일요일'},
                        }, formatter: 'select',search: true},
                    {name: 'writer1', index: 'writer1', align: 'center', sortable: false, editable: true, editrules: {required: true}, search: true, stype: 'select', searchoptions: {value: {<?php echo $writer?>}}, edittype: 'select',
                        editoptions: {
                            value: {<?php echo $writer?>},
                        }, formatter: 'select',search: true},
                    {name:'Supervisor',index:'Supervisor', align: 'center', editable: true,search: false},
                    {name: 'imgname', idex: 'imgname', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true,required: true}},
                    {name: 'imgname2', idex: 'imgname2', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true,required: true}},
                    {name:'cash',index:'cash', align: 'center', editable: true,search: false,editrules: {required: true}},
                    {name:'sale',index:'sale', align: 'center', editable: true,search: false},
                    {name:'sale_date',index:'sale_date', align: 'center', search:false, editable: true},
                    {name: 'view_type', index: 'view_type', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'웹툰용','1':'출판용'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'웹툰용','1':'출판용'},
                        }, formatter: 'select',search: true},
                    {name: 'view_dir', index: 'view_dir', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'없음','2':'정방향','1':'역방향'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'없음','2':'정방향','1':'역방향'},
                        }, formatter: 'select',search: true},
                    {name: 'isStatus', index: 'isStatus', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'없음','3':'휴재','4':'완결'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'없음','1':'신작','3':'휴재','4':'완결'},
                        }, formatter: 'select',search: true},
                    {name: 'isOpen', index: 'isOpen', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'isFree',index:'isFree', width:70,align: 'center', editable: true,search: false, formoptions: {elmsuffix: '권까지'}},
                    {name: 'explan', index: 'explan', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'textarea', editoptions: {rows: 5, cols: 50}, editrules: {edithidden: true}},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name: 'scene', index: 'scene', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_Sub},
                    {name: 't_bg', index: 't_bg', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_Sub_img}
                ],
                rowNum: 60,
                rowTotal: 10000,
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
                view: false,
                search:false,
                del:false,
                edit:false,
                add:false,
                refresh:false
            },{

            },{
                addCaption: '작품 등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>SCartoon/Data_Add',
                afterSubmit: uploadFile,
                beforeInitData: function(form) {
                    $("#list").jqGrid('setColProp', 'code', {editable:false});
                    $("#list").jqGrid('setColProp', 'image', {editable:false});
                },
                beforeShowForm: function(form) {
                }
            },{

            },{
                sopt: ['eq']
            });

            $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#list').setGridWidth(width);
            });

        });
    });

    function View_Sub(val){
        var URL = "<?echo(ROOT_URL);?>SuCartoon/View/" + val;
        location.href = URL;
    }

    function View_Sub_img(val){
        var URL = "<?echo(ROOT_URL);?>SCartoon/Image/" + val;
        location.href = URL;
    }

</script>
<script>
    $(document).ready(function() {
        $('#search').click(function () {
            if($.trim($('#typ').val()) == ''){
                alert("검색 조건을 선택 하세요.");
            }else if($.trim($('#tstr').val()) == ''){
                alert("검색어를 입력하세요.");
            }else{
                $("#fsearch").submit();
            }
        });

        $('#dataini').click(function () {
            $('#typ').val('');
            $('#tstr').val('');
            $(location).attr('href',"<?echo(ROOT_URL);?>Cartoon");
        });
    })
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
