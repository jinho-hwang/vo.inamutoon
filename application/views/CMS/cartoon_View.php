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

            var btn_week = function(cellValue, options, rowObject) {
                return "<a href='javascript:View_Week(" + cellValue + ");'>요일 관리</a>";
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
            var btn_ad = function(cellValue, options, rowObject) {
                return "<a href='javascript:View_Ad(" + cellValue + ");'>광고 관리</a>";
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
                url: '<?echo(ROOT_URL);?>Cartoon/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Cartoon/Data_Update',
                datatype: "json",
                postData : {typ : '<?echo($typ);?>',tstr:'<?echo($tstr);?>'},
                loadonce: false,
                colNames:['code','PC썸네일','M썸네일','제목','소제목','category','연재간격','작가','감수자','PC썸네일','M썸네일','수익쉐어','코인','대여','할인','뷰방식','뷰방향','상태','타입','서브타입','홈/연재/랭킹','좋아요','활성화','보안','무료','이달추천','추천작','추천고정','클릭수','상세설명','등록일자','연재관리','Sub','imgse','한줄공지','퀴즈관리','광고'],
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
                    {name: 'writer1', index: 'writer1', align: 'center', sortable: false, editable: true, editrules: {required: true}, search: true, stype: 'select', searchoptions: {value: {<?php echo $writer?>}}, edittype: 'select',
                    editoptions: {
                        value: {<?php echo $writer?>},
                    }, formatter: 'select',search: true},
                    {name:'Supervisor',index:'Supervisor', align: 'center', editable: true,search: false},
                    {name: 'imgname', idex: 'imgname', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true,required: true}},
                    {name: 'imgname2', idex: 'imgname2', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true,required: true}},
                    {name: 'cartoon_fee', index: 'cartoon_fee', align: 'right', sortable: true, sorttype: 'number', editable: true, search: false, editoptions: {size: 4}, editrules: {integer: true}, formoptions: {elmsuffix: '%'}, formatter: 'currency', formatoptions: {decimalPlaces: 0, suffix: '%'}},
                    {name:'cash',index:'cash', align: 'center', editable: true,search: false,editrules: {required: true}},
                    {name:'p_cash',index:'p_cash', align: 'center', editable: true,search: false,editrules: {required: true}},
                    {name: 'isSale', index: 'isSale', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'No','1':'yes'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'No','1':'Yes'},
                        }, formatter: 'select',search: true},
                    {name: 'view_type', index: 'view_type', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'웹툰용','1':'출판용'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'웹툰용','1':'출판용'},
                        }, formatter: 'select',search: true},
                    {name: 'view_dir', index: 'view_dir', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'없음','2':'정방향','1':'역방향'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'없음','2':'정방향','1':'역방향'},
                        }, formatter: 'select',search: true},
                    {name: 'isStatus', index: 'isStatus', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'없음','1':'신작','3':'휴재','4':'완결'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'없음','1':'신작','3':'휴재','4':'완결'},
                        }, formatter: 'select',search: true},
                    {name: 'cartoon_typ1', index: 'cartoon_typ1', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'1':'일반웹툰','2':'독립운동가','3':'공모전','4':'10화발굴단','5':'단편발굴단','6':'콘티발굴단','7':'영재발굴단','9':'K컨텐츠','10':'국제웹툰페어'}}, edittype: 'select',
                        editoptions: {
                            value: {'1':'일반웹툰','2':'독립운동가','3':'공모전','4':'10화발굴단','5':'단편발굴단','6':'콘티발굴단','7':'영재발굴단','9':'K컨텐츠','10':'국제웹툰페어'},
                        }, formatter: 'select',search: true},
                    {name: 'cartoon_typ2', index: 'cartoon_typ2', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'All','1':'독립웹툰 - 일반','2':'독립웹툰 - 어린이','3':'고양공모전 - 신인','4':'고양공모전 - 일반','5':'영재발굴전'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'All','1':'독립웹툰 - 일반','2':'독립웹툰 - 어린이','3':'고양공모전 - 신인','4':'고양공모전 - 일반','5':'영재발굴전'},
                        }, formatter: 'select',search: true},
                    {name: 'isNotList', index: 'isNotList', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'없음','3':'휴재','4':'완결'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'포함','1':'제외'},
                        }, formatter: 'select',search: true},
                    {name: 'isLike', index: 'isLike', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'없음','1':'무제한','2':'제한'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'없음','1':'무제한','2':'제한'},
                        }, formatter: 'select',search: true},
                    {name: 'isOpen', index: 'isOpen', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'isPwd', index: 'isPwd', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'isFree',index:'isFree', width:70,align: 'center', editable: true,search: false, formoptions: {elmsuffix: '권까지'}},
                    {name: 'isMonth', index: 'isMonth', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'isRecom', index: 'isRecom', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name: 'recom_fix', index: 'recom_fix', align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'No','1':'Yes'}},formatter: 'select'},
                    {name:'hit',index:'hit', align: 'center', editable: true, search: false},
                    {name: 'explan', index: 'explan', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'textarea', editoptions: {rows: 5, cols: 50}, editrules: {edithidden: true}},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name: 'cat_week', index: 'cat_week', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_week},
                    {name: 'scene', index: 'scene', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_Sub},
                    {name: 't_bg', index: 't_bg', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_Sub_img},
                    {name: 't_notice', index: 't_notice', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_notice},
                    {name: 't_quiz', index: 't_quiz', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_quiz},
                    {name: 't_ad', index: 't_ad', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btn_ad}
                ],
                rowNum: 20,
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
                view: true,
                search:false
            },{
                editCaption: '작품 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {
                    var cm = $('#list').jqGrid('getColProp', 'image'),
                    selRowId = $('#list').jqGrid('getGridParam', 'selrow');
                    selRowData = $('#list').jqGrid('getRowData', selRowId);
                    cm.editoptions.src = '<?echo(CONTENT_ASSETSROOT);?>/data/cartoon_list/' + selRowData.imgname;
                    $("#list").jqGrid('setColProp', 'code', {editable:true});
                    $("#list").jqGrid('setColProp', 'image', {editable:true});
                }
            },{
                addCaption: '작품 등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon/Data_Add',
                afterSubmit: uploadFile,
                beforeInitData: function(form) { 
                    $("#list").jqGrid('setColProp', 'code', {editable:false});
                    $("#list").jqGrid('setColProp', 'image', {editable:false});
                },    
                beforeShowForm: function(form) { 
                }    
             },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon/Data_Delete',
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

    function View_Sub(val){
        var URL = "<?echo(ROOT_URL);?>Sub_Cartoon/View/" + val;
        location.href = URL;
    }

    function View_Sub_img(val){
        var URL = "<?echo(ROOT_URL);?>Cartoon/Image/" + val;
        location.href = URL;
    }

    function View_Notice(val){
        var URL = "<?echo(ROOT_URL);?>Cartoon/Notice/" + val;
        location.href = URL;
    }

    function View_Week(val){
        var URL = "<?echo(ROOT_URL);?>Cartoon/Week/" + val;
        location.href = URL;
    }

    function View_Quiz(val){
        var URL = "<?echo(ROOT_URL);?>Quiz/QuizList/" + val;
        location.href = URL;
    }

    function View_Ad(val){
        var URL = "<?echo(ROOT_URL);?>Cartoon/Ca_Advert/" + val;
        location.href = URL;
    }

    function File_Delete(){
        if(window.confirm("작품 임시폴더 파일을 삭제하시겠습니까?")== true){
            if(window.confirm("정말 삭제 하시겠습니까?")== true) {
                var URL = "<?echo(ROOT_URL);?>Main/FileDel3/";
                popupOpen(URL, 100, 100, 100, 100);
            }
        }
    }

    function popupOpen(popUrl,width,height,top,left){
        var popOption = "width=" + width + ", height=" + height + ",top=" + top + ",left=" + left + ", resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
        window.open(popUrl,"",popOption);
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
                <h1 class="page-header">작품 관리</h1><div align="right"><input type="button" value="임시폴더정리"  onclick="javascrip:File_Delete();" /></div>
                <div class="form-group">
                    <table>
                        <tr>
                            <form name="fsearch" id="fsearch" method="post" action="<?echo(ROOT_URL);?>/Cartoon">
                                <td>
                                    <select id="typ" name="typ" class="form-control">
                                        <option value="">선택하세요.</option>
                                        <?if($typ==1){?>
                                            <option value="1" selected>제목</option>
                                        <?}else{?>
                                            <option value="1">제목</option>
                                        <?}?>

                                        <?if($typ==2){?>
                                            <option value="2" selected>작가</option>
                                        <?}else{?>
                                            <option value="2">작가</option>
                                        <?}?>
                                    </select>
                                </td>
                                <td width="20" align="center">&nbsp;</td>
                                <td>
                                    <input type="text" id="tstr" name="tstr" value="<?echo($tstr);?>" />
                                </td>
                                <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>
                                <td width="100" align="center"><button id="dataini" class="btn btn-default">초기화</button></td>
                            </form>
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
