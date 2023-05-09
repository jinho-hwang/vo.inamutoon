<script>
    $(function(){
        var imgFormat = function(cellValue, options, rowObject) {
            return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/detail_banner/" + cellValue + "' />";
        }

        var btnFormat = function(cellValue, options, rowObject) {
            return "<a href=\"javascript:View_Scene('" + cellValue + "');\">파일보기</a>";
        }



        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");
            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_Scene_img/',
                    secureuri: false,
                    fileElementId:'imgname',
                    dataType: 'json',
                    data : {sn : returnData.code,pcode:<?echo($pcode);?>,cnum:<?echo($cnum);?>,key:'imgname',v_type:<?echo($view_type);?>},
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
                        $.ajax({
                            url: '<?echo(ROOT_URL);?>SuCartoon/Load_ImgName_frame',
                            dataType: 'json',
                            method: 'post',
                            data : {pcode:<?echo($pcode);?>,cnum:<?echo($cnum);?>},
                            success:function(data){
                                newhtml = '마지막 업로드된 파일 원명 : ' + data.fname;
                                $('#orgname').html(newhtml);
                            }
                        })
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
                url: '<?echo(ROOT_URL);?>SuCartoon/Scene_Load/<?echo($pcode);?>/<?echo($cnum);?>',
                editurl: '<?echo(ROOT_URL);?>SuCartoon/Scene_Update/<?echo($pcode);?>/<?echo($cnum);?>',
                datatype: "json",
                loadonce: false,
                colNames:['카툰명','회차','씬번호','이미지명','파일명','regidate'],
                height: 250,
                colModel:[
                    {name:'title',index:'title', align: 'center', editable: false},
                    {name:'cnum',index:'cnum', align: 'center', editable: false,search: false},
                    {name:'scene',index:'scene', align: 'center', editable: false,search: false},
                    {name: 'imgname', index: 'imgname', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
                    {name:'fname',index:'fname', align: 'center', editable: false,search: false,formatter: btnFormat},
                    {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}}

                ],
                rowNum: 60,
                rowTotal: 10000,
                rowList: [20, 40, 60],
                pager: 'pager',
                toppager: true,
                cloneToTop: true,
                sortname: 'scene',
                viewrecords: true,
                sortorder: 'desc',
                multiselect: false,
                caption: "카툰 관리",
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
                editCaption: '회차 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {
                }
            },{
                addCaption: '회차등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>SuCartoon/Scene_Add/<?echo($pcode);?>/<?echo($cnum);?>',
                afterSubmit: uploadFile,
                beforeInitData:function(form){
                },
                beforeShowForm: function(form) {
                }
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>SuCartoon/Scene_Delete',
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
        window.open('<?echo(CONTENT_ASSETSROOT);?>/data/cartoon_scene1/mobile/' +val);
    }

    function free_View(){
        var URL = "<?echo(ROOT_URL);?>SuCartoon/fView/<?echo($pcode);?>/<?echo($cnum);?>";

        window.open(URL);
    }

    function free_View2(){
        var URL = "<?echo(ROOT_URL);?>SuCartoon/fView2/<?echo($pcode);?>/<?echo($cnum);?>";

        window.open(URL);
    }

    function All_Delete(){
        if(window.confirm("전체 씬을 삭제하시겠습니까?")==true) {
            var URL = "<?echo(ROOT_URL);?>SuCartoon/Scene_ADel/<?echo($pcode);?>/<?echo($cnum);?>";
            window.location.href = URL;
        }
    }

    function booking_View(){
        var URL = "<?echo(ROOT_URL);?>Re_Cartoon/View/";
        window.open(URL);
    }

    function File_Delete(){
        if(window.confirm("<?echo($title);?> > <?echo($cnum);?> 회차 전체를 삭제하시겠습니까?")== true){
            if(window.confirm("정말 삭제 하시겠습니까?")== true) {
                var URL = "<?echo(ROOT_URL);?>SuCartoon/FileDel/<?echo($pcode);?>/<?echo($cnum);?>";
                popupOpen(URL, 500, 500, 100, 100);
            }
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

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">작품명:<?echo($title);?> > <?echo($cnum);?> 회차 > Scene 관리 </h1><div align="right"><input type="button" value="전체삭제"  onclick="javascrip:File_Delete();" />&nbsp;<input type="button" value="미리보기"  onclick="javascript:free_View();" />&nbsp;<input type="button" value="예약하기"  onclick="javascript:booking_View();" />&nbsp;<input type="button" value="용량축소"  onclick="javascript:free_View2();" /></div>
            <?if(empty($lastname)){?>
                <div><p id="orgname"></p></div>
            <?}else{?>
                <div><p id="orgname">마지막 업로드된 파일 원명 : <?echo($lastname);?></p></div>
            <?}?>
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
