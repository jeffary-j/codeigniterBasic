
<div class="register_box col-xs-12">
	<form method="post" name="post_register" class="form-horizontal" action="/post/input" enctype="multipart/form-data">
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
                <ul class="col-sm-12 category-ck">
	                <!-- 체크박스는 배열 형태로 넘김 --> 
<?
foreach($categorys as $category){
?>
	                <li class="checkbox i-checks"><input type="checkbox" name="category[]" id="category_check_<?=$category->idx?>" value="<?=$category->idx?>" /> <label for="category_check_<?=$category->idx?>"><?=$category->name?></label></li>
<?	
}
?>
	                
                </ul>
            </div>
			<div class="text-left text-info"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> 키워드를 입력하시면 동일한 키워드가 입력된 이미지를 함께 보실 수 있습니다.</div>
			<div class="form-group has-success has-feedback">
				<div class="col-xs-12">
					<div style="width: 100%;">
<?php
for($i=0;$i<6;$i++){
?>
						<div class="post_keyword_input">
							<input type="text" class="form-control" id="inputSuccess2" aria-describedby="inputSuccess2Status" />
							<button type="button" class="form-control-feedback" aria-hidden="true" onclick="keyword_delete(this)"><i class="glyphicon glyphicon-remove"></i></button>
						</div>
<?php
}
?>
					</div>

				</div>
			</div>
            <div class="pull-right">
                <button type="reset" class="btn btn-default">Reset</button>
                <button class="btn btn-primary" id="postRegit" type="submit">Confirm</button>
            </div>
            <div class="clearfix"></div>
        </div>
	</form>

</div>
<div class="clearfix"></div>



<script>
$(document).ready(function() {
	$("#file-0a").fileinput({
	    'allowedFileExtensions' : ['jpg', 'png','gif', 'jpeg'],
	});
});

function keywords_lang(obj){
	
}
function keyword_delete(obj){
	alert('sss');
}
</script>




