<script type="text/javascript" src="<?echo(ASSETS_ROOT);?>/addon/smart_editor/js/HuskyEZCreator.js" charset="utf-8"></script>
<style>
    body {margin-left:30px;margin-bottom:30px;}

</style>
<div style="width:800px;">
    <form action="<?echo(SHOP_ROOT_URL);?>Product/Reg_Data" method="post" name="reg_board" id="reg_board" enctype="multipart/form-data" >
        <input type="hidden" name="pCode" id="pCode" value="<?echo($pCode);?>" />
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">상품등록</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="form-group">
            <label>상품코드</label>
            <input class="form-control" name="pCode1" id="pCode1" value="<?echo($pCode);?>" style="width:400px;text-align:left;" />
        </div>
        <div class="form-group">
            <label>상품명</label>
            <input class="form-control" name="pName" id="pName" style="width:400px;text-align:left;" />
        </div>
        <div class="form-group">
            <label>상품이미지-메인</label>
            <input type="file" id="main_thumb1" name="main_thumb1">
        </div>
        <div class="form-group">
            <label>상품이미지-2</label>
            <input type="file" id="main_thumb2" name="main_thumb2">
        </div>
        <div class="form-group">
            <label>상품이미지-3</label>
            <input type="file" id="main_thumb3" name="main_thumb3">
        </div>
        <div class="form-group">
            <label>상품이미지-4</label>
            <input type="file" id="main_thumb4" name="main_thumb4">
        </div>
        <div class="form-group">
            <label>상품이미지-5</label>
            <input type="file" id="main_thumb5" name="main_thumb5">
        </div>
        <div class="form-group">
            <label>카테고리</label>
            <select name="acategory" id="acategory" onchange="fnGetCtgSub(1,this.value)"><?echo($select_box);?></select>&nbsp;<select name="bcategory" id="bcategory" onchange="fnGetCtgSub(2,this.value)"></select>&nbsp;<select name="ccategory" id="ccategory"></select>
        </div>
        <div class="form-group">
            <label>업체</label>
            <select name="cCode" id="cCode">
                <?echo($com);?>
            </select>
        </div>
        <div class="form-group">
            <label>옵션1</label>
            <input class="form-control" name="option1" id="option1" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label>옵션2</label>
            <input class="form-control" name="option2" id="option2" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label>옵션3</label>
            <input class="form-control" name="option3" id="option3" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label>옵션4</label>
            <input class="form-control" name="option4" id="option4" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label>옵션5</label>
            <input class="form-control" name="option5" id="option5" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label>가격</label>
            <input class="form-control" name="price" id="price" onchange="getNumber(this);" onkeyup="getNumber(this);" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label>할인</label>
            <input class="form-control" name="sale" id="sale" value="0"  onchange="getNumber(this);" onkeyup="getNumber(this);" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label>포인트</label>
            <input class="form-control" name="point" id="point" value="0" onchange="getNumber(this);" onkeyup="getNumber(this);" style="width:400px;text-align:right;"/>
        </div>
        <div class="form-group">
            <label> 본문 이미지 파일 용량은 2M byte 이하로 제한이있습니다.</label>
        </div>
        <div class="form-group"  align="center">
            <textarea name="ir1" id="ir1" rows="10" cols="100" style="width:766px; height:412px; display:none;">
                    <div class="product_content">
                        <p class="title"><span><img src="http://content.ebstoon.com/assets/data/shop/body/e67a5f7946249dbb250f0602e59a4bf7.jpg"><br></span></p>
                        <p class="title">
                            <span>수학술사의 귀한</span>
                            <strong>세미와 매직큐브 피규어</strong>
                        </p>

                        <p>세미와 매직큐브 피규어는 일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십.</p>

                        <p><img src="http://content.ebstoon.com/assets/data/shop/body/d30a3a7ea2de5c5e991863d9d7a96004.jpg"><br></p><p><br></p>

                        <p>세미와 매직큐브 피규어는 일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십.</p>

                        <p><img src="http://content.ebstoon.com/assets/data/shop/body/cd1b9511a9a2addfe29aac0573bfb959.jpg"><br></p><p><br></p>


                        <p>세미와 매직큐브 피규어는 일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십일이삼사오육칠팔구십.</p>


                        <div class="title">
                            <h2>상품정보</h2>
                        </div>

                        <div class="info_table">
                            <table>
                                <colgroup>
                                    <col style="width:40%">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th>품명 및 모델명</th>
                                    <td>세미 피규어</td>
                                </tr>
                                <tr>
                                    <th>크기</th>
                                    <td>W 92× H81 × D65mm, 10g</td>
                                </tr>
                                <tr>
                                    <th>제조사</th>
                                    <td>제조자 표기</td>
                                </tr>
                                <tr>
                                    <th>제조국 또는 원산지</th>
                                    <td>한국</td>
                                </tr>
                                <tr>
                                    <th>품질보증기간</th>
                                    <td>본 제품은 공정거래위원회 고시 소비자 분쟁해결기준에 의거 교환 및 보상을 받으실 수 있습니다.</td>
                                </tr>
                                <tr>
                                    <th>A/S  책임자와 전화번호</th>
                                    <td>아아나무 고객 행복 센터 1000-1000</td>
                                </tr>
                                <tr>
                                    <th>구매 전 확인사항</th>
                                    <td>만 3세 미만은 사용할 수 없습니다. 본 제품은 특성상 고객 부주의로 인한 파손, 단순 변심으로 인한 교환 및 환불이 불가합니다.</td>
                                </tr>
                                <tr>
                                    <th>취급 시 주의사항</th>
                                    <td>용도 이외에는 사용하지 마시고 유아, 소아의 손에 닿지 않는 곳에 놓아주세요.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </textarea>
        </div>
        <button type="button" name="reg" id="reg" class="btn btn-primary btn-lg btn-block" style="width:800px;">등록</button>
    </form>
</div>
    <script type="text/javascript">
        var oEditors = [];
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "ir1",
            sSkinURI: "/assets/CMS/addon/smart_editor/SmartEditor2Skin.html",
            htParams : {bUseToolbar : true,
                fOnBeforeUnload : function(){
                    //alert("아싸!");
                }
            }, //boolean
            fOnAppLoad : function(){
                //예제 코드
                //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
            },
            fCreator: "createSEditor2"
        });

        function pasteHTML(content) {
            var sHTML = content;
            alert(sHTML);
            oEditors.getById["ir1"].exec("PASTE_HTML", [sHTML]);
        }

        function showHTML() {
            var sHTML = oEditors.getById["ir1"].getIR();
            alert(sHTML);
        }

        function submitContents(elClickedObj) {
            if($('#pName').val()=='') {
                alert("상품명을 등록하세요.");
            }else if($('#main_thumb').val()=='') {
                alert("메인 상품 이미지를 등록하세요.");
            }else if(!$('#ccategory').val()){
                alert('상품 카테고리를 선택하세요.');
            }else if($('#cCode').val()==''){
                alert('상품 업체를 선택하세요.');
            }else if($('#price').val()==''){
                alert('상품 가격을 선택하세요.');
            }else if($('#cCode').val()=='') {
                alert('상품 업체를 선택하세요.');
            }else if(oEditors.getById["ir1"].getIR() == ""){
                alert ("내용을 입력해주세요.");
            } else if(confirm("등록하시겠습니까?")==true) {
                oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.

                // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

                try {
                    elClickedObj.form.submit();
                } catch (e) {
                }
            }
        }

        function setDefaultFont() {
            var sDefaultFont = '궁서';
            var nFontSize = 24;
            oEditors.getById["ir1"].setDefaultFont(sDefaultFont, nFontSize);
        }
    </script>

    <script>

        $(document).ready(function() {
            $('#reg').click(function(){
                submitContents(this);
            });

            $("#pCode1").attr("disabled", "disabled");
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
                url: "<?echo(SHOP_ROOT_URL);?>Category/GetCategory",
                async: false,
                data:{ type : typ ,code : sParam },
                dataType: "json",
                success: function(jdata){
                    if(jdata.length==0){
                        $target.append("<option value=''>선택하세요.</option>");
                    }else{
                        $target.append("<option value=''>선택하세요.</option>");
                        $(jdata).each(function(i){
                            $target.append("<option value='"  + jdata[i].Code + "'>" + jdata[i].Name + "</option>");
                        })
                    }
                }
            })
        }

        function go_list(id){
            window.location.href = "/TMS/Board/BList/" + id;
        }

        function go_View(fname){
            window.open(fname);
        }
    </script>