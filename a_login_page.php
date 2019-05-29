<?php include_once "head.php"; ?>
<!--/Login-->
<div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" style="display:block;">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="login px-4 py-4 mx-auto mw-100">
					<h5 class="text-center mb-4">Login Now</h5>
					<h6 style="color:red;"><?=$_SESSION["errormessage"];?></h6>
					<?=$f->start();?>
						<div class="form-group">
							<p class="mb-2">Email address</p>
							<?=$txt_username = $f->input("username",@$_POST["username"],"type='email' required","form-control");?>
						</div>
						<div class="form-group">
							<p class="mb-2">Password</p>
							<?=$txt_username = $f->input("password",@$_POST["password"],"type='password' required","form-control");?>
						</div>
						<?=$f->input("login_action","Sign In","type='submit'","btn submit");?>
					<?=$f->end();?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--//Login-->
<script type="text/javascript"> 
	document.getElementById("username").focus(); 
</script>
