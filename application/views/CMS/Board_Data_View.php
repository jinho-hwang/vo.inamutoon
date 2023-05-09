<div style="width:800px;padding-left: 100px;padding-bottom: 100px;">
<script>

    $(document).ready(function() {
        $('#mod').click(function(){
            //alert('a' +$('#description').val() );
            if($('#title').val()=='') {
                alert("제목을 입력하세요.");
                $('#title').focus();
            }else if($('#org_writer').val()==''){
                alert('작성자를 입력하세요');
                $('#org_writer').focus();
            }else if(confirm("수정하시겠습니까?")==true){
                $("#mod_board").submit();
            }
        });

        $('#del').click(function(){
           if(confirm("삭제 하시겠습니까?")== true){
               window.location.href = "/Board/Del_Board/<?echo($data[0]['bcode']);?>";
           }
        });
    });

    function go_list(id){
        window.location.href = "/Board/BList/" + id;
    }

    function go_View(fname){
        window.open(fname);
    }
</script>

<form action="/Board/Mod_Board" method="post" name="mod_board" id="mod_board" enctype="multipart/form-data" >
    <input type="hidden" name="bid" id="bid" value="<?echo($data[0]['bid']);?>" />
    <input type="hidden" name="bcode" id="bcode" value="<?echo($data[0]['bcode']);?>" />

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?echo($env[0]['bname']);?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="form-group">
        <label>제목</label>
       <input class="form-control" name="title" id="title" value="<?echo($data[0]['bTitle']);?>" />
    </div>
    <?if($data[0]['bid'] != 4) {?>
    <div class="form-group">
        <label>열람수</label>
        <input class="form-control" name="bHit" id="bHit" value="<?echo($data[0]['bHit']);?>" />
    </div>
    <?}?>
<div class="form-group">
        <label>작성자</label>
        <input class="form-control" name="writer" id=writer" placeholder="작성자" value="<?echo($data[0]['writer']);?>" />
    </div>
    <div class="form-group">
        <label> 본문 이미지 파일 용량은 2M byte 이하로 제한이있습니다.</label>
    </div>
    <div class="form-group">
        <textarea class="form-control"  name="description" id="description" placeholder="본문"  ><?echo($data[0]['bContent']);?></textarea>
    </div>
    <button type="button" name="mod" id="mod" class="btn btn-primary btn-lg btn-block">수정</button>
    <button type="button" name="del" id="del" class="btn btn-primary btn-lg btn-block">삭제</button>
</form>
    <script src="<?echo(ASSETS_ROOT);?>/addon/ckeditor/ckeditor.js"> </script>
    <script>
        CKEDITOR.config.height = 400;
        //CKEDITOR.config.contentsCss = "<?echo(ASSETS_ROOT);?>/css/style.css";
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