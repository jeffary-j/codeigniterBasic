<!-- 글쓰기 폼 관련 소스 -->
<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'fileinput.css');?>" />
<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'plugins/dropzone/basic.css');?>" />


<script src="<?php echo base_url(ASSETS_JS.'form.post.js');?>" type="text/javascript" charset="utf-8"></script>

<div class="wrapper wrapper-content animated">
    <div class="row">
        <div class="register_box col-xs-12 col-md-8">
			
			<form method="post" name="post_register" class="form-horizontal" action="/post/input" enctype="multipart/form-data">
		        <div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5>Tatoo Is에 사진과 내용을 작성하시겠어요?</h5>&nbsp;&nbsp;
		            </div>    
		            <!-- 사진 등록 폼 -->
		            <div class="ibox-content">
				        <div class="kv-main">     
							<input id="file-0a" name="photo" class="file" type="file" multiple data-min-file-count="1" />
				        </div>
		            </div>
		            <!-- ./ 사진 등록 폼 -->
		        </div>
		        <div class="ibox-content">
		            <div class="form-group">
		                <div class="col-sm-12"><textarea title="contents" name="contents" id="contents" class="form-control post_register" rows="7" placeholder="이미지에 대한 내용을 입력해 주시겠어요?"></textarea></div>
		            </div>
		            <div class="hr-line-dashed"></div>
		            <div class="form-group text-left"><label class="col-sm-12 control-label">이미지에 해당 하는 카테고리를 하나 이상 선택해주세요.</label></div>
		            <div class="form-group">  
		                <ul class="col-sm-12 category_ck">
			                <li>
<?
foreach($categorys as $category){
?>
			                <!-- 체크박스는 배열 형태로 넘김 --> 
			                <input type="checkbox" name="category[]" id="category_check" value="<?=$category->idx?>" /> <?=$category->name?>
<?	
}
?>
			                </li>
		                </ul>
		            </div>
		            <div class="hr-line-dashed"></div>
						<div class="form-group">
							<label class="col-sm-12 control-label">키워드를 입력하시면 동일한 키워드가 입력된 이미지를 함께 보실 수 있습니다.</label><br />
						</div>
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
		            <div class="hr-line-dashed"></div>
		            <div class="form-group">
		                <div class="pull-right margin_lr">
		                    <button type="reset" class="btn btn-default">Reset</button>
		                    <button class="btn btn-primary" id="postRegit" type="submit">Confirm</button>
		                </div>
		            </div>
		        </div>
			</form>
        </div>
    </div>
</div>



<!-- 파일 업로드 관련 소스 -->
<script src="<?php echo base_url(ASSETS_JS.'fileinput.js');?>" type="text/javascript" charset="utf-8"></script>

<script>
$(document).ready(function() {
	$("#file-0a").fileinput({
	    'allowedFileExtensions' : ['jpg', 'png','gif'],
	});
});

function keywords_lang(obj){
	
}
function keyword_delete(obj){
	alert('sss');
}
</script>




