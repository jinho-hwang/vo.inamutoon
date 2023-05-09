<body>
<div id="main-container">
    <h1>관리자 권한 설정</h1>
    <div id="tree-container"></div>
</div>
<script>
    var mockData = [];
    <?for($i=1;$i<=ArrayCount($menu);$i++){?>
    mockData.push(<?echo($menu['menutree'.$i]);?>});
    <?}?>

    $('#tree-container').highCheckTree({
        data: mockData
    });

    function getCheckedItems() {
        var chkitem1 = '';
        var chkitem2 = '';
        $.each(mockData, function( index1, value1 ) {
            //alert(JSON.stringify(value1));
            $.each(value1.children, function( index, value2 ) {
                var val = value2.item.value;
                if(value2.item.checked){
                    chkitem1 += val + '||';
                }else{
                    chkitem2 += val + '||';
                }
            });
        });

        $.ajax({
            type:"POST",
            url:"/AMember/Auth_Modify",
            dataType:"json",
            data : { "wid" : <?echo($wid);?> , "item1" : chkitem1,"item2" : chkitem2},
            success : function(data) {
                if(data.result == 'ok'){
                    alert('success');
                    location.reload();
                }else{
                    alert('통신에러 Error(101)');
                }
            },
            error : function(xhr, status, error) {
                alert("에러발생");
            }
        });
    }
</script>
<br><br>
<button type="button" name="restart" id="restart" class="btn btn-primary btn-lg btn-block" style="width:400px;margin: auto;" onclick="getCheckedItems();">권한 수정</button><br>

</body>































