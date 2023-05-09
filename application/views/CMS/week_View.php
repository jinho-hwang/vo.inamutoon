<script>
      $(function(){
          var btnFormat = function(cellValue, options, rowObject) {
              return "<a href='javascript:View_Info(" + cellValue + ");'>보기</a>";
          }

          var btnFormat2 = function(cellValue, options, rowObject) {
              return "<a href='javascript:View_Cartoon(" + cellValue + ");'>보기</a>";
          }


        $("#list").jqGrid({
            mtype:'POST',
            url: '<?echo(ROOT_URL);?>Cartoon/Week_Load/<?echo($pcode);?>',
            datatype: "json",
            loadonce: false,
            colNames:['요일'],
            height: 250,
            colModel:[
                {name: 'week', index: 'week', align: 'center', sortable: false, editable: true, editrules: {required: true}, stype: 'select', searchoptions: {value: {'1':'월요일','2':'화요일','3':'수요일','4':'목요일','5':'금요일','6':'토요일','7':'일요일'}}, edittype: 'select',
                    editoptions: {
                        value: {'1':'월요일','2':'화요일','3':'수요일','4':'목요일','5':'금요일','6':'토요일','7':'일요일'},
                    }, formatter: 'select',search: true}
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
            caption: "연재요일 관리",
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
            edit : false
        },{
            editCaption: '연재요일 등록',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
            beforeInitData: function(form) {
                $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:true}});
            }
        },{
            addCaption: '연재요일 수정',
            width:'400',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            url: '<?echo(ROOT_URL);?>Cartoon/Week_Add/<?echo($pcode);?>',
            beforeInitData: function(form) {
                $("#list").jqGrid('setColProp', 'userid', {edittype:'text',editoptions:{readonly:false}});
            }

         },{
            closeOnEscape: true,
            url: '<?echo(ROOT_URL);?>Cartoon/Week_Delete',
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

      function View_Cartoon(val){
          var url = '/AMember/Cartoon/' + val;
          $(location).attr('href',url);
      }


      function View_Info(val){
          var url = '/AMember/Auth/'+ val;
          popupOpen(url,600,650,10,10);
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
                <h1 class="page-header"><?echo($title);?> - 연재요일관리</h1>
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

