<script>
    function Search_Cartoon(){
        var tstr = $('.search').val();
        if(tstr==''){
            alert('검색어를 입력하세요.');
        }else{
            $('.fsearch').submit();
        }

    }

    function ck_cartoon(val) {
        $('#pcode').val(val);
    }

    function Reg_Ini() {
        $(location).attr('href','<?echo(ROOT_URL);?>Re_Cartoon/Reg_pop');
    }
    
    function Reg_Cartoon() {
        var pcode = $('#pcode').val();
        var scode = $('#scode').val();
        var isReserve = $('#isReserve').val();
        var opendate = $('#opendate').val();

        if(pcode==''){
            alert('등록하실 웹툰을 선택하세요,');
        }else if(scode==''){
            alert('회차를 입력하세요.');
        }else if(isReserve==''){
            alert('적용유무를 선택하세요.');
        }else if(opendate==''){
            alert('오픈일자를 입력하세요.');
        }else{
            $('#finput').submit();
        }
    }
    
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">웹툰 예약  등록</h1>
            <div class="form-group">
                <?if(ArrayCount($data)>0){?>
                <form name="finput" id="finput" method="post" action="<?echo(ROOT_URL);?>Re_Cartoon/Reg_proc">
                    <input type="hidden" id="pcode" name="pcode" />
                <table style="width:100%;">
                    <?foreach ($data as $v){?>
                    <tr style="">
                        <td><input type="radio" name="search" value="<?echo($v['code']);?>" onclick="javascript:ck_cartoon('<?echo($v['code']);?>');" /></td>
                        <td><?echo($v['title']);?></td>
                    </tr>
                    <?}?>
                </table>
                <br>
                <table style="width:100%;" >
                    <tr>
                            <td width="100" align="left">회차</td>
                            <td>
                                <input type="text" id="scode" name="scode"  />
                            </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="heigth:3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="100" align="left">적용유무</td>
                        <td>
                            <select id="isReserve" name="isReserve" >
                                <option value="">선택하세요.</option>
                                <option value="0">미실행</option>
                                <option value="1">예약</option>
                                <option value="2">완료</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="heigth:3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="100" align="left">오픈일자</td>
                        <td>
                            <input type="text" id="opendate" name="opendate"  />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">※예약 등록시 오픈일자는 2016-12-12 폼으로 등록 하여주세요.</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="heigth:3px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button type="button" id="search" class="btn btn-default" onclick="javascript:Reg_Cartoon();">등 록</button>
                            <button type="button" id="search" class="btn btn-default" onclick="javascript:Reg_Ini();">초기화</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="heigth:3px;">&nbsp;</td>
                    </tr>
                </table>
                </form>
                <?}else{?>
                    <div>*검색결과 없음</div>
                    <br>
                    <button type="button" id="search" class="btn btn-default" onclick="javascript:Reg_Ini();">초기화</button>
                <?}?>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


</div>