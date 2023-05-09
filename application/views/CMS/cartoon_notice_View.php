<script>
    $(function(){

        
        var uploadFile = function(response, postdata) {
            var returnData = eval("(" + response.responseText + ")");
            if (returnData.result) {
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_banner_img2/',
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
                url: '<?echo(ROOT_URL);?>Cartoon/Notice_Data_Load',
                editurl: '<?echo(ROOT_URL);?>Cartoon/Notice_Data_Update/',
                datatype: "json",
                postData : {pcode : '<?echo($ccode);?>'},
                loadonce: false,
                colNames:['sn','내용','사용유무','등록일자'],
                height: 250,
                colModel:[
                    {name:'sn',index:'sn',width:50, align: 'center', editable: false,search: false,sortable: false,hidden: true},
                    {name: 'title',index:'title',width:300, align: 'center', search:false, editable: true},
                    {name: 'isOpen', index: 'isOpen', width:50,align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'미사용','1':'사용'}}, edittype: 'select',
                        editoptions: {
                            value: {'0':'미사용','1':'사용'},
                        }, formatter: 'select',search: true},
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
                caption: "작품별 한줄공지 관리",
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
                editCaption: '작품별 한줄공지 수정',
                width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
                recreateForm: true,
                afterSubmit: uploadFile,
                beforeInitData: function () {}
            },{
                addCaption: '작품별 한줄공지 등록',
                width:'600',
                jqModal: true,
                recreateForm: true,
                closeAfterAdd: true,
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon/Notice_Data_Add/<?echo($ccode);?>',
                afterSubmit: uploadFile,
                beforeInitData:function(form){},
                beforeShowForm: function(form) {}
            },{
                closeOnEscape: true,
                url: '<?echo(ROOT_URL);?>Cartoon/Notice_Data_Delete/',
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
            <h1 class="page-header">작품명:<?echo($c_name);?> > 한줄 공지 관리</h1>
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
