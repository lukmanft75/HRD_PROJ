<!--notifikasi  -->
<div class="alert alert-danger" id="alert-danger" style="display:none;" role="alert">
	<?=$_SESSION["alert_danger"];?>
</div>
<div class="alert alert-success" id="alert-success" style="display:none;" role="alert">
	<?=$_SESSION["alert_success"];?>
</div>
<div class="alert alert-dark" id="alert-dark" style="display:none;" role="alert">
	<?=$_SESSION["alert_dark"];?>
</div>
<!--//notifikasi  -->

<?php
	if($_SESSION["alert_danger"]){
		?>
		<script>
		  $(document).ready(function () {
			$("#alert-danger").fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
		 });
		</script>
		<?php
		$_SESSION["alert_danger"] = "";
	}
	if($_SESSION["alert_success"]){
		?>
		<script>
		  $(document).ready(function () {
			$("#alert-success").fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
		 });
		</script>
		<?php
		$_SESSION["alert_success"] = "";
	}
	if($_SESSION["alert_dark"]){
		?>
		<script>
		  $(document).ready(function () {
			$("#alert-dark").fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
		 });
		</script>
		<?php
		$_SESSION["alert_dark"] = "";
	}
	?>