$(document).ready(function() {


});

function popupOpen(popUrl,width,height,top,left){
    var popOption = "width=" + width + ", height=" + height + ",top=" + top + ",left=" + left + ", resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
    window.open(popUrl,"",popOption);
}


function Process_Step(cid,mtyp){
	if(confirm('강제검수처리 하시겠습니까?')==true){
		$.ajax({
			type:"POST",
			url:"/Counsel/Process_Step",
			dataType:"json",
			data : { "mtyp" : mtyp , "cid" : cid},
			success : function(data) {
				if(data.result == 'ok'){
					if(data.status=='7'){
						var inhtml = '<button class="btn btn-default" onclick="Process_Step2(' + cid + ',6);">검수완료처리</button>';
						$('#etype' + cid).html(inhtml);
						$('#status' + cid).html('EBS 재감수진행');
					}else {
						if (mtyp == 0) {
							var inhtml = '<button class="btn btn-default" onclick="Process_Step2(' + cid + ',3);">검수완료처리</button>';
							$('#gtype' + cid).html(inhtml);
							$('#status' + cid).html('자문위원 감수진행');
						} else if (mtyp == 1) {
							var inhtml = '<button class="btn btn-default" onclick="Process_Step2(' + cid + ',6);">검수완료처리</button>';
							$('#etype' + cid).html(inhtml);
							$('#status' + cid).html('EBS 감수 진행');
						}
					}
				}else{
					alert('통신에러 Error(101)');
				}
			},
			error : function(xhr, status, error) {
				alert("에러발생");
			}
		});
	}
}

function Process_Step2(cid,step){
	if(confirm('검수완료처리 하시겠습니까?')==true){
		$.ajax({
			type:"POST",
			url:"/Counsel/Process_Step2",
			dataType:"json",
			data : { "step" : step , "cid" : cid},
			success : function(data) {
				if(data.result == 'ok'){
					if(step==3){
						var inhtml = '<button class="btn btn-default" onclick="Process_Step3(' + cid + ',4);">EBS 감수요청</button>';
						$('#gtype' + cid).html(inhtml);
						$('#status' + cid).html('자문위원 감수완료');
					}else if(step==6) {
						$('#etype' + cid).html('');
						var inhtml = '<button class="btn btn-default" onclick="Process_Step4(' + cid + ');">오픈대기처리</button><button class="btn btn-default" onclick="Process_Step5(' + cid + ');">재감수 요청</button>';
						$('#itype' + cid).html(inhtml);
						$('#status' + cid).html('EBS 감수완료');
					}else if(step==9) {
						$('#etype' + cid).html('');
						var inhtml = '<button class="btn btn-default" onclick="Process_Step4(' + cid + ');">오픈대기처리</button><button class="btn btn-default" onclick="Process_Step5(' + cid + ');">재감수 요청</button>';
						$('#itype' + cid).html(inhtml);
						$('#status' + cid).html('EBS 재감수완료');
					}
				}else{
					alert('통신에러 Error(101)');
				}
			},
			error : function(xhr, status, error) {
				alert("에러발생");
			}
		});
	}
}

function Process_Step3(cid,step){
	if(confirm('EBS 감수요청 하시겠습니까?')==true){
		$.ajax({
			type:"POST",
			url:"/Counsel/Process_Step2",
			dataType:"json",
			data : { "step" : step , "cid" : cid},
			success : function(data) {
				if(data.result == 'ok'){
					$('#gtype' + cid).html('');
					var inhtml = '<button class="btn btn-default" onclick="Process_Step(' + cid + ',1);">강제검수처리</button>';
					$('#etype' + cid).html(inhtml);
					$('#status' + cid).html('EBS 감수요청');
				}else{
					alert('통신에러 Error(101)');
				}
			},
			error : function(xhr, status, error) {
				alert("에러발생");
			}
		});
	}
}


function Process_Step4(cid){
	if(confirm('오픈 대기 처리 하시겠습니까?')==true){
		$.ajax({
			type:"POST",
			url:"/Counsel/Process_Step3",
			dataType:"json",
			data : {"cid" : cid},
			success : function(data) {
				if(data.result == 'ok'){
					$('#gtype' + cid).html('');
					$('#etype' + cid).html('');
					$('#itype' + cid).html('');
					$('#status' + cid).html('오픈 대기');
				}else{
					alert('통신에러 Error(101)');
				}
			},
			error : function(xhr, status, error) {
				alert("에러발생");
			}
		});
	}
}

function Process_Step5(cid){
	if(confirm('재감수 요청 하시겠습니까?')==true){
		$.ajax({
			type:"POST",
			url:"/Counsel/Process_Step4",
			dataType:"json",
			data : {"cid" : cid},
			success : function(data) {
				if(data.result == 'ok'){
					$('#gtype' + cid).html('');
					var inhtml = '<button class="btn btn-default" onclick="Process_Step6(' + cid + ',1);">강제검수처리</button>';
					$('#etype' + cid).html(inhtml);
					$('#itype' + cid).html('');
					$('#status' + cid).html('EBS 재감수요청');
				}else{
					alert('통신에러 Error(101)');
				}
			},
			error : function(xhr, status, error) {
				alert("에러발생");
			}
		});
	}
}


function Process_Step6(cid,mtyp){
	if(confirm('강제검수처리 하시겠습니까?')==true){
		$.ajax({
			type:"POST",
			url:"/Counsel/Process_Step",
			dataType:"json",
			data : { "mtyp" : mtyp , "cid" : cid},
			success : function(data) {
				if(data.result == 'ok'){
					var inhtml = '<button class="btn btn-default" onclick="Process_Step2(' + cid + ',9);">검수완료처리</button>';
					$('#etype' + cid).html(inhtml);
					$('#status' + cid).html('EBS 재감수진행');
				}else{
					alert('통신에러 Error(101)');
				}
			},
			error : function(xhr, status, error) {
				alert("에러발생");
			}
		});
	}
}


function Process_Del(cid){
	if(confirm('삭제 하시겠습니까?')==true){
		$.ajax({
			type:"POST",
			url:"/Counsel/Process_Del",
			dataType:"json",
			data : { "cid" : cid},
			success : function(data) {
				if(data.result == 'ok'){
					location.reload();
				}else if(data.result == 'error1'){
					alert('존재하지 않는 감수번호 입니다.');
				}else if(data.result == 'error2'){
					alert('감수 삭제는 자문위원 감수요청 단계에서만 가능합니다.');
				}
			},
			error : function(xhr, status, error) {
				alert("에러발생");
			}
		});
	}
}



function Mod_All(){
	if(confirm('적용하시겠습니까?')==true){
		$('#writeForm').submit();
	}
}

function Reset_Com(cid,sn){
	if(confirm('해당 강제처리를 취소하시겠습니까?')==true){
		$(location).attr('href','/Counsel/Reset_Com/' + cid + '/' +  sn);
	}
}


function txtCls(){
	var Form = document.Search;
	if( Form.sword.value == '아이나무툰'){
		Form.sword.value = '';
		Form.sword.focus();
	}
}

function txtOrg(){
	var Form = document.Search;
	if(Form.sword.value ==''){
		Form.sword.value ='아이나무툰';
	}
	
}


function go_Search(){
	var Form = document.Search;
	
	if(Form.sword.value==''){
		window.alert("검색 단어를 입력하세요.");
		Form.sword.focus();
	}else{
		Form.submit();
	}
}


