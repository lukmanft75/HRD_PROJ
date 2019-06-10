<?php include_once "wb_head.php" ;?>
<body>			
	<?php
		$db->addtable("candidate_work_experiences");
		if($_GET["candidate_id"] > 0) {
			$candidate_id 	= $_GET["candidate_id"];
			$db->awhere("candidate_id = '".$candidate_id."'");
		}
		$candidate_work_experiences = $db->fetch_data(true);
		
		if($_GET["deleting"]){
			$db->addtable("candidate_work_experiences");	$db->where("id",$_GET["deleting"]);
			$deleting = $db->delete_();
			$_SESSION["alert_success"] = "Data deleted successfully!";
			?>
				<script type="text/JavaScript">setTimeout("location.href = '?candidate_id=<?=$candidate_id;?>';",1500);</script>
			<?php
		}
	?>
	
	<div class="modal-body" id="List">
		<div class="login mx-auto mw-100">
			<h5 class="text-center">Candidate Work Experiences</h5>
			<?php include_once "../a_notification.php"; ?>
			<div class="table_list">
				<div style="overflow-x:auto;">
					<?=$t->start("","","data_content");?>
						<?=$t->header(["No","Action","Company Name","Location","Tasks","Phone","Join Date","Last Date","Reason for Leaving"]);?>
						<?php 
							$i=0;
							foreach($candidate_work_experiences as $no => $data){
								$i++;
								$actions = 	"<img src='../images/edit.png' style='width:20px; height:20px;' title='Edit' onclick=\"window.location='".str_replace("_list","_edit",$_SERVER["PHP_SELF"])."?data_id=".$data["id"]."&candidate_id=".$candidate_id."';\" '>";
								$actions .= "<img src='../images/vertical.png' style='width:20px; height:20px;'>";
								$actions .= "<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$data["id"]."&candidate_id=".$candidate_id."';}\"><img src='../images/cancel.png' style='width:20px; height:20px;' title='Delete'></a>";
								
								echo $t->row([$i,
											$actions,
											$data["company_name"],
											$data["location"],
											$data["tasks"],
											$data["phone"],
											$data["join_at"],
											$data["last_at"],
											$data["leaving_reason"]],
											["align='right' width='3%'",
											"",
											"",
											"",
											"",
											"align='right'",
											"align='right' nowrap",
											"align='right' nowrap",
											""]);
							}
						?>
					<?=$t->end();?>
				</div>
			</div>
				<?=$f->input("add","Add","type='button' onclick=\"window.location='".str_replace("_list","_add",$_SERVER["PHP_SELF"])."?candidate_id=".$candidate_id."';\"","btn btn-info");?>
		</div>
	</div>
</body>			
