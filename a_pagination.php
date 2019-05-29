<div class="pagination">
	<?php
		$page_total = ceil($count_data/$_rowperpage);
		// $page_total = 22;
		$show_a_limit = 10;
		$mulai = (floor($_GET["page"]/10.5)*10)+1;
		$n = 1;
		
		if($mulai > $show_a_limit){
			$url_page = str_replace("page=".$_GET["page"],"page=1",$base_url);
			echo "<a href ='".$url_page."' style='background-color:blue; color:white; border: 1px solid blue; border-radius: 5px;'>&nbsp;<<&nbsp;</a>&ensp;";
			
			$url_page = str_replace("page=".$_GET["page"],"page=".($mulai-1),$base_url);
			echo "<a href ='".$url_page."' style='background-color:blue; color:white; border: 1px solid blue; border-radius: 5px;'>&nbsp;<&nbsp;</a>&ensp;";
		}
		
		for($i=$mulai; $i<=$page_total; $i++){
			$url_page = $base_url."page=".$i;
			if($_GET["page"]) $url_page = str_replace("page=".$_GET["page"],"page=".$i,$base_url);
			$pages = "<a href ='".$url_page."'>".$i."</a>&ensp;";
			if($n > $show_a_limit) $pages = "";
			echo $pages;
			$n++;
		}
		
		if(($mulai+9) < $page_total) {
			$url_page = $base_url."page=".($mulai+10);
			if($_GET["page"]) $url_page = str_replace("page=".$_GET["page"],"page=".($mulai+10),$base_url);
			echo "<a href ='".$url_page."' style='background-color:blue; color:white; border: 1px solid blue; border-radius: 5px;'>&nbsp;>&nbsp;</a>&ensp;";
			
			$url_page = $base_url."page=".($i-1);
			if($_GET["page"]) $url_page = str_replace("page=".$_GET["page"],"page=".($i-1),$base_url);
			echo "<a href ='".$url_page."' style='background-color:blue; color:white; border: 1px solid blue; border-radius: 5px;'>&nbsp;>>&nbsp;</a>&ensp;";
		}
	?>
</div>