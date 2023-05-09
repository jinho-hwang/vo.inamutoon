<script>
    function reg_win(){
        popupOpen('<?echo(WEB_URL);?>/Category/CGroup_Reg');
    }

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
            url: "<?echo(WEB_URL);?>/Category/GetCategory",
            async: false,
            data:{ type : typ ,code : sParam },
            dataType: "json",
            success: function(jdata){
                if(jdata.length==0){
                    $target.html();
                    $target.append("<option value=''>선택하세요.</option>");
                }else{
                    $target.html();
                    $target.append("<option value=''>선택하세요.</option>");
                    $(jdata).each(function(i){
                        $target.append("<option value='"  + jdata[i].Code + "'>" + jdata[i].Name + "</option>");
                    })
                }
            }
        })
    }

    $(document).ready(function() {
        $('#reg').click(function(){
           if($("#acategory option:selected").val()=='선택하세요'){
               alert('대카테고리를 선택하세요.');
           }else if($("#bcategory option:selected").val()=='선택하세요'){
               alert('중카테고리를 선택하세요.');
           }else if($('#cname').val()==''){
               alert('소카테고리 이름을 입력하세요.');
           }else if(confirm('등록하시겠습니까?')==true){
               $('#reg1').submit();
           }
        });
    });

</script>

<style>
    body {margin-left:30px;margin-bottom:30px;}
</style>
<div style="width:400px;">

    <form name="reg1" id="reg1" method="post" action="<?echo(WEB_URL);?>/Category/CData_Add">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">소카테고리 등록</h1>
                <div align="left">대카테고리 : <select name="acategory" id="acategory" onchange="fnGetCtgSub(1,this.value)"><?echo($select_box);?></select> 중카테고리 : <select name="bcategory" id="bcategory"></select><br>소카테고리 이름 : <input type="text" name="cname" id="cname" style="width:100px;"/> 사용여부 : <select name="isUse" id="isUse"><option value="0">사용안함</option><option value="1">사용</option></select></div><br>
                <button type="button" name="reg" id="reg" class="btn btn-primary btn-lg btn-block" style="width:400px;">등록</button>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </form>
</div>


