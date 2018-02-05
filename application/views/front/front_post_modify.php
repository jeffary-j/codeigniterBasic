<?
include '_front_header.php';

$related_data = GET_RELATED_DATA($post[0]->idx);
?>
<link href="/assets/css/plugins/dropzone/basic.css" rel="stylesheet">
<link href="/assets/css/plugins/dropzone/dropzone.css" rel="stylesheet">
<!-- 글쓰기 폼 관련 소스 -->
<link href="/assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<!-- 키워드 폼 관련 소스 -->
<link href="/assets/css/bootstrap-tagsinput.css" rel="stylesheet">
<link href="/assets/css/bootstrap-tagsinput.less" rel="stylesheet">

<div class="wrapper wrapper-content wrapper_mystyle animated fadeInLeft">
    <div class="row">
        <div class="col-lg-12">
	        <!-- JS를 헤더에서 불러올경우 cookie, validate는 삭제 -->
			<script src="/script/jquery.validate.js" type="text/javascript" charset="utf-8"></script>	
			<script src="/script/form.post.js" type="text/javascript" charset="utf-8"></script>
            <form method="post" class="form-horizontal" name="post_update" action="/post/update/<?=$post[0]->idx?>" enctype="multipart/form-data">
				<input type="hidden" name="post_idx" value="<?=$post[0]->idx?>" />
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		                <h5><?=$post[0]->user_nick?> 님의 게시물 수정</h5>&nbsp;&nbsp;
		                <small>사진이나 내용등을 바꾸고 있습니다.</small>
		            </div> 
		            <!-- 사진 -->
	                <div class="ibox-content col-sm-12">
		                <div class="col-sm-6 noimg_tum">
						<!-- 프로필이미지 가져오기..... -->
	                        <img alt="image" src="<?=POST_UPFILE_PATH?>/<?=$post[0]->idx?>/<?=$post[0]->photo?>" />
		                </div>
		                <div class="col-sm-6">
					        <div class="kv-main">     
								<input id="file-0a" name="photo" class="file" type="file" multiple data-min-file-count="1" />
					        </div>
			            </div>
		            </div>
	                <!-- ./ 사진 -->   
		        </div>
		        <div class="ibox-content">
		            <div class="form-group">
		                <div class="col-sm-12"><textarea title="contents" name="contents" class="form-control post_register"><?=$post[0]->contents?></textarea></div>
		            </div>
		            <div class="hr-line-dashed"></div>
		            <div class="form-group text-left"><label class="col-sm-12 control-label">이미지에 해당 하는 카테고리를 하나 이상 선택해주세요.</label></div>
		            <div class="form-group">  
		                <ul class="col-sm-12 category_ck">
			                <li>

<?
$tmp_catetorys = array();
foreach($related_data['category_links'] as $category_link){
	array_push($tmp_catetorys, $category_link->category_idx);
}
foreach($categorys as $category){
	$is_checked = false;
	if(in_array($category->idx, $tmp_catetorys)){
		$is_checked = true;
	}
?>
	<input type="checkbox" name="category[]" value="<?=$category->idx?>" <?=($is_checked) ? 'checked' : ''?> /> <?=$category->name?></li>
<?
}
?>
		                </ul>
		            </div>
		            <div class="hr-line-dashed"></div>
					<div class="form-group">
						<label class="col-sm-12 control-label">키워드를 입력하시면 동일한 키워드가 입력된 이미지를 함께 보실 수 있습니다.</label><br />
						<small class="col-sm-12">키워드명을 입력하시고 Enter를 누르시면 키워드가 완성됩니다.</small>
					</div>
					<div class="form-group">
						<div class="bs-example col-sm-12">
<?
$tmp_keywords = array();
foreach($related_data['keyword_links'] as $keyword_link){
	array_push($tmp_keywords, $keyword_link->keyword_name);
}
$keywords_val = implode(',', $tmp_keywords);
?>
							<!-- 여기에 이름을 정해주면 위에서 입력한 키워드를 담아줌 -->
							<input type="text" name="keyword" value="<?=$keywords_val?>" data-role="tagsinput" style="display: none;" />
						</div>
					</div>
		        </div>
		        <div class="pull-right btn_margin">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button class="btn btn-primary" id="postUpdat" type="submit">Update</button>
                </div>
			</form>
        </div>
    </div>
</div>

<style>
/* .wrapper_mystyle {margin: 0 200px;} */
.ibox-content .coment_img {padding: 10px 0;}
.ibox-content .coment_img  img.img-circle {width:50px; height:50px;}
.ibox-content .media-body .well-sm {padding:9px 0;} 
.ibox-content .media-body .form-control{background: #f0f0f0;
  border: 1px solid #d1d1d1;
  -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.07);
  box-shadow: inset 0 0 2px rgba(0,0,0,0.07);
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  color: #333;
  display: block;
  margin: 0;}	

</style>



<?
include '_front_footer.php';
?>
<!-- 파일 업로드 관련 소스 -->
<script src="/assets/js/fileinput.js" type="text/javascript"></script>


<script>
	$('#file-fr').fileinput({
	    language: 'fr',
	    uploadUrl: '#',
	    allowedFileExtensions : ['jpg', 'png','gif'],
	});
	$('#file-es').fileinput({
	    language: 'es',
	    uploadUrl: '#',
	    allowedFileExtensions : ['jpg', 'png','gif'],
	});
	$("#file-0").fileinput({
	    'allowedFileExtensions' : ['jpg', 'png','gif'],
	});
	$("#file-1").fileinput({
	    uploadUrl: '#', // you must set a valid URL here else you will get an error
	    allowedFileExtensions : ['jpg', 'png','gif'],
	    overwriteInitial: false,
	    maxFileSize: 1000,
	    maxFilesNum: 10,
	    //allowedFileTypes: ['image', 'video', 'flash'],
	    slugCallback: function(filename) {
	        return filename.replace('(', '_').replace(']', '_');
	    }
	});
	/*
	$(".file").on('fileselect', function(event, n, l) {
	    alert('File Selected. Name: ' + l + ', Num: ' + n);
	});
	*/
	$("#file-3").fileinput({
		showUpload: false,
		showCaption: false,
		browseClass: "btn btn-primary btn-lg",
		fileType: "any",
	    previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
	});
	$("#file-4").fileinput({
		uploadExtraData: {kvId: '10'}
	});
	$(".btn-warning").on('click', function() {
	    if ($('#file-4').attr('disabled')) {
	        $('#file-4').fileinput('enable');
	    } else {
	        $('#file-4').fileinput('disable');
	    }
	});    
	$(".btn-info").on('click', function() {
	    $('#file-4').fileinput('refresh', {previewClass:'bg-info'});
	});
	/*
	$('#file-4').on('fileselectnone', function() {
	    alert('Huh! You selected no files.');
	});
	$('#file-4').on('filebrowse', function() {
	    alert('File browse clicked for #file-4');
	});
	*/
	$(document).ready(function() {
	    $("#test-upload").fileinput({
	        'showPreview' : false,
	        'allowedFileExtensions' : ['jpg', 'png','gif'],
	        'elErrorContainer': '#errorBlock'
	    });
	    /*
	    $("#test-upload").on('fileloaded', function(event, file, previewId, index) {
	        alert('i = ' + index + ', id = ' + previewId + ', file = ' + file.name);
	    });
	    */
	});
</script>
<!-- 키워드 관련 소스 -->
<script src="/assets/js/bootstrap-tagsinput.js" type="text/javascript"></script>
<script src="/assets/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>

