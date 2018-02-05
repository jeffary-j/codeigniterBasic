//<![CDATA[
 /**
  * 글등록 체크
  * @return
  */
//<![CDATA[

$(document).ready(function() {
		
	$("#postUpdat").click(function(){
		if (temp_p_update() !== true) return false;
	});
});


function fuck_check(str){ // 욕 필터링 , 스크립트 아이프레임도 필터링
    
    if(!str || str == undefined || str == null || str == '') return true;

    var FuckList = new Array('개새끼','개색기','개색끼','개자식','개보지','개자지','개년','개걸래','개걸레','씨발','씨팔','씨부랄','씨바랄','씹창','씹탱','씹보지','씹자지','씨방세','씨방새','씨펄','시펄','십탱','씨박','썅','쌍놈','쌍넘','싸가지','쓰벌','씁얼','상넘이','상놈의','상놈이','상놈을','좆','좃','존나게','존만한','같은년','넣을년','버릴년','부랄년','바랄년','미친년','니기미','니미씹','니미씨','니미럴','니미랄','호로','후레아들','호로새끼','후레자식','후래자식','후라들년','후라들넘','빠구리','병신','섹스','fuck');
    var Tmp;
    for(i=0 ; i<FuckList.length ; i++){
        Tmp = str.toLowerCase().indexOf(FuckList[i]);
        if(Tmp >= 0){
            return false;
        }
    }
}
function category_check(){

	var chk = document.getElementsByName("category[]"); // 체크박스객체를 담는다
	var len = chk.length;    //체크박스의 전체 개수
	var checkCnt = 0;        //체크된 체크박스의 개수

	for(var i=0; i<len; i++){
		if(chk[i].checked){
			checkCnt++;        //체크된 체크박스의 개수
		}
	}
	if(checkCnt >= 1){
		return true;
	}
	return false;
} 

function old_category_info(){
	var chk = document.getElementsByName("category[]"); // 체크박스객체를 담는다
	var len = chk.length;    //체크박스의 전체 개수
	var checkCnt = 0;
	var checkRow = '';      //체크된 체크박스의 value를 담기위한 변수
	var checkLast = '';      //체크된 체크박스 중 마지막 체크박스의 인덱스를 담기위한 변수	
	var row = '';             //체크된 체크박스의 모든 value 값을 담는다
                
	for(var i=0; i<len; i++){
		if(chk[i].checked){
			checkCnt++;        //체크된 체크박스의 개수
			checkLast = i;     //체크된 체크박스의 인덱스
		}
	}	
	
	for(var i=0; i<len; i++){
		if(chk[i].checked == true){
			checkRow = chk[i].value;
		}
		if(checkCnt == 1){
			row += checkRow;
		}else{
			if(i == checkLast){
				row += checkRow;
			}else{
				row += checkRow+",";
			}
		}
		checkRow = '';    //checkRow초기화.
	}
	return row;
}

function check_post_register() {

	var check_file = $("input[name=photo]").val();
	if(!check_file){
		$('input[name=photo]').focus();
		alert('이미지를 등록해주세요.');
		return false;
	}
	
	if(fuck_check($('#contents').val()) === false){
		$('#contents').focus();
	    alert('내용에 욕설을 입력 하실 수 없습니다.');
	    return false;
	}
	
	if(category_check() == false){
		$('#category_check').focus();
		alert('카테고리를 하나 이상 선택하셔야 합니다.');	
		return false;	
	}
	
	// var keywords = $("input[name=keyword]").val();
	// console.log(keywords);
	// if(keywords.length < 1){
	// 	$("input[name=keyword]").focus();
	// 	alert('키워드를 하나 이상 입력하세요.');
	// 	return false;
	// }

	// var check_type = "keyword";
	// if(fuck_check(check_type) == false){
	// 	$("input[name=keyword]").focus();
	//     alert('키워드에 욕설을 입력 하실 수 없습니다.');
	//     return false;
	// }
	
 	return true;
}

function temp_p_update(){
	return confirm('입력하신 내용으로 수정하시겠습니까?');
}

/*
1. 사진값을 가져와서 없다면 다음 -----
2. 내용과 카테고리 키워드값을 ajax로 넘김
3. post/check_update에서 내용과 카테고리 키워드값을 비교하여 json으로 받음
4. 결과값에 따라서 처리
*/
function check_post_update() {
	//아무것도 변경된게 없으면 수정할게 없다고 return false;로 돌려야함
	var check_file = $("input[name=photo]").val();
	if(!check_file){
		var post_idx = $("input[name=post_idx]").val(); //hidden에서 idx값받아오기
		var post_contents = $("textarea[name=contents]").val();
		var categorys = old_category_info();
		var keywords = $("input[name=keyword]").val();
		
		var old_post = new Array();
			old_post[0] = new Array (post_idx);
			old_post[1] = new Array (post_contents);
			old_post[2] = new Array (categorys);
			old_post[3] = new Array (keywords);
		
		$.post('/post/check_update', { old_post: old_post }, function (data) {
			var obj = $.parseJSON(data); //obj의 구조는 /action/rc가 내려주는 json 구조 참조
			if (obj.response.code == 'success') {
				return false;
			}
			if (obj.response.code == 'false') {
				return confirm('입력하신 내용으로 수정하시겠습니까?');
			}
/*
			if (obj.response.code == 'success') {
         		$("span[name=loveit_cnt_"+obj.response.idx+"]").html(obj.response.cnt);//해당게시물 loveit 횟수 표시 바꿔줌
         		//alert('success !!!');
			} else if(obj.response.code == 'notlogin') {
				alert('로그인 해주시기 바랍니다.');
        	} else if(obj.response.code == 'overlap') {
				alert('추천하신 게시물 입니다.');
        	} else {
	        	alert('추천에 실패하였습니다. 다시 시도해주세요.');
        	}
*/
		});
	} else {
		return confirm('입력하신 내용으로 수정하시겠습니까?');
	}
}


//]]>