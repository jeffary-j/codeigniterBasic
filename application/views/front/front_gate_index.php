<?php
/**
 * Created by PhpStorm.
 * User: JEFF
 * Date: 16. 4. 7.
 * Time: 오후 12:30
 */

defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="page-main" role="main">
	<!-- 상단 카테고리 -->
	<div class="inner">
		<form class="filter-form" id="gallery-filter">
	<!--
	        <span class="form-item">
	            <input type="radio" name="filter" id="filter-all" value="all" checked>
	            <label for="filter-all">All</label>
	        </span>
	-->
	        
	<?php
	if($categorys){
			
		for($i=0; $i<count($categorys); $i++){
			if ($i == 0){
				echo "<span class=\"form-item\">";
		        echo "<input type=\"radio\" name=\"filter\" id=\"filter-".$categorys[$i]->idx."\" value=\"".$categorys[$i]->sort."\" checked>";
		        echo "<label for=\"filter-".$categorys[$i]->idx."\">".$categorys[$i]->name."</label>";
		        echo "</span>";
			} else {
				echo "<span class=\"form-item\">";
		        echo "<input type=\"radio\" name=\"filter\" id=\"filter-".$categorys[$i]->idx."\" value=\"".$categorys[$i]->sort."\">";
		        echo "<label for=\"filter-".$categorys[$i]->idx."\">".$categorys[$i]->name."</label>";
		        echo "</span>";
			}
			
			
		}		
		
	}
	?>
	    </form>
	</div>
	
	
    <ul class="gallery" id="gallery"></ul>
    <button class="load-more" id="load-more">Load more</button>
</div>

<script type="text/javascript">
	var $ = jQuery;
	var per_page = 0;
	<?php
		if(!empty($page)) echo "per_page = ".$page;
	?>

	$("#load-more").click(function(){
//		addItems();
	});

</script>