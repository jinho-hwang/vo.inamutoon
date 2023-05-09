<script>
    $(function(){

        var btnFormat = function(cellValue, options, rowObject) {
            return "<a href='javascript:View_Member(" + cellValue + ");'>보기</a>";
        }
        var btnFormat1 = function(cellValue, options, rowObject) {
            return "<a href='javascript:View_Info(" + cellValue + ");'>보기</a>";
        }

        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>Counsel/AData_Load',
            datatype: "json",
            postData : {tstr:'<?echo($tstr);?>',typ:'<?echo($typ);?>'},
            loadonce: false,
            colNames:['cid','웹툰명','회차','요청 일자','감수 마감 일자','상태','감수 멤버 보기','감수 내용 보기'],
            height: 250,
            colModel:[
                {name:'cid',index:'cid', align: 'center',width:'30', editable: false, search:false, sortable: true},
                {name: 'pCode', index: 'pCode', width:'100',align: 'center', sortable: true, editable: true, search: false, edittype: 'select', editoptions: {value: {<?echo($cartoon);?>}},formatter: 'select'},
                {name:'pNum',index:'pNum', align: 'center',width:'30', editable: true, search:false, sortable: true},
                {name:'startdate',index:'regidate',width:'50', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                {name:'enddate',index:'enddate',width:'50', align: 'center', search:false, editable: false, editoptions: {readonly: true}},
                {name: 'isStatus', index: 'isStatus', width:'100',align: 'center', sortable: false, editable: true, search: false, edittype: 'select', editoptions: {value: {'0':'감수 대기','1':'자문위원 감수요청','2':'자문위원 감수진행','3':'자문위원 감수완료','4':'EBS 감수요청','5':'EBS 감수 진행','6':'EBS 감수완료','7':'EBS 재감수요청','8':'EBS 재감수진행','9':'EBS 재감수 완료','10':'오픈 대기'}},formatter: 'select'},
                {name: 'act', index: 'act', align: 'center',width:'50', sortable: false, editable: false, edittype: 'text',search: false, formatter: btnFormat},
                {name: 'cid', index: 'cid', align: 'center',width:'50', sortable: false, editable: false, edittype: 'text',search: false, formatter: btnFormat1},
            ],
            rowNum: 60,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: '#pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'cid',
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
            add:false,
            view: false,
            search:false,
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
        },{
            addCaption: '등록',
            recreateForm: true,
            closeAfterAdd: true,
            closeOnEscape: true,
            width:'600',
            beforeShowForm: function(form) {  }
        },{
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


    function prn_Excel(){
        var sdate = $('#syear').val() + "-" + $('#smonth').val() + '-' + $('#sday').val();
        var edate = $('#eyear').val() + "-" + $('#emonth').val() + '-' + $('#eday').val();

        var url = '/Counsel/Excel/' + $('#mtyp').val() + "/"  + sdate + "/" + edate ;
        popupOpen(url,600,650,10,10);

    }

    function View_Member(val){
        $(location).attr('href','/Counsel/Member/' + val);
    }

    function Reg_Data(){
        var url = '/Counsel/Reg_Counsel/';
        popupOpen(url,600,650,10,10);
    }

    function View_Info(val){
        var url = '/Counsel/View_Counsel/'+ val;
        popupOpen(url,600,650,10,10);
    }


    function ini_Data(){
        location.reload();
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
            <h1 class="page-header">감수 관리</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <td width="100" align="center"><button id="search" class="btn btn-default" onclick="javascrip:Reg_Data();">등 록</button></td>
                        <td width="100" align="center"><button id="search" class="btn btn-default" onclick="javascrip:ini_Data();">초기화</button></td>
                        <td  align="center" width="100">/</td>
                        <td>
                            <select id="syear" class="form-control">
                                <?echo($syear);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="smonth" class="form-control">
                                <?echo($smonth);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="sday" class="form-control">
                                <?echo($sday);?>
                            </select>
                        </td>
                        <td width="10" align="center">~</td>
                        <td>
                            <select id="eyear" class="form-control">
                                <?echo($eyear);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="emonth" class="form-control">
                                <?echo($emonth);?>
                            </select>
                        </td>
                        <td width="10" align="center">-</td>
                        <td>
                            <select id="eday" class="form-control">
                                <?echo($eday);?>
                            </select>
                        </td>
                        <td width="10" align="center"></td>
                        <td>
                            <select id="mtyp" class="form-control">
                                <option value="0" selected>자문위원</option>
                                <option value="1">EBS위원</option>
                            </select>
                        </td>

                        <td width="100" align="center"><button id="search" class="btn btn-default" onclick="javascript:prn_Excel();">엑셀</button></td>

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

