<?php
	include_once "head.php";
	$id = GET_url_decode("id");
	
	if(isset($_POST["save"])){
		$db->addtable("backoffice_menu_privileges");
		$db->where("group_id",$id);
		$db->delete_();
		
		foreach($_POST["sel_"] as $menu_id){			
			$db->addtable("backoffice_menu_privileges");
			$db->addfield("group_id");						$db->addvalue($id);
			$db->addfield("backoffice_menu_id");			$db->addvalue($menu_id);	
			$db->addfield("privilege");						$db->addvalue(1);
			$inserting = $db->insert();
		}
		if($inserting["affected_rows"] >= 0){
			$_SESSION["alert_success"] = "Data saved successfully!";
			?><script type="text/JavaScript">setTimeout("location.href = '<?=$__base_url;?>';",1500);</script><?php
		} else {
			$_SESSION["alert_danger"] = "Failed to saved!";
		}
	}
?>

	<!--form -->
	<section class="contact py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="container">
			<?php include_once "a_notification.php"; ?>
			<div class="sub-head mb-3 ">
				<h4>Group Privileges - <i><?=$db->fetch_single_data("groups","name",["id" => $id]);?></i></h4>
			</div>
			<div class="info-para">
				<?=$f->start();?>
					<div class="row wls-contact-mid">
						<div class="col-md-6 col-sm-6 form-group contact-forms">
						<div class="table_list">
							<?=$t->start("","","data_content");?>
								<?php
									$backoffice_menus = $db->fetch_all_data("backoffice_menu",[],"parent_id = '0'");
									foreach($backoffice_menus as $head_menu){
										$is_checked = $db->fetch_single_data("backoffice_menu_privileges","privilege",["group_id" => $id, "backoffice_menu_id" => $head_menu["id"]]);
										$checked = ""; if($is_checked){$checked = "checked";}
										$selects = $f->input("sel_[".$head_menu["id"]."]",$head_menu["id"],"type='checkbox' style='height:15px;' ".$checked);
										echo $t->row([$selects, $head_menu["name"]],["","style='font-weight:bolder;' colspan=2"]);
										$have_parent = $db->fetch_all_data("backoffice_menu",[],"parent_id = '".$head_menu["id"]."'");
										if($have_parent){
											foreach($have_parent as $sub_menu){
											$is_checked = $db->fetch_single_data("backoffice_menu_privileges","privilege",["group_id" => $id, "backoffice_menu_id" => $sub_menu["id"]]);
											$checked = ""; if($is_checked){$checked = "checked";}
											$selects_2 = $f->input("sel_[".$sub_menu["id"]."]",$sub_menu["id"],"type='checkbox' style='height:15px;' ".$checked);
												echo $t->row(["",$selects_2,$sub_menu["name"]],["style='width:50px;'","style='width:50px;'",""]);
											}
										}
									}
								?>
							<?=$t->end();?>
						</div>
						</div>
					</div>
					<div class="text-left click-subscribe">
						<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
						<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_privileges","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-secondary");?>
					</div>
				<?=$f->end();?>
			</div>
		</div>
	</section>
    <!--//form  -->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
</body>
</html>