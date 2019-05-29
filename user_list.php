<?php
	$_isexport = false;
	if(@$_GET["export"]){
		$_exportname = "User_List.xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=".$_exportname);
		header("Pragma: no-cache");
		header("Expires: 0");
		$_GET["do_filter"]="Load";
		$_isexport = true;
	}
	include_once "head.php";
	if(GET_url_decode("deleting") > 1 && $__group_id == "0"){
		$db->addtable("users");			$db->where("id",GET_url_decode("deleting"));
		$db->addfield("hidden");		$db->addvalue("1");
		$update = $db->update();
		$_SESSION["alert_success"] = "Data deleted successfully!";
		?>
			<script type="text/JavaScript">setTimeout("location.href = 'user_list.php';",1500);</script>
		<?php
	}

	if(!$_isexport){
	?>
	<!--Filter-->
	<div class="modal fade" id="filter_box" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					<div class="login mx-auto mw-100">
						<h5 class="text-center">Filter Box</h5>
						<?=$f->start("filter","GET");?>
							<div class="form-group ">
								<p class="mb-2">Name</p>
								<?=$f->input("name",@$_GET["name"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Email</p>
								<?=$f->input("email",@$_GET["email"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Group</p>
								<?=$f->input("group",@$_GET["group"],"","form-control");?>
							</div>
							<div class="form-group">
								<p class="mb-2">Job Title</p>
								<?=$f->input("job_title",@$_GET["job_title"],"","form-control");?>
							</div>
							<?=$f->input("page","1","type='hidden'");?>
							<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
							<?=$f->input("do_filter","Load","type='submit' style='width:140px;'", "btn btn-primary");?>
							<?=$f->input("reset","Reset","type='button' style='width:140px;' onclick=\"window.location='?';\"", "btn btn-warning");?>
							<?=$f->input("export","Export to Excel","type='submit' style='width:170px;'","btn btn-success");?>
						<?=$f->end();?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--//Filter-->
	<?php } ?>
	
	<!--Table-->
	<section class="typography py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="table_list">
			<div class="sub-head mb-3 ">
			<?php include_once "a_notification.php"; ?>
				<h4>User List</h4>
					<?=$f->input("add","Add","type='button' onclick=\"window.location='user_add.php';\"", "btn btn-primary");?>
					<?=$f->input("filter","Filter","type='button' data-toggle='modal' data-target='#filter_box'", "btn btn-success");?>
			</div>
			
			<?php
				$whereclause = "";
				if(@$__group_id > 0)	$whereclause .= "hidden = '0' AND ";
				if(@$_GET["name"]!="") $whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["name"])."%"."' AND ";
				if(@$_GET["email"]!="") $whereclause .= "email LIKE '"."%".str_replace(" ","%",$_GET["email"])."%"."' AND ";
				if(@$_GET["group"]!="") $whereclause .= "group_id IN (SELECT groups.id FROM groups WHERE name LIKE '%".$_GET["group"]."%') AND ";
				if(@$_GET["job_title"]!="") $whereclause .= "job_title LIKE '"."%".str_replace(" ","%",$_GET["job_title"])."%"."' AND ";

				$db->addtable("users");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
				$maxrow = count($db->fetch_data(true));

				$db->addtable("users");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
				if(@$_GET["sort"] != "") {
					if(@$_GET["desc"]) {$desc = "DESC";} else {$desc = "";}
					$db->order($_GET["sort"]." ".$desc);
				} else {$db->order("created_at DESC");}
				$db->limit($_limit);
				$users = $db->fetch_data(true);
				
				$count_data =count($db->fetch_all_data("users",["id"],substr($whereclause,0,-4)));
			?>
			
			<?php  if(!$_isexport){ include "a_pagination.php"; }?>
			<div class="bd-example mb-4">
				<div style="overflow-x:auto;">
					<?=$t->start($border_tbl,"","data_content");?>
						<?=$t->header(["No",
										"Action",
										"<div onclick=\"sorting('name');\">Name</div>",
										"<div onclick=\"sorting('email');\">Email</div>",
										"<div onclick=\"sorting('group_id');\">Group</div>",
										"<div onclick=\"sorting('job_title');\">Job Title</div>"]);?>
						<?php
							foreach($users as $data_user){
								if($data_user["id"] > 1) $password = "[".base64_decode($data_user["password"])."]";
								$actions = 	"<a href=\"user_edit.php?".url_encode("id")."=".url_encode($data_user["id"])."\"><img src='images/edit.png' style='width:20px; height:20px;' title='Edit'></a>";
								$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?".url_encode("deleting")."=".url_encode($data_user["id"])."';}\"><img src='images/cancel.png' style='width:20px; height:20px;' title='Deactive'></a>";
								$inactive = "";
								if($__group_id == 0 && $data_user["hidden"] == 1) $inactive = "background-color:#ff8080;";
								echo $t->row([
								$start++,
								$actions,
								$data_user["name"],
								$data_user["email"].$password,
								$db->fetch_single_data("groups","name",["id" => $data_user["group_id"]]),
								$data_user["job_title"]
								],["style='width:3%' align=right nowrap","style='width:6%;".$inactive."'","","","",""]);
							}
						?>
					<?=$t->end();?>
				</div>
			</div>
			<?php  if(!$_isexport){ include "a_pagination.php"; }?>
		</div>
	</section>
	<!--//Table-->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
</body>
</html>