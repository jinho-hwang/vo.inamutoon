 $(function(){
        $('.more').live("click",function(){
            var ID = $(this).attr("id");
            if(ID=='endPage'){
                $(".morebox").html('끝');// no results
            }else{
                var NextID = (Number(ID)+1);
                $("#more"+ID).html('<img src="/assets/old/images/loading.gif" widt="70" height="70"/>');
                $.ajax({
                    type: "POST",
                    url: "/Web/Board/More/" + NextID,
                    cache: false,
                    success: function(html){
                        $("tbody#updates").append(html);
                        $("#more"+ID).remove(); // removing old more button
                    }
                });
            }
            return false;
        });
    });