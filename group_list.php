<?php
	include_once "head.php";
	if(GET_url_decode("deleting") > 1 && $__group_id == "0"){
		$db->addtable("groups");			$db->where("id",GET_url_decode("deleting"));
		$db->delete_();
		$_SESSION["alert_success"] = "Data deleted successfully!";
		?>
			<script type="text/JavaScript">setTimeout("location.href = 'group_list.php';",1500);</script>
		<?php
	}
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
								<?php if(@$_GET["desc"]) {$checked = "checked";} ?>
								<?=$f->input("desc","","type='checkbox' style='background-color:red;' ".$checked);?> <font style="font-style:italic">Descending</font>
							</div>
							<?=$f->input("page","1","type='hidden'");?>
							<?=$f->input("do_filter","Load","type='submit' style='width:150px;'", "btn btn-primary");?>
							<?=$f->input("reset","Reset","type='button' style='width:150px;' onclick=\"window.location='?';\"", "btn btn-warning");?>
						<?=$f->end();?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--//Filter-->
	
	<!--Table-->
	<section class="typography py-lg-4 py-md-3 py-sm-3 py-3">
		<div class="table_list">
			<div class="sub-head mb-3 ">
			<?php include_once "a_notification.php"; ?>
				<h4>Group List</h4>
					<?=$f->input("add","Add","type='button' onclick=\"window.location='group_add.php';\"", "btn btn-primary");?>
					<?=$f->input("filter","Filter","type='button' data-toggle='modal' data-target='#filter_box'", "btn btn-success");?>
			</div>
			
			<?php
				$whereclause = "";
				if(@$_GET["name"]!="") {
					$whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["name"])."%"."' AND ";
				}

				$db->addtable("groups");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
				$maxrow = count($db->fetch_data(true));

				$db->addtable("groups");
				if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
				if(@$_GET["name"] != "") {
					if(@$_GET["desc"]) {$desc = "DESC";} else {$desc = "";}
					$db->order("name ".$desc);
				} else {$db->order("created_at DESC");}
				$db->limit($_limit);
				$groups = $db->fetch_data(true);
				
				$count_data =count($db->fetch_all_data("groups",["id"],substr($whereclause,0,-4)));
			?>
			
			<?php include "a_pagination.php";?>
			<div class="bd-example mb-4">
				<div style="overflow-x:auto;">
					<?=$t->start("","","data_content");?>
						<?=$t->header(["No","ID","Actions","Group Name","Users Count"]);?>
						<?php
							foreach($groups as $data_group){
								$actions = 	"<a href=\"group_edit.php?".url_encode("id")."=".url_encode($data_group["id"])."\"><img src='images/edit.png' style='width:20px; height:20px;' title='Edit'></a>";
								$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?".url_encode("deleting")."=".url_encode($data_group["id"])."';}\"><img src='images/delete.png' style='width:20px; height:20px;' title='Delete'></a>";
								$actions .= "<img src='images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href=\"group_privileges.php?".url_encode("id")."=".url_encode($data_group["id"])."\"><img src='images/view.png' style='width:20px; height:20px;' title='Menu Privileges'></a>";
								$user_count = count($db->fetch_all_data("users",["id"],"group_id = '".$data_group["id"]."'"));
								echo $t->row([
								$start++,
								$data_group["id"],
								$actions,
								$data_group["name"],
								$user_count." Users"
								],["style='width:3%' align=right nowrap","style='width:3%' align=center","style='width:10%;'","","style='width:5%' align=center"]);
							}
						?>
					<?=$t->end();?>
				</div>
			</div>
			<?php include "a_pagination.php";?>
		</div>
	</section>
	<!--//Table-->

<?php
	include_once "footer.php";
	include_once "a_pop_up_js.php";
?>
</body>
</html>