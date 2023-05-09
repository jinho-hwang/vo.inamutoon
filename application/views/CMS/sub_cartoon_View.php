<script>
        $(function(){
            var imgFormat = function(cellValue, options, rowObject) {
                return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/detail_banner/" + cellValue + "' />";
            }

            var btnFormat = function(cellValue, options, rowObject) {
                var str = cellValue.split('||');
                return "<a href='javascript:View_Scene(" + str[0] + "," + str[1] + ");'>Secne등록</a>";
            }

            var btnFormat2 = function(cellValue, options, rowObject) {
                var str = cellValue.split('||');
                return "<a href='javascript:booking_View(" + str[0] + "," + str[1] + ");'>예약하기</a>";
            }


            var uploadFile = function(response, postdata) {
                var returnData = eval("(" + response.responseText + ")");
                if (returnData.result) {
                    $.ajaxFileUpload({
                        url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_Sub_img/',
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
                            $('#list').trigger("reloadGrid");
                            //alert(e);
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
                url: '<?echo(ROOT_URL);?>Sub_Cartoon/Data_Load',
                editurl: '<?echo(ROOT_URL);?>Sub_Cartoon/Data_Update/<?echo($ccode);?>',
                datatype: "json",
                postData : {pcode : '<?echo($ccode);?>'},
                loadonce: false,
                colNames:['sn','회차','서브타이틀','회차썸네일','image','무로그인','감수자','별점','소장가격','소장할인','대여가격','대여할인','타입','활성','등록일자','연재일자','씬등록'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn', align: 'center', editable: false,search: false,sortable: false,hidden: true},
                    {name:'cnum',index:'cnum', align: 'center',width:100, editable: true,search: false},
                    {name:'sub_Title',index:'sub_Title', align: 'center', editable: true,search: false,sortable: false},
                    {name: 'image', index: 'image', align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat},
                    {name: 'imgname', index: 'imgname', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
                    {name: 'isLogin', index: 'isLogin', align: 'center', sortable: false, editable: true,search: false,hidden: false, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'No','1':'Yes'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'No','1':'Yes'},
                        }, formatter: 'select',search: true},
                    {name:'Supervisor',index:'Supervisor', align: 'center',width:100, editable: true,search: true},
                    {name:'star',index:'star', align: 'center', editable: true,search: false},
                    {name:'cartoon_price',index:'cash', align: 'center', editable: true,search: false},
                    {name:'cartoon_sale',index:'sale', align: 'center', editable: true,search: false},
                    {name:'cartoon_price2',index:'cash', align: 'center', editable: true,search: false},
                    {name:'cartoon_sale2',index:'sale', align: 'center', editable: true,search: false},
                    {name: 'sType', index: 'sType', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'연재','1':'프롤로그','2':'휴재','3':'인터뷰','4':'특별편','5':'시즌종료'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'연재','1':'프롤로그','2':'휴재','3':'인터뷰','4':'특별편','5':'시즌종료'},
                        }, formatter: 'select',search: true},
                    {name: 'isActive', index: 'isActive', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'No','1':'Yes'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'No','1':'Yes'},
                        }, formatter: 'select',search: true},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                    {name:'update_date',index:'update_date', align: 'center', search:false, editable: true },
                    {name: 'scene', index: 'scene', align: 'center', sortable: false, editable: false, edittype: 'text',search: false, formatter: btnFormat},
                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'a.sn',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "작품별 회차 관리",
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
                editCaption: '작품별 회차  수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {
                    var cm = $('#list').jqGrid('getColProp', 'image'),
                    selRowId = $('#list').jqGrid('getGridParam', 'selrow');
                    selRowData = $('#list').jqGrid('getRowData', selRowId);
                    cm.editoptions.src = '<?echo(CONTENT_ASSETSROOT);?>/data/detail_banner/' + selRowData.imgname;
                    $("#list").jqGrid('setColProp', 'image', {editable:true});
                }
            },{
                addCaption: '작품별 회차 등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Sub_Cartoon/Data_Add/<?echo($ccode);?>',
                afterSubmit: uploadFile,
                beforeInitData:function(form){
                    $("#list").jqGrid('setColProp', 'image', {editable:false});
                },
                beforeShowForm: function(form) {
                }
             },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Sub_Cartoon/Data_Delete/<?echo($ccode);?>',
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


    function View_Scene(val1,val2){
        var URL = "<?echo(ROOT_URL);?>Sub_Cartoon/Scene/" + val1 + "/" + val2;

        location.href = URL;
    }

     function free_View(val1,val2){
         var URL = "<?echo(ROOT_URL);?>Sub_Cartoon/fView/" + val1 + "/" + val2;

         window.open(URL);
     }

    function File_Delete(){
        if(window.confirm("<?echo($c_name);?> 전체 파일을 삭제하시겠습니까?")== true){
            if(window.confirm("정말 삭제 하시겠습니까?")== true) {
                var URL = "<?echo(ROOT_URL);?>Main/FileDel2/<?echo($ccode);?>";
                popupOpen(URL, 500, 500, 100, 100);
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
                <h1 class="page-header">작품명:<?echo($c_name);?> > 회차 관리</h1><div align="right"><input type="button" value="파일삭제"  onclick="javascrip:File_Delete();" /></div>
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
