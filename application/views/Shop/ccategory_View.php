<script>
    $(function(){
        $("#list").jqGrid({
            mtype:'POST',
            url: '<?echo(SHOP_ROOT_URL);?>Category/CData_Load',
            datatype: "json",
            loadonce: false,
            colNames:['코드','대카테고리명','중카테고리명','카테고리명','사용유무','등록일자'],
            height: 250,
            colModel:[
                {name:'cCode',index:'aCode', align: 'center', editable: false, editrules: {required: true},search: true},
                {name: 'aCode', index: 'aCode',width:100, align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $select_box1?>}}, edittype: 'select',
                    editoptions: {
                        value: {<?php echo $select_box1?>},
                    }, formatter: 'select',search: true},
                {name: 'bCode', index: 'bCode',width:100, align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {<?php echo $select_box2?>}}, edittype: 'select',
                    editoptions: {
                        value: {<?php echo $select_box2?>},
                    }, formatter: 'select',search: true},
                {name:'cName',index:'cName', align: 'center', editable: true, editrules: {required: true},search: true},
                {name:'isUse', index: 'isUse', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'0':'사용안함','1':'사용'}}, edittype: 'select',
                    editoptions: {
                        value: {'0':'사용안함','1':'사용'},
                    }, formatter: 'select',search: true},
                {name:'regidate',index:'regidate', align: 'center', search:false, editable: false, editoptions: {readonly: true}}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: 'pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'cCode',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "소카테고리 관리",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });


        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            add : true,
            view: false,
            search:false,
            refresh:false,
            edit : true,
            del : true
        },{
            editCaption: '소카테고리 수정',
            url: '<?echo(SHOP_ROOT_URL);?>Category/CData_Update',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
            beforeInitData: function(form) {
                $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:true}});
            }
        },{
            addCaption: '소회원정보 등록',
            width:'400',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Category/CData_Add',
            beforeInitData: function(form) {
                
            }

        },{
            closeOnEscape: true,
            url: '<?echo(SHOP_ROOT_URL);?>Category/CData_Delete',
            afterSubmit: function(response, postdata) {
                var result = eval("(" + response.responseText + ")");
                return [result.result, result.message];
            }
        },{
            sopt: ['cn','eq']
        });

        $(window).bind('resize', function () {
            var width = $('.jqGrid_wrapper').width();
            $('#list').setGridWidth(width);
        });
    });


    function fnGetCtgSub(typ,sParam){
        if(typ==1) {
            var $target = $("select[name='bcategory']");
        }else{
            var $target = $("select[name='ccategory']");
        }

        $target.empty();
        if(sParam==""){
            $target.append("<option value=''>선택하세요.</option>");
        }

        $.ajax({
            type: "POST",
            url: "<?echo(WEB_URL);?>/Category/GetCategory",
            async: false,
            data:{ type : typ ,code : sParam },
            dataType: "json",
            success: function(jdata){
                if(jdata.length==0){
                    $target.html();
                    $target.append("<option value=''>선택하세요.</option>");
                }else{
                    $target.html();
                    $target.append("<option value=''>선택하세요.</option>");
                    $(jdata).each(function(i){
                        $target.append("<option value='"  + jdata[i].Code + "'>" + jdata[i].Name + "</option>");
                    })
                }
            }
        })
    }
</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>
<script type="text/javascript">
    function ini_Data(){
        $(location).attr('href',"<?echo(WEB_URL);?>/CCategory")
    }

    function reg_win(){
        popupOpen('<?echo(WEB_URL);?>/Category/CGroup_Reg',100,100,500,250);
    }

</script>
<div id="page-wrapper">
    <form name="reg" method="post" action="<?echo(WEB_URL);?>/Category/CData_Add">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">소카테고리 관리</h1><div align="right"><input type="button" value="등록"  onclick="javascrip:reg_win();" />&nbsp;<input type="button" value="Reset"  onclick="javascrip:ini_Data();" /></div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    </form>
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

