<script>
    $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>Counsel/Data_Load',
            editurl: '<?echo(ROOT_URL);?>Counsel/Data_Update',
            datatype: "json",
            postData : {cid:'<?echo($cid);?>'},
            loadonce: false,
            colNames:['회원종류','자문위원','단계','요청 일자','감수 마감 일자','감수 일자','감수 내용','감수 결과'],
            height: 250,
            colModel:[
                {name: 'mtyp', index: 'mtyp', width:'50',align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'자문위원','1':'EBS'}},formatter: 'select'},
                {name:'wname',index:'wname', align: 'center',width:'50', editable: false, search:false},
                {name: 'isStatus', index: 'isStatus', width:'50',align: 'center', sortable: false, editable: false, search: false, edittype: 'select', editoptions: {value: {'0':'감수 요청대기','1':'감수 요청','2':'감수 진행중','3':'감수 완료'}},formatter: 'select'},
                {name:'regidate',index:'regidate',width:'80', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                {name:'reqenddate',index:'reqenddate',width:'80', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                {name:'enddate',index:'enddate', align: 'center',width:'100', editable: true, search:false},
                {name:'Comment',index:'Comment', align: 'center', editable: false, search:false},
                {name: 'c_result', index: 'c_result', width:'30',align: 'center', sortable: false, editable: false, search: false, edittype: 'select', editoptions: {value: {'0':'미검수','1':'적합','2':'부적합'}},formatter: 'select'}
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: '#pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'sn',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "관리",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });

        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            view: false,
            search:false,
            add : false,
            edit : false
            //viewtext: '보기',
            //edittext: '수정',
            //addtext:  '등록',
            //deltext:  '삭제',
            //searchtext: '검색',
            //refreshtext: '새로고침',
        },{
            editCaption: '정보 수정',
            width: '600', closeAfterEdit: true, closeOnEscape:true, checkOnSubmit:true,
            recreateForm: true,
        },{},{
            closeOnEscape: true,
            url: '<?echo(ROOT_URL);?>Counsel/Data_Delete',
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
</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>

<script>
    $(document).ready(function() {
        $('#search').click(function () {
            if($.trim($('#tstr').val()) == ''){
                alert("검색어를 입력하세요.");
            }else{
                $("#fsearch").submit();
            }
        });

        $('#dataini').click(function () {
            $('#tstr').val('');
            $(location).attr('href',"<?echo(ROOT_URL);?>/Counsel");
        });
    })
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?echo($title);?>-<?echo($pNum);?>회차 감수 담당자</h1>
<!--            <div class="form-group">-->
<!--                <table>-->
<!--                    <tr>-->
<!--                        <form name="fsearch" id="fsearch" method="post" action="--><?//echo(ROOT_URL);?><!--/Counsel">-->
<!--                            <td>-->
<!--                                <select id="typ" name="typ" class="form-control">-->
<!--                                    <option value="">선택하세요.</option>-->
<!--                                    --><?//if($typ==1){?>
<!--                                        <option value="1" selected>제목</option>-->
<!--                                    --><?//}else{?>
<!--                                        <option value="1">제목</option>-->
<!--                                    --><?//}?>
<!---->
<!--                                    --><?//if($typ==2){?>
<!--                                        <option value="2" selected>자문위원</option>-->
<!--                                    --><?//}else{?>
<!--                                        <option value="2">자문위원</option>-->
<!--                                    --><?//}?>
<!--                                </select>-->
<!--                            </td>-->
<!--                            <td width="20" align="center">&nbsp;</td>-->
<!--                            <td>-->
<!--                                <input type="text" id="tstr" name="tstr" value="--><?//echo($tstr);?><!--" />-->
<!--                            </td>-->
<!--                            <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>-->
<!--                            <td width="100" align="center"><button id="dataini" class="btn btn-default">초기화</button></td>-->
<!--                        </form>-->
<!--                    </tr>-->
<!--                </table>-->
<!--            </div>-->
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
