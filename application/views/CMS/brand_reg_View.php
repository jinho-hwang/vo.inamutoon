<style>
    body {
        font-family: 나눔바른고딕, NanumBarunGothic, 맑은고딕, "Malgun Gothic", 돋움, Dotum, "Apple SD Gothic Neo", sans-serif;
        font-size: 13px;
        color: rgb(33, 33, 33);
        letter-spacing: 0.03em;
    }
    .input {
        width:200px;
        text-indent: 5px;
        height: auto;  /* 높이값 초기화 */
        line-height : normal; /* line-height 초기화 */
        padding: .2em .3em; /* 상하 우좌 */
        font-family: inherit; /* 폰트 상속 */
        border: 1px solid #ccc; /* 999가 약간 더 진한 색 */
        margin-bottom:5px;
        font-size:12pt;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
    }

    .select {
        width:200px;
        text-indent: 5px;
        height: auto;  /* 높이값 초기화 */
        line-height : normal; /* line-height 초기화 */
        padding: .2em .3em; /* 상하 우좌 */
        font-family: inherit; /* 폰트 상속 */
        border: 1px solid #ccc; /* 999가 약간 더 진한 색 */
        margin-bottom:5px;
        font-size:12pt;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
    }

    .button {
        background-color:#E9C28B;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer
    }
    .title {
        font-family:inherit; /* 폰트 상속 */
        font-size: 13pt;
        color:black;
    }

    .td1 {
        width:160px;
        font-weight:bold;
        color:#444444;
        text-align : center;
        padding:5px 0 5px 0;
        letter-spacing:2px; /* 글자간 간격 */
    }

    .td2 {
        width:60px;
        height:60px;
        font-size:24px;
        font-weight: bold;
        font-weight:bold;
        color:#444444;
        text-align : center;
        padding:5px 0 5px 0;
        letter-spacing:2px; /* 글자간 간격 */
    }

</style>
<script>
    $(document).ready(function(){
        var maxField = 10; //최대 개수
        var wrapper = $('.append');
        var wrapper1 = $('.append2');
        var extcnt = 1; // 최초 카운트 1
        var extcnt2 = 1; // 최초 카운트 1
        var fieldHTML = '<div><select name="toon[]" id="toon[]" class="select"><?echo($writer);?></select> <a href="javascript://" class="remove_btn"><img src="/assets/img/remove-icon.png"/></a></div>';
        var fieldHTML2 = '<div><select name="md[]" id="md[]" class="select"><?echo($company);?></select> <a href="javascript://" class="remove_btn2"><img src="/assets/img/remove-icon.png"/></a></div>';
        $('.add_btn').click(function(){
            if(extcnt < maxField){
                extcnt++; // 숫자 증가
                $('.append').append(fieldHTML); // Add field
                $('#extcount').html("(" + extcnt + "개)");
            }
        });
        $(wrapper).on('click', '.remove_btn', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); // Remove field
            extcnt--; // 카운트 감소
            $('#extcount').html("(" + extcnt + "개)");
        });


        $('.add_btn2').click(function(){
            if(extcnt2 < maxField){
                extcnt2++; // 숫자 증가
                $('.append2').append(fieldHTML2); // Add field
                $('#extcount2').html("(" + extcnt2 + "개)");
            }
        });

        $(wrapper1).on('click', '.remove_btn2', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); // Remove field
            extcnt2--; // 카운트 감소
            $('#extcount2').html("(" + extcnt + "개)");
        });

        $('#reg').click (function () {
            var code = '';
            $.ajax({
                type: "POST",
                url: "/Brand/Data_Reg",
                dataType: "JSON",
                async: false,
                data: $('#writeForm').serialize(),
                success: function (data) {
                    if(data.result=='ok'){
                        code = data.code;
                    }
                },
                error : function( jqXHR, textStatus, errorThrown ) {
                    //alert( '통신장애');
                }
            });

            if(code!=''){
                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_brand_img2/',
                    secureuri: false,
                    fileElementId:'imgname1',
                    dataType: 'json',
                    async: false,
                    iframe: true,
                    data : {sn : code,key:'imgname1',typ:1},
                    success: function(data, status) {
                        if (data.result == true) {
                            //alert('success');
                        }else if (data.result == false) {
                            //alert(data.message);
                        }
                    },
                    error: function(data, status, e) {
                        //alert(e);
                        //opener.location.reload()
                    }
                });

                $.ajaxFileUpload({
                    url: '<?echo(CONTENT_ROOT);?>/Cartoon/upload_brand_img2/',
                    secureuri: false,
                    fileElementId:'imgname2',
                    dataType: 'json',
                    async: false,
                    iframe: true,
                    data : {sn : code,key:'imgname2',typ:2},
                    success: function(data, status) {
                        if (data.result == true) {
                            //alert('success');
                        }else if (data.result == false) {
                            //alert(data.message);
                        }
                    },
                    error: function(data, status, e) {
                        //alert(e);
                        //opener.location.reload()
                    }
                });
            }

            setTimeout(function() {
                alert('success');
                opener.location.reload()
                self.close();
            }, 2000);
        });

    });
</script>

<form name="writeForm" id="writeForm" method='post' enctype="multipart/form-data" >
    <input type="hidden" name"fname" id="fname" />
    <table class="table table-bordered">
        <tr>
            <td class="td2" colspan="2">브랜드 등록</td>
        </tr>
        <tr>
            <td class="td1">브랜드 명</td>
            <td><input type="text" name="btitle" id="btitle" class="input" /></td>
        </tr>
        <tr>
            <td class="td1">브랜드 설명</td>
            <td><textarea name="bcontent" id="bcontent" rows="5" class="input"></textarea></td>
        </tr>
        <tr>
            <td class="td1">소속 작가</td>
            <td>
                <select name="toon[]" id="toon[]" class="select"><?echo($writer);?></select>
                <span id="extcount" style="color: #000000;font: 10px verdana,dotum;">(1개)</span>
                <a href="javascript://" class="add_btn"><img src="/assets/img/add-icon.png"/></a>
                <div class="append"></div>
            </td>
        </tr>
        <tr>
            <td class="td1">소속 업체</td>
            <td>
                <select name="md[]" id="md[]" class="select"><?echo($company);?></select>
                <span id="extcount2" style="color: #000000;font: 10px verdana,dotum;">(1개)</span>
                <a href="javascript://" class="add_btn2"><img src="/assets/img/add-icon.png"/></a>
                <div class="append2"></div>
            </td>
        </tr>
        <tr>
            <td class="td1">브랜드 PC이미지</td>
            <td><input type="file" id="imgname1" name="imgname1" /></td>
        </tr>
        <tr>
            <td class="td1">브랜드 M이미지</td>
            <td><input type="file" id="imgname2" name="imgname2" /></td>
        </tr>
    </table>
</form>

</body>


<button type="button" name="reg" id="reg" class="btn btn-primary btn-lg btn-block" style="width:400px;margin: auto;">등록</button>
</form>
</body>


