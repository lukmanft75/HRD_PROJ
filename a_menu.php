<?php
	$menus = $db->fetch_all_data("backoffice_menu",[],"parent_id = '0'");
	$exp 		= explode("_",$__phpself);
	$ext		= count($exp)-1;
	$url_like 	= str_replace($exp[$ext],"",$__phpself);
	$_ext		= explode(".",$exp[$ext])[0];
?>
<div class="header-outs" id="header">
	<div class="header-w3layouts">
		<!--//navigation section -->
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="hedder-up">
				<h1><a class="navbar-brand" href="index.php"><?=$__appstitle;?></a></h1>
			</div>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
				<ul class="navbar-nav ">
					<?php
						$active = "";
						foreach($menus as $_menu){
							if(@$__menu_ids[$_menu["id"]]){
								$parents = $db->fetch_all_data("backoffice_menu",[],"parent_id = '".$_menu["id"]."'");
								if(count($parents) > 0){
									$cek_active = $db->fetch_single_data("backoffice_menu","id",["parent_id" => $_menu["id"], "url" => $url_like."%:LIKE"]);
									if($cek_active && count($exp) > 1 && $__phpself != "index.php") {$active = "active";} else {$active = "";}
									?>
									<li class="nav-item dropdown <?=$active;?>">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?=$_menu["name"];?>
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdown">
											<?php
												foreach($parents as $_parent){
													?>
														<a href="<?=$_parent["url"];?>" class="nav-link"><?=$_parent["name"];?></a>
													<?php
												}
											?>
										</div>
									</li>
									<?php
								} else{
									$m_exp 		= explode("_",$_menu["url"]);
									$m_ext		= count($m_exp)-1;
									$m_url_like = str_replace($m_exp[$m_ext],"",$_menu["url"]);
									if($m_url_like == $url_like && $__phpself != "index.php") {$active = "active";} else {$active = "";}
									?>
										<li class="nav-item <?=$active;?>">
											<a class="nav-link" href="<?=$_menu["url"];?>"><?=$_menu["name"];?> <span class="sr-only">(current)</span></a>
										</li>
									<?php
								}
							}
						}
					?>
				</ul>
				
				<?php if($__isloggedin) { ?>
					<div class="both-butns">
						<ul>
							<li>
								<div class="contact-hedder">	
									<a href="?logout_action=1">Log Out</a>
									<!-- <button onclick="window.location = 'change_password.php'" class="register-hedder" >Change Password</button> -->
								</div>
							</li>
						</ul>
					</div>
				<?php } ?>
			</div>
		</nav>
		<!--//navigation section -->
		<div class="clearfix"> </div>
	</div>
</div>

<?php
	if($__phpself != "index.php"){
	?>
		<!-- banner -->
		<div class="inner_page-banner one-img"></div>
		<!--//banner -->
		
		<!-- short -->
		<div class="using-border py-3">
			<div class="inner_breadcrumb  ml-4">
				<ul class="short_ls">
					<li>
						<a href="index.php">Home</a>
						<span>/ /</span>
					</li>
					<?php
					$menu_self = $db->fetch_all_data("backoffice_menu",["name","parent_id"],"url LIKE '".$url_like."%'")[0];
					if($menu_self["parent_id"] > 0){
						$menu_parent = $db->fetch_single_data("backoffice_menu","name",["id" => $menu_self["parent_id"]]);
						echo "<li> ".$menu_parent." <span>/ /</span></li>";
						echo "<li>&nbsp;".$menu_self["name"]." - ".$_ext." </li>";
					} else {
						echo "<li> ".$menu_self["name"]." - ".$_ext." </li>";
					}
					?>
				</ul>
			</div>
		</div>
		<!-- //short--> 
	<?php
	}
?>

