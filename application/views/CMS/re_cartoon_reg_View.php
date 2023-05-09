<script>
    function Search_Cartoon(){
        var tstr = $('.search').val();
        if(tstr==''){
            alert('검색어를 입력하세요.');
        }else{
            $('#fsearch').submit();
        }

    }
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">웹툰 예약  등록</h1>
            <div class="form-group">
                <table>
                    <tr>
                        <form name="fsearch" id="fsearch" method="post" action="<?echo(ROOT_URL);?>/Re_Cartoon/Reg_pop2">
                            <td width="50" align="center">카툰명 : </td>
                            <td width="20" align="center">&nbsp;</td>
                            <td>
                                <input type="text" id="tstr" name="tstr"  />
                            </td>
                            <td width="100" align="center"><button type="button" id="search" class="btn btn-default" onclick="javascript:Search_Cartoon();">검 색</button></td>
                        </form>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


</div>