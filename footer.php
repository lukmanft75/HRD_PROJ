<?php if(!$_isexport){ ?>
<!--footer-->
<footer class="buttom-footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-7 col-md-7" style="padding-top:30px;">
				<div class="headder-logo-icon text-center">
					<h2><a href="index.php"><?=$__appstitle;?></a></h2>
				</div>
				<div class="footer-bottom text-center">
					<p>©<?=date("Y")." ".$__appstitle;?>. All Rights Reserved | Modified by <a href="#" target="_blank">FT75</a></p>
				</div>
			</div>
			<div class="col-lg-5 col-md-5">
				<div class="buttom-nav py-2">
					<nav class="border-line">
						<ul class="nav justify-content-center">
							<?php
							foreach($menus as $_menu){
								if(@$__menu_ids[$_menu["id"]]){
								?>
									<li class="nav-item">
										<a class="nav-link" href="<?=$_menu["url"];?>" ><?=$_menu["name"];?></a>
									</li>
								<?php
								}
							}
							?>
						</ul>
						<?php if($__isloggedin) { ?>
						<ul class="nav justify-content-center">
							<li class="nav-item">
								<a class="nav-link" href="#" ><?=$__fullname;?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#" >|</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="change_password.php" >Change Password</a>
							</li>
						</ul>
						<?php } ?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</footer>
<!--//footer-->
<?php } ?>