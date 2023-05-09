<form name="writeForm" id="writeForm" method='post' action='/Counsel/Mod_All/'>
    <table class="table table-bordered">
        <tr>
            <td class="td2" colspan="2">일괄처리</td>
        </tr>
        <tr>
            <td class="td1">멤버</td>
            <td>
                <select name="mtyp" id="mtyp">
                    <option value="">선택하세요.</option>
                    <option value="0">자문위원</option>
                    <option value="1">EBS 위원</option>
                    <option value="2">아이나무</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="td1">작업내용</td>
            <td>
                <select name="styp" id="styp">
                    <option value="">선택하세요.</option>
                    <option value="1">완료날짜변경</option>
                    <option value="2">EBS 넘기기</option>
                    <option value="3">아이나무 완료일자변경</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="td1">수정일자</td>
            <td><input type="text" name="sdate" id="sdate" /><br><span style="font-size: 16px;color:red;">(등록되는 날짜 형식은 2000-01-01 입니다.)</span></td>
        </tr>
        <tr>
            <td class="td1">적용 감수번호</td>
            <td><input type="text" name="cidin" id="cidin" style="width:300px;" /><br><span style="font-size: 16px;color:red;">(구분자는 , 입니다.)</span></td>
        </tr>

    </table>
</form>

</body>


<button type="button" name="reg" id="reg" onclick="Mod_All();" class="btn btn-primary btn-lg btn-block" style="width:400px;margin: auto;">적용</button>
</form>
</body>

