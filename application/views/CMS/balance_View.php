<script>
    $(function(){
        $("#list").jqGrid({
            mtype:"POST",
            url: '<?echo(ROOT_URL);?>Pay/balance_Data_Load/',
            datatype: "json",
            loadonce: false,
            colNames:['uid','아이디','coin','free_coin'],
            height: 250,
            colModel:[
                {name:'uid', width:20,index:'sn', align: 'center', editable: false},
                {name:'userid', width:100,index:'userid', align: 'center', editable: false},
                {name:'cash',index:'cash', width:100,align: 'center', editable: false},
                {name:'mCash',index:'mCash',width:100, align: 'center', editable: false}
            ],
            rowNum: 40,
            rowTotal: 10000,
            rowList: [20, 40, 60],
            pager: 'pager',
            toppager: true,
            cloneToTop: true,
            sortname: 'cash',
            viewrecords: true,
            sortorder: 'desc',
            multiselect: false,
            caption: "",
            autowidth: true,
            shrinkToFit: true,
            height: 600,
            emptyrecords: '자료가 없습니다.'
        });
        $("#list").jqGrid('navGrid', '#pager', {
            cloneToTop:true,
            add:false,
            edit:false,
            view: false,
            search:false,
            refresh:false,
            del:false,
            excel:true
        },{},{},{},{
            sopt: ['eq']
        });

        $(window).bind('resize', function () {
            var width = $('.jqGrid_wrapper').width();
            $('#list').setGridWidth(width);
        });
    });

</script>
<style>
    .table-responsive {
        overflow-x: visible;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">미결제 잔액 리스트</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="form-group">
        <table>
            <tr>
                <td  align="left" width="100%">총잔액 : <?echo(number_format($sum));?>캐시</td>
            </tr>
        </table>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" style="min-width:600px">
                <div class="jqGrid_wrapper">
                    <table id='list'></table>
                    <div id="pager"></div>
                </div>
            </div>
        </div>
    </div>
</div>
