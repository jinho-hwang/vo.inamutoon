<script type="text/javascript" src="<?echo(ASSETS_ROOT);?>/addon/smart_editor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script>
    function pImgDelete(val1,val2){
        if(val2==1){
            alert('메인 상품 이미지는 삭제 할수 없습니다.');
        }else if(confirm('상품이미지를 삭제하시겠습니까?')==true){
            var url = "/Shop/Product/PImageDelete/" + val1 + '/' + val2;
            $(location).attr('href',url);
        }
    }

</script>
<style>
    body {margin-left:30px;margin-bottom:30px;}
</style>
<div style="width:800px;">
    <form action="<?echo(SHOP_ROOT_URL);?>Product/Mod_Data" method="post" name="reg_board" id="reg_board" enctype="multipart/form-data" >
        <input type="hidden" name="pCode" id="pCode" value="<?echo($product[0]['pCode']);?>" />
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">상품등록</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="form-group">
            <label>상품코드</label>
            <input class="form-control" name="pCode1" id="pCode1" value="<?echo($product[0]['pCode']);?>" style="width:400px;text-align:left;" />
        </div>
        <div class="form-group">
            <label>상품명</label>
            <input class="form-control" name="pName" id="pName" style="width:400px;text-align:left;" value="<?echo($product[0]['pName']);?>"/>
        </div>
        <div class="form-group">
            <label>판매유무</label>
            <select name="isUse" id="isUse">
                <?if($product[0]['isUse']==0){?>
                    <option value="0" selected>미판매중</option>
                    <option value="1">판매중</option>
                <?}else{?>
                    <option value="0">미판매중</option>
                    <option value="1" selected>판매중</option>
                <?}?>
            </select>
        </div>
        <div class="form-group">
            <label>추천유무</label>
            <select name="recom" id="recom">
                <?if($product[0]['recom']==0){?>
                    <option value="0" selected>미추천</option>
                    <option value="1">추천</option>
                <?}else{?>
                    <option value="0">미추천</option>
                    <option value="1" selected>추천</option>
                <?}?>
            </select>
        </div>
        <div class="form-group">
            <table border="0">
                <colgroup>
                    <col style="width:100px;">
                    <col style="width:200px">
                </colgroup>
                <tbody>
                <?if(ArrayCount($img) > 0){?>
                    <?foreach($img as $d){?>
                        <tr>
                            <?if($d['typ']==1){?>
                                <td>상품이미지-메인<input type="file" id="main_thumb<?echo($d['typ']);?>" name="main_thumb<?echo($d['typ']);?>"></td>
                            <?}else{?>
                                <td>상품이미지-<?echo($d['typ']);?><input type="file" id="main_thumb<?echo($d['typ']);?>" name="main_thumb<?echo($d['typ']);?>"></td>
                            <?}?>
                            <?if(!empty($d['img'])){?>
                                <td><img src="<?echo(CONTENT_ASSETSROOT.'/data/shop/top/'.$d['img']);?>" style="width:100px;height:100px;"/></td>
                                <td><input type="button" value="삭제" onclick="pImgDelete('<?echo($d['pCode']);?>','<?echo($d['typ']);?>');" /></td>
                            <?}else{?>
                                <td>&nbsp;</td>
                            <?}?>
                            </td>
                        </tr>
                    <?}?>
                <?}?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <label>카테고리</label>
            <select name="acategory" id="acategory" onchange="fnGetCtgSub(1,this.value)"><?echo($Acate);?></select>&nbsp;<select name="bcategory" id="bcategory" onchange="fnGetCtgSub(2,this.value)"><?echo($Bcate);?></select>&nbsp;<select name="ccategory" id="ccategory"><?echo($Ccate);?></select>
        </div>
        <div class="form-group">
            <label>업체</label>
            <select name="cCode" id="cCode">
                <?echo($com);?>
            </select>
        </div>
        <?if(ArrayCount($option)){?>
            <?$i=1;?>
            <?for($mm=0;$mm<5;$mm++){?>
                <div class="form-group">
                    <label>옵션<?echo($i);?></label>
                    <input class="form-control" name="option<?echo($i);?>" id="option<?echo($i);?>" style="width:400px;text-align:right;" value="<?echo($option[0]['option'.$i]);?>"/>
                </div>
                <?$i++;?>
            <?}?>
        <?}?>
        <div class="form-group">
            <label>가격</label>
            <input class="form-control" name="price" id="price" onchange="getNumber(this);" onkeyup="getNumber(this);" style="width:400px;text-align:right;" value="<?echo($product[0]['price']);?>"/>
        </div>
        <div class="form-group">
            <label>할인</label>
            <input class="form-control" name="sale" id="sale"   onchange="getNumber(this);" onkeyup="getNumber(this);" style="width:400px;text-align:right;" value="<?echo($product[0]['sale']);?>"/>
        </div>
        <div class="form-group">
            <label>포인트</label>
            <input class="form-control" name="point" id="point"  onchange="getNumber(this);" onkeyup="getNumber(this);" style="width:400px;text-align:right;" value="<?echo($product[0]['point']);?>"/>
        </div>
        <div class="form-group">
            <label> 본문 이미지 파일 용량은 2M byte 이하로 제한이있습니다.</label>
        </div>
        <div class="form-group"  align="center">
            <textarea class="form-control"  name="description" id="description" placeholder="본문"  >
                <?echo($product[0]['explain']);?>
            </textarea>
        </div>
        <button type="button" name="reg" id="reg" class="btn btn-primary btn-lg btn-block" style="width:800px;">수정</button>
    </form>
</div>
<script src="<?echo(ASSETS_ROOT);?>/lib/ckeditor/ckeditor.js"> </script>
<script>
    CKEDITOR.config.height = 400;
    CKEDITOR.config.contentsCss = "/assets/CMS/css/mlayout.css?rnd=<?echo(rand());?>";
    CKEDITOR.config.extraPlugins = 'justify,image2,font,colorbutton';
    CKEDITOR.replace('description',{
        'filebrowserUploadUrl' : '/Shop/Product/CkEdit_upload',
        enterMode:'2',
        shiftEnterMode:'3',
        toolbar:
            [
                ['Font','FontSize','Styles','Format'],
                ['TextColor','BGColor'],
                ['Source','-','Save','NewPage','Preview','-','Templates'],
                ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
                '/',
                ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
                ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                ['Link','Unlink','Anchor'],
                ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
                ['Maximize', 'ShowBlocks','-','About']
            ]
    });
</script>



<script type="text/javascript">

    function submitContents(elClickedObj) {
        if($('#pName').val()=='') {
            alert("상품명을 등록하세요.");
        }else if(!$('#ccategory').val()){
            alert('상품 카테고리를 선택하세요.');
        }else if($('#cCode').val()==''){
            alert('상품 업체를 선택하세요.');
        }else if($('#price').val()==''){
            alert('상품 가격을 선택하세요.');
        }else if($('#cCode').val()=='') {
            alert('상품 업체를 선택하세요.');
        } else if(confirm("수정하시겠습니까?")==true) {
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