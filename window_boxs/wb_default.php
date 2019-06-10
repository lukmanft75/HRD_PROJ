<style>
@media (min-width:576px){
	#wb_content_main{
		max-width:500px !important;
	}
	#wb_content{
		height:300px;
	}
}
@media (min-width:768px){
	#wb_content_main{
		max-width:650px !important;
	}
	#wb_content{
		height:400px;
	}
}
@media (min-width:992px){
	#wb_content_main{
		max-width:800px !important;
	}
	#wb_content{
		height:500px;
	}
}
@media (min-width:1200px){
	#wb_content_main{
		max-width:800px !important;
	}
	#wb_content{
		height:500px;
	}
}
</style>

<body>
	<div class="modal fade" id="window_boxs" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" id="wb_content_main"role="document">
			<div class="modal-content" id="wb_content">
				<div class="modal-header text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" id="close_window">&times;</span>
					</button>
				</div>
				
					<iframe id="wb_iframe" style="width:98%; height:90%;" frameborder="0" src=""></iframe>
			
			</div>
		</div>
	</div>

	<script type="text/javascript"> 
		function SetPage(url){
			document.getElementById("wb_iframe").setAttribute("src", url);
		}
	</script>
</body>