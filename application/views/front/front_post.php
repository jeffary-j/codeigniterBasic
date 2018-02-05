<?php
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:30
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?
//print_v($post);
?>
<div id="post-detail" class="post-detail">
	<div class="detail-heading">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="single-blog-img">
						<img src="/attach_file/post/<?php echo $post->user_idx.'/'.$post->idx.'/'.$post->photo?>" />
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-12">
				<div class="details-body">
					<h1 class="post-title">내용</h1>
					<p class="post-date"><?php echo GET_TIME_AGO($post->reg_date)?></p>
					<div class="post-long-desc">
						<p style="white-space: pre"><?php echo $post->contents?></p>
					</div>
					<div class="detail-bottom fix">
						<div class="post-social-links pull-left">
							<p>
								<span class="lbl">Share on&nbsp;&nbsp;-</span>
								<span>
									<a href="#"><i class="fa fa-facebook"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
									<a href="#"><i class="fa fa-google-plus"></i></a>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</span>
							</p>
						</div>
						<div class="post-tags pull-right">
							<p>
								<?
									if(count($post->keywords) > 0){
										echo "<span class=\"lbl\">키워드&nbsp;&nbsp;-&nbsp;</span>";
										echo "<span>";
										foreach($post->keywords as $key => $keyword){
											if((count($post->keywords)-1) > $key){
												echo "<a href=\"#\">".$keyword->keyword_name."</a>,&nbsp;";
											}
											if((count($post->keywords)-1) == $key){
												echo "<a href=\"#\">".$keyword->keyword_name."</a>";
											}
										}
										echo "</span>";
									}
								?>
							</p>
						</div>
					</div>

					<div class="about-author fix">
<!--
						<h6 class="title">about the author</h6>
						<div class="author-img">
							<img src="/assets/images/img02.jpg" alt="Author Image">
						</div>
						<div class="author-info">
							<p> 나 타투 하주잘해 나한테 와봐 이쁘게 해줄게 멋진 타투 해줄게 타투 이쁘게 잘하지 내가 짱이지 </p>
						</div>
-->
					</div>
<!-- /.about-author -->
					
					<div class="comments-area">
						<h6 class="title">12 comments</h6>
						<ul class="comments-list">
							<li class="single-comment">
								<div class="comment-box">
									<div class="comment-author">
										<img src="/assets/images/img01.jpg" alt="Comment Author">
									</div>
									<div class="comment-info">
										<p class="author-name"><a href="#">홍길동</a></p>
										<span class="comment-date">July 11, 2015</span>
										<p>사진이 너무 이쁘네요 사진이 아주 이뻐요 타투 어디서 했어요?</p>
<!-- 										<a href="#" class="reply-link" title="Reply">reply</a> -->
									</div>
								</div>
							</li><!-- /.single-comment -->
						</ul>
					</div><!-- /.comments-area -->
					<div class="comment-form-area">
						<p>leave a comment</p>
						<form action="#" method="post">
							<input type="text" placeholder="Name">
							<input type="text" placeholder="Email">
							<textarea placeholder="Message"></textarea>
							<button type="submit" class="submit-btn">submit</button>
						</form>
					</div><!-- /.comment-form-area -->
				</div><!-- /.deatils-body -->
			</div>
			<!-- sidebar-area start -->
			<div class="col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2">
				<div class="sidebar-area fix">
					<div class="side-wedget">
						<h6 class="widget-title">about me</h6>
						<div class="sidebar-content">
							<div class="my-photo">
								<a href="#"><img class="img-circle" src="/assets/images/img01.jpg" alt="My Image"></a>
							</div>
							<p><?php echo $post->user_nick."&nbsp;&nbsp;-&nbsp;&nbsp;".$post->user_info?></p>
						</div><!-- /.sidebar-content -->
					</div><!-- /.side-wedget -->
					<div class="side-wedget">
						<h6 class="widget-title">follow me on</h6>
						<div class="sidebar-content">
							<div class="social-links-area">
								<div class="single-icon">
									<a href="#">
										<i class="fa fa-facebook"></i>
										<p>Facebook</p>
									</a>
								</div><!-- /.single-icon -->
								<div class="single-icon">
									<a href="#">
										<i class="fa fa-twitter"></i>
										<p>Twitter</p>
									</a>
								</div><!-- /.single-icon -->
								<div class="single-icon">
									<a href="#">
										<i class="fa fa-google-plus"></i>
										<p>Google Plus</p>
									</a>
								</div><!-- /.single-icon -->
							</div><!-- /.social-links-area -->
						</div><!-- /.sidebar-content -->
					</div><!-- /.side-wedget -->

					<div class="side-wedget">
						<h6 class="widget-title">categories</h6>
						<div class="sidebar-content">
							<div class="categories-list">
								<ul>
									<?php
										foreach($post->categorys as $category){
//											$category->category_idx
											echo "<li><a href=\"#\"><span class=\"category\">".$category->category_name."</span><span class=\"number\">(".$category->category_cnt.")</span></a></li>";
										}
									?>
								</ul>
							</div>
						</div><!-- /.sidebar-content -->
					</div><!-- /.side-wedget -->

					<div class="side-wedget">
						<h6 class="widget-title">tags cloud</h6>
						<div class="sidebar-content">
							<div class="tags-list">
								<ul>
									<li><a href="#">politics</a></li>
									<li><a href="#">business</a></li>
									<li><a href="#">fashion</a></li>
									<li><a href="#">music</a></li>
									<li><a href="#">travel</a></li>
									<li><a href="#">food</a></li>
									<li><a href="#">photography</a></li>
									<li><a href="#">technology</a></li>
									<li><a href="#">sport</a></li>
								</ul>
							</div>
						</div><!-- /.sidebar-content -->
					</div><!-- /.side-wedget -->
				</div><!-- /.sidebar-area -->
			</div>
			<!-- sidebar-area end -->
		</div>
	</div>
</div>
