<script>
    $(function(){
        var imgFormat1 = function(cellValue, options, rowObject) {
            return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/cartoon_banner/" + cellValue + "' />";
        }

        var imgFormat2 = function(cellValue, options, rowObject) {
            return "<img class='thmb_img' src='<?echo(CONTENT_ASSETSROOT);?>/data/cartoon_banner/bg/" + cellValue + "' />";
        }

        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");
            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_cartoon_img1/',
                    secureuri: false,
                    fileElementId:'imgname1',
                    dataType: 'json',
                    data : {sn : returnData.code,key:'imgname1'},
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


                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_cartoon_img2/',
                    secureuri: false,
                    fileElementId:'imgname2',
                    dataType: 'json',
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
                url: '<?echo(ROOT_URL);?>SCartoon/Img_Data_Load',
                editurl: '<?echo(ROOT_URL);?>SCartoon/Img_Data_Update/',
                datatype: "json",
                postData : {pcode : '<?echo($ccode);?>'},
                loadonce: false,
                colNames:['sn','위치','사용유무','이미지','이미지등록','배경칼라','글자색','등록일자'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn',width:50, align: 'center', editable: false,search: false,sortable: false,hidden: true},
                    {name: 'location', index: 'location',width:50, align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'1':'상세탑','2':'검색탑','3':'모바일상세탑','4':'PC상세탑배경','5':'모바일상세탑배경','6':'모바일랭킹탑','7':'즐겨보는웹툰'}}, edittype: 'select',
                        editoptions: {
                            value: {'1':'PC상세탑','2':'검색탑','3':'모바일상세탑','4':'PC상세탑배경','5':'모바일상세탑배경','6':'모바일랭킹탑','7':'즐겨보는웹툰'},
                        }, formatter: 'select',search: true},
                    {name: 'isUse', index: 'isUse', width:50,align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'미사용','1':'사용'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'미사용','1':'사용'},
                        }, formatter: 'select',search: true},
                    {name: 'image', index: 'image', align: 'center', sortable: false, editable: false, edittype: 'image',search: false, editoptions: {src: '', dataInit: function(domElem) {$(domElem).addClass('thmb_img')}}, search: false, formatter: imgFormat1},
                    {name: 'imgname1', idex: 'imgname1', align: 'center', sortable: false, editable: true, search: false, hidden: true, edittype: 'file', editrules: {edithidden: true}},
                    {name: 'fcolor',index:'fcolor',width:50, align: 'center', search:false, editable: true},
                    {name: 'font_color',index:'font_color',width:50, align: 'center', search:false, editable: true},
                    {name: 'regidate',index:'regidate', width:80,align: 'center', search:false, editable: false, editoptions: {readonly: true}}
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
                caption: "작품별 배너관리 관리",
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
                editCaption: '작품별 배너관리 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {}
            },{
                addCaption: '작품별 배너관리 등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>SCartoon/Img_Data_Add/<?echo($ccode);?>',
                afterSubmit: uploadFile,
                beforeInitData:function(form){},
                beforeShowForm: function(form) {}
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>SCartoon/Img_Data_Delete/',
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
</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">작품명:<?echo($c_name);?> > 이미지 관리</h1>
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
