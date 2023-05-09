<div style="width:800px;padding-left: 100px;padding-bottom: 100px;">
    <script>
        <?if($bType<=0){?>
        $(document).ready(function() {
            $('#reg').click(function(){
                if($('#title').val()=='') {
                    alert('제목을 입력하세요.');
                    $('#title').focus();
                } else if($('#org_writer').val()==''){
                    alert('작성자를 입력하세요');
                    $('#org_writer').focus();
                } else if(confirm("등록하시겠습니까?")==true){
                    $("#reg_board").submit();
                }
            });
        });
        <?}else{?>
        $(document).ready(function() {
            $('#reg').click(function(){
                if($('#title').val()=='') {
                    alert('제목을 입력하세요.');
                    $('#title').focus();
                }else if($('#thumb').val()=='') {
                    alert('썸네일을 선택하세요.');
                }else if(confirm("등록하시겠습니까?")==true){
                    $("#reg_board").submit();
                }
            });
        });
        <?}?>
    </script>
    <form action="<?echo(ROOT_URL);?>Board/Reg_Board" method="post" name="reg_board" id="reg_board" enctype="multipart/form-data" >
        <input type="hidden" name="userid" id="userid" value="<?echo($userid);?>" />
        <input type="hidden" name="bid" id="bid" value="<?echo($bid);?>" />
        <input type="hidden" name="bType" id="bType" value="<?echo($bType);?>" />
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?echo($bname);?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="form-group">
            <label>제목</label>
            <input class="form-control" name="title" id="title" placeholder="제목" />
        </div>
        <div class="form-group">
            <label>작성자</label>
            <input class="form-control" name="writer" id="writer" placeholder="작성자" />
        </div>
        <div class="form-group">
            <label> 본문 이미지 파일 용량은 2M byte 이하로 제한이있습니다.</label>
        </div>
        <div class="form-group"  align="center">
            <textarea class="form-control"  name="description" id="description" placeholder="본문" rows="35"></textarea>
        </div>
        <button type="button" name="reg" id="reg" class="btn btn-primary btn-lg btn-block">등록</button>
    </form>
    <script src="<?echo(ASSETS_ROOT);?>/addon/ckeditor/ckeditor.js"> </script>
    <script>
        CKEDITOR.config.height = 400;
        CKEDITOR.config.contentsCss = "<?echo(ASSETS_ROOT);?>/css/style.css";
        CKEDITOR.config.extraPlugins = 'justify,image2,font,colorbutton';
        CKEDITOR.replace('description',{
            'filebrowserUploadUrl' : '<?echo(ROOT_URL);?>Board/CkEdit_upload',
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
</div>
