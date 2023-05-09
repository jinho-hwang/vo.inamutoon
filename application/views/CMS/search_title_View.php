<script type="text/javascript">
    function Selecttitle(val1,val2){
        window.opener.Selectid.value = val1;
        window.opener.searchTitle.value = val2;
        window.opener.searchTitle.disabled = true;
        self.close();
    }
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <input type="hidden" id="Selectid" name="Selectid" value="" />
            <h1 class="page-header">작품 검색</h1>
            <div class="form-group">
                <table >
                    <tr>
                        <td  align="center" width="350">제목 </td>
                        <td  align="center" width="50">선택</td>
                    </tr>
                    <tr><td style="height:50px;"></td></tr>

                <?if(ArrayCount($data)<=0){?>
                    <tr>
                        <td colspan="2" align="center">검색된 작품이 없습니다.</td>
                    </tr>
                <?}else{?>
                    <?foreach ($data as $d){?>
                    <tr>
                        <td  align="center" width="300"><?echo($d['title']);?></td>
                        <td  align="center" width="100"><input type="button" value="선택" onclick="Selecttitle('<?echo($d['code']);?>','<?echo($d['title']);?>');" /></td>
                    </tr>
                        <tr><td style="height:10px;"></td></tr>
                    <?}?>        
                <?}?>        
                        

                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>