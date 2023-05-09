<script>
    $(document).ready(function(){
        $('#search').click(function(){
            location.href = '<?echo(ROOT_URL);?>Shop/DashBoard/Summary/' + $('#year').val() + '/' + $('#month').val();
        });
        $('#list').click(function(){
            location.href = '<?echo(ROOT_URL);?>Shop/DashBoard/DataList/' + $('#year').val() + '/' + $('#month').val();
        });
    });

</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?echo($year);?>년<?echo($month);?>월 MD샵 결제요약</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="form-group">
        <table>
            <tr>
                <td  align="center" width="100">검색월</td>
                <td>
                    <select id="year" class="form-control">
                        <?for($i=-1;$i<=1;$i++){
                            if($year==(date('Y')+$i)){
                                ?>
                                <option selected><?echo(date('Y')+$i);?></option>
                                <?
                            }else{
                                ?>
                                <option ><?echo(date('Y')+$i);?></option>
                                <?
                            }
                        }?>
                    </select>
                </td>
                <td width="20" align="center">/</td>
                <td>
                    <select id="month" class="form-control">
                        <?for($i=1;$i<=12;$i++){
                            if($month==$i){
                                ?>
                                <option selected><?echo(str_pad($i,2,"0",STR_PAD_LEFT));?></option>
                                <?
                            }else{
                                ?>
                                <option ><?echo(str_pad($i,2,"0",STR_PAD_LEFT));?></option>
                                <?
                            }
                        }?>
                    </select>
                </td>
                <td width="100" align="center"><button id="search" class="btn btn-default">검 색</button></td>

            </tr>
        </table>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-success">
                <div class="panel-heading">
                    판매 내역
                </div>
                <div class="panel-body">
                    <p>1.총 판매액 : <?echo(number_format($totalprice+$totaldel));?>원 (총<?echo(number_format($totalCnt));?>건) (총배송비 <?echo(number_format($totaldel));?>원 포함)</p>
                    <p>2.총 쿠폰사용액  : <?echo(number_format($totalsale));?>원</p>
                    <p>3.총 포인트사용액  : <?echo(number_format($totalpoint));?>원</p>
                    <p>4.총 실판매액  : <?echo(number_format($total_real));?>원 ((총판매액 - (총쿠폰사용액 + 총포인트사용액 + 총배송비))</p>
                    <p>6.총 수수료액  : <?echo(number_format($total_share));?>원 (총실판매액의 <?echo(SHOP_RATE);?>%)</p>
                    <p>6.총 정산금액  : <?echo(number_format($total_amount));?>원 (총 실판매액 - 총 정산금액 : 업제 정산금액) </p>

                </div>
                <div class="panel-footer">
                    <button id="list" class="btn btn-default">상세내역 보기</button>
                </div>
            </div>
        </div>
    </div>
</div>
