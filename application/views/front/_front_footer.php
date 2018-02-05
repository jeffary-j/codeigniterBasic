<?php
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:30
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>

	</div>
	<!--  ..// container-->
</div>
<!-- ..// wrappper -->

<footer id="footer" class="footer">
	<div class="container">
		<div class="footer-nav">
			<ul class="nav navbar-nav sm" data-smartmenus-id="1470894585796688">
				<li><a href="/">Home</a></li>
				<li><a href="#">Privacy &amp; Policy</a></li>
				<li><a href="#">About</a></li>
			</ul>
		</div> <!-- End .footer-nav -->
		<div class="copyright">
			<span>Copyright 2016, All Rights Reserved <a href="/">Tattois.</a></span>
		</div> <!-- End .copyright -->
	</div> <!-- End .container -->
</footer>

<div class="clearfix"></div>

<script type="text/javascript" src="/assets/emJs/jquery.ba-throttle-debounce.min.js"></script>
<script type="text/javascript" src="/assets/emJs/custom.js"></script>

<script type="text/javascript">
	var $ = jQuery;
	
	$(document).ready(function() {
		$( "#post_search" ).click(function() {
			$( "#small_modal" ).modal("show");
		});	
	});
</script>

	
<!-- Controller에서 동적으로 추가되는 JS -->
<?php 
	if(!empty($js)){
		foreach($js as $a)
			echo "<script src=\"" .$a. "\"></script> \n";
	}
?>



</body>
</html>