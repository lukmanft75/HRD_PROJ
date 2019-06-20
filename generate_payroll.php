<?php
	function generate_payroll($periode,$employee_id){
		global $db;
		$imonth = substr($periode,5,2) * 1;
		$_periode = $periode."-".date("t",mktime(0,0,0,$imonth,1,substr($periode,0,4)));
		$iuran_pk_limit = $db->fetch_single_data("bpjs_pk_limit","amount",["valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]);
		$jaminan_pensiun_limit = $db->fetch_single_data("bpjs_jaminan_pensiun_limit","amount",["valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]);
		$periode = $periode."-01";
		$_lastperiode = date("Y-m-d",mktime(0,0,0,$imonth-1,1,substr($periode,0,4)));
		$joinmonth = explode(",",$db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Bulan join dari,sampai:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]))[0];
		$endjoinmonth = explode(",",$db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Bulan join dari,sampai:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]))[1];
		$maritalStatus = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "Status:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]);
		$Npwp = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "NPWP:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]);
		$Thp = $db->fetch_single_data("employee_payroll_params","params_value",["employee_id" => $employee_id, "param" => "THP:LIKE", "valid_at" => $_periode.":<="],["valid_at DESC, id DESC"]);
		$is_tax_allowance = false;
		$tax_allowance_percentage = 0;
		$tax_allowance_amount = 0;
		$status = $db->fetch_single_data("employee_payrolls","status",["employee_id" => $employee_id, "periode" => $periode]);
		if($status == 0){
			if($imonth > $joinmonth){//locking past periodes
				$xx = $joinmonth;
				$_pastperiodes = date("Y-m-d",mktime(0,0,0,$xx,1,substr($periode,0,4)));
				while($_pastperiodes < $_periode){
					$db->addtable("employee_payrolls");
					$db->where("employee_id",$employee_id);
					$db->where("periode",$_lastperiode);
					$db->addfield("status");	$db->addvalue("1");
					$db->update();
					$xx++;
					$_pastperiodes = date("Y-m-d",mktime(0,0,0,$xx,1,substr($periode,0,4)));
				}
			}
		
			$db->addtable("employee_payrolls");
			$db->where("employee_id",$employee_id);
			$db->where("periode",$periode);
			$db->delete_();

			//FIXED INCOME
			$settings = $db->fetch_all_data("employee_payroll_setting",[],"employee_id='".$employee_id."' AND payroll_type_id='1' AND valid_at <= '".$_periode."' AND (percentage <> 0 OR nominal <> 0) GROUP BY payroll_item_id","payroll_item_id");
			foreach($settings as $key => $_setting){
				$amount = 0;
				$ytd = 0;
				$setting = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$employee_id."' AND payroll_type_id='".$_setting["payroll_type_id"]."' AND payroll_item_id = '".$_setting["payroll_item_id"]."' AND valid_at <= '".$_periode."'","valid_at DESC,id DESC")[0];
				//if($setting["percentage"] != 0 || $setting["nominal"] != 0){
					if($setting["payroll_item_id"] == "1") $basic_salary = $setting["nominal"];

					if($setting["nominal"] != 0){
						$amount = $setting["nominal"];
					} else if($setting["percentage"] != 0){
						if($setting["payroll_item_id"] == "6"){//Iuran PK
							if($basic_salary > $iuran_pk_limit) $amount = $setting["percentage"]/100 * $iuran_pk_limit;
							else $amount = $setting["percentage"]/100 * $basic_salary;
						}else if($setting["payroll_item_id"] == "7"){//Jaminan Pensiun
							if($basic_salary > $jaminan_pensiun_limit) $amount = $setting["percentage"]/100 * $jaminan_pensiun_limit;
							else $amount = $setting["percentage"]/100 * $basic_salary;
						} else {
							$amount = $setting["percentage"]/100 * $basic_salary;
						}
					}

					if($imonth == $joinmonth) $ytd = $amount;
					if($imonth > $joinmonth) {
						$lastytd = $db->fetch_single_data("employee_payrolls","ytd",["employee_id" => $employee_id, "periode" => $_lastperiode,"payroll_item_id" => $setting["payroll_item_id"]]);
						$ytd = $amount + $lastytd;
					}
					if($setting["payroll_item_id"] == "1") $basic_salary_ytd = $ytd;

					$db->addtable("employee_payrolls");
					$db->addfield("employee_id");		$db->addvalue($employee_id);
					$db->addfield("periode");			$db->addvalue($periode);
					$db->addfield("payroll_type_id");	$db->addvalue($setting["payroll_type_id"]);
					$db->addfield("payroll_item_id");	$db->addvalue($setting["payroll_item_id"]);
					$db->addfield("name");				$db->addvalue($setting["name"]);
					$db->addfield("amount");			$db->addvalue($amount);
					$db->addfield("ytd");				$db->addvalue($ytd);
					$db->addfield("taxable");			$db->addvalue($setting["taxable"]);
					$inserting = $db->insert();
				//}
			}

			//VARIABLE INCOME
			$settings = $db->fetch_all_data("employee_payroll_setting",[],"employee_id='".$employee_id."' AND payroll_type_id='2' AND valid_at <= '".$_periode."' AND (percentage <> 0 OR nominal <> 0) GROUP BY payroll_item_id","id");
			foreach($settings as $key => $_setting){
				$amount = 0;
				$ytd = 0;
				$setting = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$employee_id."' AND payroll_type_id='".$_setting["payroll_type_id"]."' AND payroll_item_id = '".$_setting["payroll_item_id"]."' AND valid_at <= '".$_periode."'","valid_at DESC,id DESC")[0];
				//if($setting["percentage"] != 0 || $setting["nominal"] != 0){
					if($setting["payroll_item_id"] != 8){//bukan tunjangan pajak
						if($setting["nominal"] != 0){
							$amount = $setting["nominal"];
						} else if($setting["percentage"] != 0){
							$amount = $setting["percentage"]/100 * $basic_salary;
						}

						if($imonth == $joinmonth) $ytd = $amount;
						if($imonth > $joinmonth) {
							$lastytd = $db->fetch_single_data("employee_payrolls","ytd",["employee_id" => $employee_id, "periode" => $_lastperiode,"payroll_item_id" => $setting["payroll_item_id"]]);
							$ytd = $amount + $lastytd;
						}
					} else {
						$amount = 0;
						$ytd = 0;
						$is_tax_allowance = true;
						$tax_allowance_percentage = $setting["percentage"];
						$tax_allowance_amount = $setting["nominal"];
					}

					$db->addtable("employee_payrolls");
					$db->addfield("employee_id");		$db->addvalue($employee_id);
					$db->addfield("periode");			$db->addvalue($periode);
					$db->addfield("payroll_type_id");	$db->addvalue($setting["payroll_type_id"]);
					$db->addfield("payroll_item_id");	$db->addvalue($setting["payroll_item_id"]);
					$db->addfield("name");				$db->addvalue($setting["name"]);
					$db->addfield("amount");			$db->addvalue($amount);
					$db->addfield("ytd");				$db->addvalue($ytd);
					$db->addfield("taxable");			$db->addvalue($setting["taxable"]);
					$inserting = $db->insert();
				//}
			}

			//TAX
			$settings = $db->fetch_all_data("employee_payroll_setting",[],"employee_id='".$employee_id."' AND payroll_type_id='3' AND valid_at <= '".$_periode."' AND (percentage <> 0 OR nominal <> 0) GROUP BY payroll_item_id","id");
			foreach($settings as $key => $_setting){
				$ytd = 0;
				$lastytd = 0;
				$setting = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$employee_id."' AND payroll_type_id='".$_setting["payroll_type_id"]."' AND payroll_item_id = '".$_setting["payroll_item_id"]."' AND valid_at <= '".$_periode."'","valid_at DESC,id DESC")[0];
				if($setting["percentage"] != 0 || $setting["nominal"] != 0){
					//Cari YTD
					if($setting["nominal"] != 0){
						$ytd = $setting["nominal"];
					} else if($setting["percentage"] != 0){
						if($setting["payroll_item_id"] == "40"){//Jaminan Pensiun
							//Cari Last YTD
							if($imonth > $joinmonth) $lastytd = $db->fetch_single_data("employee_payrolls","ytd",["employee_id" => $employee_id, "periode" => $_lastperiode,"payroll_item_id" => $setting["payroll_item_id"]]);

							if($basic_salary > $jaminan_pensiun_limit) 
								$ytd = $setting["percentage"]/100 * $jaminan_pensiun_limit;
							else
								$ytd = $setting["percentage"]/100 * $basic_salary;

							$ytd += $lastytd;
						} else {
							$ytd = $setting["percentage"]/100 * $basic_salary_ytd;
						}

					}

					if($setting["payroll_item_id"] == "39") $Jht = $ytd;
					if($setting["payroll_item_id"] == "40") $JaminanPensiun = $ytd;

					$db->addtable("employee_payrolls");
					$db->addfield("employee_id");		$db->addvalue($employee_id);
					$db->addfield("periode");			$db->addvalue($periode);
					$db->addfield("payroll_type_id");	$db->addvalue($setting["payroll_type_id"]);
					$db->addfield("payroll_item_id");	$db->addvalue($setting["payroll_item_id"]);
					$db->addfield("name");				$db->addvalue($setting["name"]);
					$db->addfield("ytd");				$db->addvalue($ytd);
					$db->addfield("taxable");			$db->addvalue($setting["taxable"]);
					$inserting = $db->insert();
				}
			}

			//OPERATIONAL DEDUCTION
			$PendapatanTetapYtd = $db->fetch_single_data("employee_payrolls","concat(sum(ytd))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => 1,"taxable" => 1]);
			$PendapatanTidakTetapYtd = $db->fetch_single_data("employee_payrolls","concat(sum(ytd))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => 2,"taxable" => 1]);
			$jumlahPendapatanYtd = $PendapatanTetapYtd + $PendapatanTidakTetapYtd;

			if(($jumlahPendapatanYtd*5/100) > (($imonth - $joinmonth + 1) * 500000)) 
				$OperationalDeduction = ($imonth - $joinmonth + 1) * 500000;
			else 
				$OperationalDeduction = $jumlahPendapatanYtd * 5/100;

			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("OPERATIONAL DEDUCTION");
			$db->addfield("ytd");				$db->addvalue($OperationalDeduction);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();

			//ANNUITY FIXED INCOME
			$PendapatanTetapSetahun = ($PendapatanTetapYtd - ($Jht + $JaminanPensiun + $OperationalDeduction)) * (($endjoinmonth - $joinmonth+1) / ($imonth - $joinmonth + 1));
			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("ANNUITY FIXED INCOME");
			$db->addfield("ytd");				$db->addvalue($PendapatanTetapSetahun);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();

			//NON TAXABLE DEDUCTION
			$Ptkp = $db->fetch_single_data("ptkp","nominal",["name" => $maritalStatus.":LIKE"]);
			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("NON TAXABLE DEDUCTION");
			$db->addfield("ytd");				$db->addvalue($Ptkp);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();

			//ANNUITY FIXED INCOME BEFORE TAX
			$PendapatanTetapKenaPajakSetahun = substr(ceil($PendapatanTetapSetahun - $Ptkp),0,-3)."000";
			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("ANNUITY FIXED INCOME BEFORE TAX");
			$db->addfield("ytd");				$db->addvalue($PendapatanTetapKenaPajakSetahun);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();


			//ANNUITY FIXED INCOME TAX
			if($Npwp == "Yes"){
				//PPh21_Pendapatan_Tetap_5
				if($PendapatanTetapKenaPajakSetahun < 0)
					$PPh21_Pendapatan_Tetap_5 = 0;
				else {
					if($PendapatanTetapKenaPajakSetahun < 50000000)
						$PPh21_Pendapatan_Tetap_5 = $PendapatanTetapKenaPajakSetahun * 5/100;
					else {
						if($PendapatanTetapKenaPajakSetahun > 50000000)
							$PPh21_Pendapatan_Tetap_5 = 50000000 * 5/100;
						else
							$PPh21_Pendapatan_Tetap_5 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_15
				if($PendapatanTetapKenaPajakSetahun <= 50000000)
					$PPh21_Pendapatan_Tetap_15 = 0;
				else {
					if($PendapatanTetapKenaPajakSetahun >= 250000000)
						$PPh21_Pendapatan_Tetap_15 = (250000000 - 50000000) * 15/100;
					else {
						if($PendapatanTetapKenaPajakSetahun <= 250000000)
							$PPh21_Pendapatan_Tetap_15 = ($PendapatanTetapKenaPajakSetahun - 50000000) * 15/100;
						else
							$PPh21_Pendapatan_Tetap_15 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_25
				if($PendapatanTetapKenaPajakSetahun <= 250000000)
					$PPh21_Pendapatan_Tetap_25 = 0;
				else {
					if($PendapatanTetapKenaPajakSetahun >= 500000000)
						$PPh21_Pendapatan_Tetap_25 = (500000000 - 250000000) * 25/100;
					else {
						if($PendapatanTetapKenaPajakSetahun <= 500000000)
							$PPh21_Pendapatan_Tetap_25 = ($PendapatanTetapKenaPajakSetahun - 250000000) * 25/100;
						else
							$PPh21_Pendapatan_Tetap_25 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_30
				if($PendapatanTetapKenaPajakSetahun > 500000000)
					$PPh21_Pendapatan_Tetap_30 = ($PPh21_Pendapatan_Tetap_30 - 500000000) * 30/100;
				else
					$PPh21_Pendapatan_Tetap_30 = 0;
			} else { //tidak punya NPWP maka besar persentase ditambah 20% nya
				//PPh21_Pendapatan_Tetap_5
				if($PendapatanTetapKenaPajakSetahun < 0)
					$PPh21_Pendapatan_Tetap_5 = 0;
				else {
					if($PendapatanTetapKenaPajakSetahun < 50000000)
						$PPh21_Pendapatan_Tetap_5 = $PendapatanTetapKenaPajakSetahun * 6/100;
					else {
						if($PendapatanTetapKenaPajakSetahun > 50000000)
							$PPh21_Pendapatan_Tetap_5 = 50000000 * 6/100;
						else
							$PPh21_Pendapatan_Tetap_5 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_15
				if($PendapatanTetapKenaPajakSetahun <= 50000000)
					$PPh21_Pendapatan_Tetap_15 = 0;
				else {
					if($PendapatanTetapKenaPajakSetahun >= 250000000)
						$PPh21_Pendapatan_Tetap_15 = (250000000 - 50000000) * 18/100;
					else {
						if($PendapatanTetapKenaPajakSetahun <= 250000000)
							$PPh21_Pendapatan_Tetap_15 = ($PendapatanTetapKenaPajakSetahun - 50000000) * 18/100;
						else
							$PPh21_Pendapatan_Tetap_15 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_25
				if($PendapatanTetapKenaPajakSetahun <= 250000000)
					$PPh21_Pendapatan_Tetap_25 = 0;
				else {
					if($PendapatanTetapKenaPajakSetahun >= 500000000)
						$PPh21_Pendapatan_Tetap_25 = (500000000 - 250000000) * 30/100;
					else {
						if($PendapatanTetapKenaPajakSetahun <= 500000000)
							$PPh21_Pendapatan_Tetap_25 = ($PendapatanTetapKenaPajakSetahun - 250000000) * 30/100;
						else
							$PPh21_Pendapatan_Tetap_25 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_30
				if($PendapatanTetapKenaPajakSetahun > 500000000)
					$PPh21_Pendapatan_Tetap_30 = ($PPh21_Pendapatan_Tetap_30 - 500000000) * 36/100;
				else
					$PPh21_Pendapatan_Tetap_30 = 0;
			}

			$PPh21_Pendapatan_Tetap = $PPh21_Pendapatan_Tetap_5 + $PPh21_Pendapatan_Tetap_15 + $PPh21_Pendapatan_Tetap_25 + $PPh21_Pendapatan_Tetap_30;

			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("ANNUITY FIXED INCOME TAX");
			$db->addfield("ytd");				$db->addvalue($PPh21_Pendapatan_Tetap);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();



			//YTD FIXED INCOME TAX
			$PPh21PendapatanTetapMtd = $PPh21_Pendapatan_Tetap * (($imonth - $joinmonth + 1) / ($endjoinmonth - $joinmonth + 1));
			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("YTD FIXED INCOME TAX");
			$db->addfield("ytd");				$db->addvalue($PPh21PendapatanTetapMtd);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();


			//YTD VARIABLE INCOME TAX
			$PendapatanTetapTidakKenaPajak = substr(ceil($PendapatanTetapSetahun - $Ptkp + $PendapatanTidakTetapYtd),0,-3)."000";

			if($Npwp == "Yes"){
				//PPh21_Pendapatan_Tetap_Tidak_Tetap_5
				if($PendapatanTetapTidakKenaPajak < 0)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = 0;
				else {
					if($PendapatanTetapTidakKenaPajak < 50000000)
						$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = $PendapatanTetapTidakKenaPajak * 5/100;
					else {
						if($PendapatanTetapTidakKenaPajak > 50000000)
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = 50000000 * 5/100;
						else
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_Tidak_Tetap_15
				if($PendapatanTetapTidakKenaPajak <= 50000000)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = 0;
				else {
					if($PendapatanTetapTidakKenaPajak >= 250000000)
						$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = (250000000 - 50000000) * 15/100;
					else {
						if($PendapatanTetapTidakKenaPajak <= 250000000)
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = ($PendapatanTetapTidakKenaPajak - 50000000) * 15/100;
						else
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_Tidak_Tetap_25
				if($PendapatanTetapTidakKenaPajak <= 250000000)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = 0;
				else {
					if($PendapatanTetapTidakKenaPajak >= 500000000)
						$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = (500000000 - 250000000) * 25/100;
					else {
						if($PendapatanTetapTidakKenaPajak <= 500000000)
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = ($PendapatanTetapTidakKenaPajak - 250000000) * 25/100;
						else
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_Tidak_Tetap_30
				if($PendapatanTetapTidakKenaPajak > 500000000)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_30 = ($PPh21_Pendapatan_Tetap_Tidak_Tetap_30 - 500000000) * 30/100;
				else
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_30 = 0;
			} else {
				//PPh21_Pendapatan_Tetap_Tidak_Tetap_5
				if($PendapatanTetapTidakKenaPajak < 0)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = 0;
				else {
					if($PendapatanTetapTidakKenaPajak < 50000000)
						$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = $PendapatanTetapTidakKenaPajak * 6/100;
					else {
						if($PendapatanTetapTidakKenaPajak > 50000000)
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = 50000000 * 6/100;
						else
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_5 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_Tidak_Tetap_15
				if($PendapatanTetapTidakKenaPajak <= 50000000)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = 0;
				else {
					if($PendapatanTetapTidakKenaPajak >= 250000000)
						$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = (250000000 - 50000000) * 18/100;
					else {
						if($PendapatanTetapTidakKenaPajak <= 250000000)
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = ($PendapatanTetapTidakKenaPajak - 50000000) * 18/100;
						else
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_15 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_Tidak_Tetap_25
				if($PendapatanTetapTidakKenaPajak <= 250000000)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = 0;
				else {
					if($PendapatanTetapTidakKenaPajak >= 500000000)
						$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = (500000000 - 250000000) * 30/100;
					else {
						if($PendapatanTetapTidakKenaPajak <= 500000000)
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = ($PendapatanTetapTidakKenaPajak - 250000000) * 30/100;
						else
							$PPh21_Pendapatan_Tetap_Tidak_Tetap_25 = 0;
					}
				}

				//PPh21_Pendapatan_Tetap_Tidak_Tetap_30
				if($PendapatanTetapTidakKenaPajak > 500000000)
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_30 = ($PPh21_Pendapatan_Tetap_Tidak_Tetap_30 - 500000000) * 36/100;
				else
					$PPh21_Pendapatan_Tetap_Tidak_Tetap_30 = 0;
			}
			$PPh21_Pendapatan_Tetap_Tidak_Tetap = $PPh21_Pendapatan_Tetap_Tidak_Tetap_5 + $PPh21_Pendapatan_Tetap_Tidak_Tetap_15 + $PPh21_Pendapatan_Tetap_Tidak_Tetap_25 + $PPh21_Pendapatan_Tetap_Tidak_Tetap_30;
			$PPh21PajakPendapatanTidakTetapMtd = $PPh21_Pendapatan_Tetap_Tidak_Tetap - $PPh21_Pendapatan_Tetap;

			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("YTD VARIABLE INCOME TAX");
			$db->addfield("ytd");				$db->addvalue($PPh21PajakPendapatanTidakTetapMtd);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();


			//YTD INCOME TAX
			$PPh21Mtd = $PPh21PendapatanTetapMtd + $PPh21PajakPendapatanTidakTetapMtd;
			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("YTD INCOME TAX");
			$db->addfield("ytd");				$db->addvalue($PPh21Mtd);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();



			//YTD INCOME TAX UNTIL LAST MONTH
			if($imonth > $joinmonth && $imonth <= $endjoinmonth)
				$PPh21UntilLastMonth = $db->fetch_single_data("employee_payrolls","ytd",["employee_id" => $employee_id, "periode" => $_lastperiode,"name" => "YTD INCOME TAX:LIKE"]);
			else 
				$PPh21UntilLastMonth = 0;

			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("YTD INCOME TAX UNTIL LAST MONTH");
			$db->addfield("ytd");				$db->addvalue($PPh21UntilLastMonth);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();


			//INCOME TAX
			$PPh21 = $PPh21Mtd - $PPh21UntilLastMonth;
			$db->addtable("employee_payrolls");
			$db->addfield("employee_id");		$db->addvalue($employee_id);
			$db->addfield("periode");			$db->addvalue($periode);
			$db->addfield("payroll_type_id");	$db->addvalue(3);
			$db->addfield("payroll_item_id");	$db->addvalue(0);
			$db->addfield("name");				$db->addvalue("INCOME TAX");
			$db->addfield("ytd");				$db->addvalue($PPh21);
			$db->addfield("taxable");			$db->addvalue(1);
			$inserting = $db->insert();

			//DEDUCTION
			$settings = $db->fetch_all_data("employee_payroll_setting",[],"employee_id='".$employee_id."' AND payroll_type_id='4' AND valid_at <= '".$_periode."' AND (percentage <> 0 OR nominal <> 0) GROUP BY payroll_item_id","id");
			foreach($settings as $key => $_setting){
				$amount = 0;
				$ytd = 0;
				$setting = $db->fetch_all_data("employee_payroll_setting",[],"employee_id = '".$employee_id."' AND payroll_type_id='".$_setting["payroll_type_id"]."' AND payroll_item_id = '".$_setting["payroll_item_id"]."' AND valid_at <= '".$_periode."'","valid_at DESC,id DESC")[0];
				if($setting["percentage"] != 0 || $setting["nominal"] != 0){
					if(stripos(" ".$setting["name"],"TAX INCOME") > 0){//TAX INCOME
						$amount = $PPh21;
					} else {
						if($setting["nominal"] != 0){
							$amount = $setting["nominal"];
						} else if($setting["percentage"] != 0){
							if(stripos(" ".$setting["name"],"JAMINAN PENSIUN BPJS") > 0){//JAMINAN PENSIUN BPJS PK / TK
								if($basic_salary > $jaminan_pensiun_limit) $amount = $setting["percentage"]/100 * $jaminan_pensiun_limit;
								else $amount = $setting["percentage"]/100 * $basic_salary;
							} else if (stripos(" ".$setting["name"],"IURAN PK") > 0 || stripos(" ".$setting["name"],"IURAN TK") > 0 ) {
								if($basic_salary > $iuran_pk_limit) $amount = $setting["percentage"]/100 * $iuran_pk_limit;
								else $amount = $setting["percentage"]/100 * $basic_salary;
							} else {
								$amount = $setting["percentage"]/100 * $basic_salary;
							}
						}
					}

					if($imonth == $joinmonth) $ytd = $amount;
					if($imonth > $joinmonth) {
						$lastytd = $db->fetch_single_data("employee_payrolls","ytd",["employee_id" => $employee_id, "periode" => $_lastperiode,"payroll_item_id" => $setting["payroll_item_id"]]);
						$ytd = $amount + $lastytd;
					}

					$db->addtable("employee_payrolls");
					$db->addfield("employee_id");		$db->addvalue($employee_id);
					$db->addfield("periode");			$db->addvalue($periode);
					$db->addfield("payroll_type_id");	$db->addvalue($setting["payroll_type_id"]);
					$db->addfield("payroll_item_id");	$db->addvalue($setting["payroll_item_id"]);
					$db->addfield("name");				$db->addvalue($setting["name"]);
					$db->addfield("amount");			$db->addvalue($amount);
					$db->addfield("ytd");				$db->addvalue($ytd);
					$db->addfield("taxable");			$db->addvalue($setting["taxable"]);
					$inserting = $db->insert();
				}
			}
			//===========================================
			//TOTAL FIXED INCOME
			$totalFixed = $db->fetch_single_data("employee_payrolls","concat(sum(amount))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => "1"]);
			$totalFixedYtd = $db->fetch_single_data("employee_payrolls","concat(sum(ytd))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => "1"]);
			//TOTAL VARIABLE INCOME
			$totalVariable = $db->fetch_single_data("employee_payrolls","concat(sum(amount))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => "2"]);
			$totalVariableYtd = $db->fetch_single_data("employee_payrolls","concat(sum(ytd))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => "2"]);
			$excluding_thp = $db->fetch_all_data("employee_payroll_setting",["concat(sum(nominal)) as nominal"],"employee_id = '".$employee_id."' AND payroll_type_id='2' AND valid_at LIKE '".substr($periode,0,8)."%' AND excluding_thp='1'","valid_at DESC,id DESC")[0]["nominal"];
			//INCOME BEFORE TAX w/o TUNJANGAN PAJAK
			$totalIncomeBeforeTax = $totalFixed + $totalVariable;
			$totalIncomeBeforeTaxYtd = $totalFixedYtd + $totalVariableYtd;
			//TOTAL DEDUCTION
			$totalDeduction = $db->fetch_single_data("employee_payrolls","concat(sum(amount))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => "4"]);
			$totalDeductionYtd = $db->fetch_single_data("employee_payrolls","concat(sum(ytd))",["employee_id" => $employee_id,"periode" => $periode,"payroll_type_id" => "4"]);
			//TAX ALLOWANCE
			if($is_tax_allowance){
				if($tax_allowance_amount == 0 && $tax_allowance_percentage != 0 && $Thp > 0){
					$tax_allowance_amount = $Thp - (($totalIncomeBeforeTax - $excluding_thp) - $totalDeduction);
				}

				if($imonth == $joinmonth) $tax_allowance_amount_ytd = $tax_allowance_amount;
				if($imonth > $joinmonth) {
					$lastytd = $db->fetch_single_data("employee_payrolls","ytd",["employee_id" => $employee_id, "periode" => $_lastperiode,"payroll_type_id" => "2","payroll_item_id" => "8"]);
					$tax_allowance_amount_ytd = $tax_allowance_amount + $lastytd;
				}

				if($tax_allowance_amount != 0 || $tax_allowance_amount_ytd != 0){
					$db->addtable("employee_payrolls");
					$db->where("employee_id",$employee_id);
					$db->where("periode",$periode);
					$db->where("payroll_type_id","2");
					$db->where("payroll_item_id","8");
					$db->addfield("amount");			$db->addvalue($tax_allowance_amount);
					$db->addfield("ytd");				$db->addvalue($tax_allowance_amount_ytd);
					$db->update();
				}
			}

			if($Thp == 0) $Thp = ($totalIncomeBeforeTax + $tax_allowance_amount) - $totalDeduction;

			$returns["result"] = "success";
		} else {
			$returns["result"] = "error:payroll_locked";
		}


		return $returns;
	}
?>