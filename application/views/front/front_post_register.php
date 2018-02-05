
<div class="register_box col-xs-12">
	<form method="post" name="post_register" class="form-horizontal" action="/post/input" enctype="multipart/form-data" onsubmit="return check_post_register();">
        <div class="register-head">
            <h2>Tatoo Is에 사진과 내용을 작성하시겠어요?</h2>   
            <!-- 사진 등록 폼 -->
            <div class="ibox-content">
		        <div class="kv-main">     
					<input id="file-0a" name="photo" class="file" type="file" data-min-file-count="1" />
		        </div>
            </div>
            <!-- ./ 사진 등록 폼 -->
        </div>
        <div class="register-body">
            <div class="form-group">
                <div class="col-sm-12"><textarea title="contents" name="contents" id="contents" class="form-control post_register" rows="7" placeholder="이미지에 대한 내용을 입력해 주시겠어요?"></textarea></div>
            </div>
            <div class="text-left text-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> 이미지에 해당 하는 카테고리를 하나 이상 선택해주세요.</div>
            <div class="form-group">  
                <ul class="col-sm-12 category_ck">
	                <li>
<?
foreach($categorys as $category){
?>
	                <!-- 체크박스는 배열 형태로 넘김 --> 
	                <label><input type="checkbox" name="category[]" id="category_check" value="<?=$category->idx?>" onclick="categoryEvent(this);" /> <?=$category->name?></label>

<?	
}
?>
	                </li>
                </ul>
            </div>
			<div class="text-left text-info"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> 키워드를 입력하시면 동일한 키워드가 입력된 이미지를 함께 보실 수 있습니다.</div>
			<div class="form-group has-feedback">
				<div id="keyword_position" class="col-xs-12 keywordInput"></div>
			</div>
			<div class="form-group has-success has-feedback">
				<div class="col-xs-12">
					<input type="text" class="form-control" id="keyword_input_box" />
					<button type="button" class="form-control-feedback" aria-hidden="true" onclick="keyword_register('#keyword_input_box')"><i class="fa fa-plus"></i></button>
				</div>
			</div>
            <div class="pull-right">
                <button type="reset" class="btn btn-default">Reset</button>
                <button class="btn btn-primary" type="submit" >Confirm</button>
            </div>
            <div class="clearfix"></div>
        </div>
	</form>

</div>
<div class="clearfix"></div>


<script type="text/javascript">
	$(document).ready(function() {
		if($(".write_bt")){
			$(".write_bt > a").attr("href", "/");
			$(".write_bt > a > i").removeClass( "fa-plus" );
			$(".write_bt > a > i").addClass( "fa-home" );
		}

		$("#file-0a").fileinput({
		    'allowedFileExtensions' : ['jpg', 'png','gif', 'jpeg'],
		});

		$('form[name=post_register]').bind("keypress", function(e) {
            if (e.keyCode == 13) {
                if(!$("#contents").is(":focus")){
                    if($("#keyword_input_box").is(":focus")){
                    	keyword_register("#keyword_input_box");
                    	e.preventDefault();
                    	return false;
                    }
                }
                
			}
		});
	});

	function categoryEvent(obj){
		var checked = $(obj);

		if(checked.is(":checked")){
			$(obj).parent().css('color', "#000");
		}
		else {
			$(obj).parent().css('color', "#999");
		}
	}

	function keywords_lang(obj){
		
	}
	function keyword_register(obj){
		var word = $(obj).val();
		
		if(word.length < 1){
			alert("키워드를 입력해주세요");
			return false;
		}

		var inputHtml = "<div class=\"keywordListDiv\">"
					  + "<input type=\"text\" name=\"keywords[]\" class=\"form-control keywordsList\" id=\"keyword\" value=\"" + word + "\" readonly/>"
					  + "<button type=\"button\" class=\"form-control-feedback\" aria-hidden=\"true\" onclick=\"keyword_delete(this)\"><i class=\"glyphicon glyphicon-remove\"></i></button>"
					  + "</div>";
		$("#keyword_position").append(inputHtml);
		$(obj).val("");
	}
	function keyword_delete(obj){
		var deleteDiv = $(obj).parent();
		deleteDiv.remove();
	}
</script>




