<script>
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

    function All_Data(){
        var url = '/Counsel/View_All/';
        popupOpen(url,600,350,10,10);
    }

    function ini_Data(){
        $(location).attr('href','/Counsel/Blist');
    }

    function popupOpen(popUrl,width,height,top,left){
        var popOption = "width=" + width + ", height=" + height + ",top=" + top + ",left=" + left + ", resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
        window.open(popUrl,"",popOption);
    }
</script>
<div style="padding-left:280px; ">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-lg-12"><h1 class="page-header">감수 관리</h1></div>
            <div class="form-group">
                <table>
                    <tr>
                        <form name="search" id="search" method="post" action="/Counsel/Blist">
                        <td width="200" align="center"><input class="form-control" id="tstr" name="tstr" placeholder="작품명 입력" style="width:200px;margin-left:50px;" value="<?echo($tstr);?>"></td>
                        <td  align="center" width="20">&nbsp;</td>
                        <td width="50" align="left">
                            <button id="search1" name="search21" class="btn btn-default"  onclick="javascrip:Search_Data();">검 색</button>
                        </td>
                        </form>
                        <td  align="center" width="60">/</td>
                        <td>
                            <button id="search2" class="btn btn-default" onclick="javascrip:Reg_Data();">등 록</button>
                            <button id="search3" class="btn btn-default" onclick="javascrip:ini_Data();">리셋</button>
                            <button class="btn btn-default" onclick="All_Data();">일괄처리</button>
                        </td>
                        <td  align="center" width="60">/</td>
                        <td  align="center" width="100">엑셀추출</td>
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
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td align="center" width="100px">감수번호</td>
                        <td align="center" width="400px">웹툰명</td>
                        <td align="center" width="120px">관리용 회차</td>
                        <td align="center" width="120px">오픈용 회차</td>
                        <td align="center" width="150px">요청일자</td>
                        <td align="center" width="150px">감수 마감일자</td>
                        <td align="center" width="200px">상태</td>
                        <td align="center" width="100px">자문위원</td>
                        <td align="center" width="100px">EBS</td>
                        <td align="center" width="100px">아이나무</td>
                        <td align="center" width="100px">멤버</td>
                        <td align="center" width="100px">내용</td>
                        <td align="center" width="100px">삭제</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($data as $key){?>
                        <tr>
                            <td align="center"><?echo($key['cid']);?></td>
                            <td align="center"><?echo($key['title']);?></td>
                            <td align="center"><?echo($key['pNum']);?></td>
                            <td align="center"><?echo($key['subname']);?></td>
                            <td align="center"><?echo($key['sdate']);?></td>
                            <td align="center"><?echo($key['edate']);?></td>
                            <td align="center"><span id="status<?echo($key['cid']);?>"><?echo($key['status']);?></span></td>
                            <?if($key['gtype']==0){?>
                            <td align="center"><span id="gtype<?echo($key['cid']);?>"><button class="btn btn-default" onclick="Process_Step('<?echo($key['cid']);?>',0);">강제감수처리</button></span></td>
                            <?}else if($key['gtype']==1){?>
                            <td align="center"><span id="gtype<?echo($key['cid']);?>"><button class="btn btn-default" onclick="Process_Step2('<?echo($key['cid']);?>',3);">감수완료처리</button></span></td>
                            <?}else if($key['gtype']==2){?>
                            <td align="center"><span id="gtype<?echo($key['cid']);?>"><button class="btn btn-default" onclick="Process_Step3('<?echo($key['cid']);?>',4);">EBS 감수요청</button></span></td>
                            <?}else{?>
                            <td align="center"><span id="gtype<?echo($key['cid']);?>"></span></td>
                            <?}?>
                            <?if($key['etype']==0){?>
                            <td align="center"><span id="etype<?echo($key['cid']);?>"><button class="btn btn-default" onclick="Process_Step('<?echo($key['cid']);?>',1);">강제감수처리</button></span></td>
                            <?}else if($key['etype']==1){?>
                                <?if($key['isStatus']==8){?>
                            <td align="center"><span id="etype<?echo($key['cid']);?>"><button class="btn btn-default" onclick="Process_Step2('<?echo($key['cid']);?>',9);">감수완료처리</button></span></td>
                                 <?}else{?>
                            <td align="center"><span id="etype<?echo($key['cid']);?>"><button class="btn btn-default" onclick="Process_Step2('<?echo($key['cid']);?>',6);">감수완료처리</button></span></td>
                                 <?}?>
                            <?}else{?>
                            <td align="center"><span id="etype<?echo($key['cid']);?>"></span></td>
                            <?}?>
                            <?if($key['itype']==1){?>
                            <td align="center"><span id="itype<?echo($key['cid']);?>"><button class="btn btn-default" onclick="Process_Step4('<?echo($key['cid']);?>');">오픈대기처리</button><button class="btn btn-default" onclick="Process_Step5('<?echo($key['cid']);?>');">재감수 요청</button></span></td>
                            <?}else{?>
                            <td align="center"><span id="itype<?echo($key['cid']);?>"></span></td>
                            <?}?>
                            <td align="center"><a href="javascript://" onclick="View_Member('<?echo($key['cid']);?>');">보기</a></td>
                            <td align="center"><a href="javascript://" onclick="View_Info('<?echo($key['cid']);?>');">보기</a></td>
                            <?if($key['isStatus']==1){?>
                            <td align="center"><button class="btn btn-default" onclick="Process_Del('<?echo($key['cid']);?>');">삭제</button></td>
                            <?}else{?>
                            <td align="center"></td>
                            <?}?>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    <?if(empty($tstr)){?>
        <div align="center" style="font-size: 30px;"><?echo($page);?></div>
    <?}?>
    </div>
</div>