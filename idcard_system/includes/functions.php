<?php

	function getSuperAdminPassword($db){
		$sql="SELECT password FROM users WHERE role = 'super_admin' AND id = ".$_SESSION['user']['id'];
		if($result = $db->query($sql)){
	
			if($result->num_rows>0){
				return $result->fetch_assoc()['password'];
				
			}
			else{
				return 0;
			}
		}
	}
	function updateSuperAdminPassword($db,$new){
		$sql="UPDATE users SET password ='".md5($new)."' WHERE role = 'super_admin' AND id = ".$_SESSION['user']['id'];

		if($db->query($sql)){
			return 1;
		}
		return 0;
	}

	function getUsersByCompany($db,$company_id){
		$sql="SELECT id,name,role FROM users WHERE role != 'super_admin' AND company_id = ".$company_id;
		if($result = $db->query($sql)){
			
			if($result->num_rows>0){
				$users = array();
				while($row = $result->fetch_assoc()){
					$users[] = $row;	
				}
				
				return $users;
			}
			else{
				return 0;
			}
		}
		return 0;	
	}

	function updateUser($db,$id,$company_id,$name,$password){
		$sql="UPDATE users SET password ='".md5($password)."', name = '$name' WHERE id = $id AND company_id = $company_id";

		// echo "$sql";
		if($db->query($sql)){
			return 1;
		}
		return 0;
	}
	
	function getMyCompany($db){
		if($result = $db->query("SELECT * FROM company WHERE id = ".$_SESSION['user']['company_id'])){
			if($result->num_rows>0){
				$company = $result->fetch_assoc();
				return $company;
			}
			else{
				return 0;
			}
		}
	}

	function getAllCompanies($db){
		if($result = $db->query("SELECT * FROM company WHERE name!='super_admin'")){
			if($result->num_rows>0){
				$companies = array();
				while($row = $result->fetch_assoc()){
					$companies[] = $row;	
				}
				
				return $companies;
			}
			else{
				return 0;
			}
		}
		return 0;	
	}

	function getMyCompanyDataTableName($db){
		if($result = $db->query("SELECT * FROM company WHERE id = ".$_SESSION['user']['company_id'])){
			if($result->num_rows>0){
				$company = $result->fetch_assoc();
				return $company['data_table'];
			}
			else{
				return 0;
			}
		}
	}

	function getDataTableFieldList($db,$table_name){
		$sql = "show columns from ".$table_name;
		if($res = $db->query($sql)){
			$fields = array();
			if($res->num_rows>0){

				while($row = $res->fetch_assoc()){
					$fields[$row['Field']] = $row['Field'];	
				}
				return $fields;
			}
			return $fields;
		}
		return 0;
	}

	function insertEmployeeData($db,$table_name,$data = array()){
		$keys = array_keys($data);
		$values = array_values($data);


		$fields = implode(",", $keys);
		$values_in_string = implode(",", $values);
		
		$sql = "INSERT INTO $table_name($fields) VALUES($values_in_string)";

		// echo "$sql";
		
		if($db->query($sql)){
			return 1;
		}
		return 0;
	}


	function getEmployeeData($db,$table_name){
		$sql = "SELECT * FROM $table_name INNER JOIN card_status ON $table_name.id=card_status.emp_data_id WHERE card_status.company_id = ".$_SESSION['user']['company_id'] ." ORDER BY ${table_name}.name";
		if($res = $db->query($sql)){

			$employees = array();
			if($res->num_rows>0){
				while($row = $res->fetch_assoc()){
					$employees[] = $row;
				}
				return $employees;
			}
			return $employees;
		}
		return 0;
	}

	function getLastEmployeeData($db,$table_name){
		$sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1 ";
		$result = $db->query($sql);

		if($result->num_rows>0)
			return $last_employee = $result->fetch_assoc();
		return 0;
	}

	function getEmployeeDataWithNoIssue($db,$table_name){
		$sql = "SELECT * FROM $table_name INNER JOIN card_status ON $table_name.id=card_status.emp_data_id WHERE card_status.company_id = ".$_SESSION['user']['company_id']." AND card_status.printed = 0";
		if($res = $db->query($sql)){

			$employees = array();
			if($res->num_rows>0){
				while($row = $res->fetch_assoc()){
					$employees[] = $row;
				}
				return $employees;
			}
			return $employees;
		}
		return 0;
	}

	function getEmployeeDataById($db,$table_name,$id){
		$sql = "SELECT * FROM $table_name INNER JOIN card_status ON $table_name.id=card_status.emp_data_id WHERE card_status.company_id = ".$_SESSION['user']['company_id']." AND $table_name.id = $id";
		if($res = $db->query($sql)){

			$employees = array();
			if($res->num_rows>0){
				
				return $res->fetch_assoc();
			}
			return 0;
		}
		return 0;
	}

	function updateEmployeeCardPrintStatus($db,$id){

		date_default_timezone_set("Asia/Kolkata");
		$d = getdate();
		$date_string = $d['mday']."-".$d['mon']."-".$d['year']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
		$sql = "UPDATE card_status SET printed_date = '$date_string' , printed = 1 WHERE emp_data_id = $id AND company_id = ".$_SESSION['user']['company_id'];
		// echo "$sql<br>";

		if($db->query($sql)){
			return 1;
		}
		return 0;

	}

	function updateEmployeeCardDuplicateStatus($db,$id,$reason){
		$sql = "UPDATE card_status SET reason_for_duplicate = '$reason' WHERE emp_data_id = $id AND company_id = ".$_SESSION['user']['company_id'];

		if($db->query($sql)){
			return 1;
		}
		return 0;		
	}

	function updateEmployeeQRCode($db,$table_name,$value,$id){
		$sql = "UPDATE $table_name SET qr = '$value' WHERE id = $id";
		echo "$sql";
		if($db->query($sql)){
			return 1;
		}
		return 0;
	}

	function deleteAllEmployeeData($db,$table_name){

		$sql="TRUNCATE TABLE $table_name";

		if($db->query($sql)){
			return 1;
		}
		return 0;
	}

	function deleteEmployeeData($db,$table_name,$id){

		$sql="DELETE FROM $table_name WHERE id = $id";

		if($db->query($sql)){
			return 1;
		}
		return 0;
	}

	function insertCardStatus($db,$data = array()){
		
		$keys = array_keys($data);
		$values = array_values($data);

		$fields = implode(",", $keys);
		$values_in_string = implode(",", $values);
		
		$sql = "INSERT INTO card_status($fields) VALUES($values_in_string)";
		
		if($db->query($sql)){
			return 1;
		}
		return 0;

	}

	function updateCardStatus($db,$data = array(),$id){

		$keys = array_keys($data);
		$values = array_values($data);

		$satements = array();
		
		for($i=0;$i<count($keys);$i++){
			$satements[] = $keys[$i]." = ".$values[$i];
		}


		$sql = "UPDATE card_status SET ".implode(",",$satements)." WHERE emp_data_id = $id AND company_id = ".$_SESSION['user']['company_id'];

		if($db->query($sql)){
			return 1;
		}
		return 0;
	}

	function deleteAllEmployeeCardStatus($db){
		
		$sql = "DELETE FROM card_status WHERE company_id = ".$_SESSION['user']['company_id'];
		
		if($db->query($sql)) return 1;

		return 0;
	}

	function deleteEmployeeCardStatus($db,$emp_data_id){
		
		$sql = "DELETE FROM card_status WHERE company_id = ".$_SESSION['user']['company_id']." AND emp_data_id = $emp_data_id";
		
		if($db->query($sql)) return 1;

		return 0;
	}

	function getAllCards($db){
		$sql = "SELECT * FROM cards WHERE company_id = ".$_SESSION['user']['company_id'];

		$cards=array();		
		if($result=$db->query($sql)){
			if($result->num_rows>0){
				while($row = $result->fetch_assoc()){
					$cards[] = $row;
				}
				return $cards;
			}
			return $cards;
		}
		return 0;
	}
	function getCardById($db,$id){
		$sql="SELECT * FROM cards WHERE id = ".$id;
		if($res = $db->query($sql)){

			if($res->num_rows>0){
				return $res->fetch_assoc();
			}
			return 0;
		}
		return 0;
	}

	function generateQRCode($table_name,$data = array(),$emp_id = "001"){

		$keys = array_keys($data);
		$values = array_values($data);

		$qr_string='';
		$qr_data = array();

		for($i=0;$i<count($keys);$i++){

			// Exclude data from qr code
			if($keys[$i] == FIELD_QR || $keys[$i] == FIELD_IMAGE || $keys[$i] == FIELD_SIGN || $keys[$i] == FIELD_DATE_OF_EXPIRY || $keys[$i] == FIELD_DATE_OF_BIRTH || $keys[$i] == FIELD_DEPARTMENT || $keys[$i] == FIELD_DESIGNATION) continue;

			// Include data into qr code
			$qr_data[] = getFieldLabel($keys[$i])." : ".$values[$i];
		}

		$qr_string = implode("\n", $qr_data);
		$filename = "qrcodes/$table_name"."_emp_".$emp_id.".png";

		QRcode::png($qr_string,$filename);
		return $filename;
	}

?>