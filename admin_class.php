<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}
	function login(){
		extract($_POST);		
		$qry = $this->db->query("SELECT * FROM users where name = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:homepage.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user() {
		$name = $this->db->real_escape_string($_POST['name']);
		$username = $this->db->real_escape_string($_POST['username']);
		$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : '';
		$type = $this->db->real_escape_string($_POST['type']);
		$establishment_id = $type == 1 ? 0 : $this->db->real_escape_string($_POST['establishment_id']);
		$id = $this->db->real_escape_string($_POST['id']);
	
		$data = "name = '$name', username = '$username'";
		if (!empty($password)) {
			$data .= ", password = '$password'";
		}
		$data .= ", type = '$type', establishment_id = '$establishment_id'";
	
		// $chk = $this->db->query("SELECT * FROM users WHERE username = ? AND id != ?", [$username, $id])->num_rows;
		$chk = $this->db->query("SELECT * FROM users WHERE username = '$username' AND id != '$id'")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
	
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO users SET " . $data);
		} else {
			$save = $this->db->query("UPDATE users SET " . $data . " WHERE id = " . $id);
		}
	
		if ($save) {
			return 2;
		}
	}


	 function save_user2() {
	 	$name = isset($_POST['name']) ? $_POST['name'] : '';
	 	$username = isset($_POST['username']) ? $_POST['username'] : '';
	 	$current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
	 	$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
	 	$type = isset($_POST['type']) ? $_POST['type'] : '';
	 	$establishment_id = isset($_POST['establishment_id']) ? $_POST['establishment_id'] : '';
	 	$id = isset($_POST['id']) ? $_POST['id'] : '';
	
	 	// Sanitize input data here
	
	 	$data = " name = '$name', username = '$username' ";
	
	 	// Check if a new password is provided
	 	if (!empty($new_password)) {
	 		// Verify the current password before updating
	 		$user = $this->db->query("SELECT * FROM users WHERE id = '$id'")->fetch_assoc();
	
	 		if (!password_verify($current_password, $user['password'])) {
 			// Current password is incorrect
	 			return 3;
	 		}
	
	 		// Use a more secure hashing algorithm, e.g., bcrypt
	 		$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
	 		$data .= ", password = '$hashed_password' ";
	 	}
	
	 	$data .= ", type = '$type' ";
	
	 	if ($type == 1) {
	 		$establishment_id = 0;
	 	}
	
	 	$data .= ", establishment_id = '$establishment_id' ";
	
	 	$chk = $this->db->query("SELECT * FROM users WHERE username = '$username' AND id != '$id'")->num_rows;
	
	 	if ($chk > 0) {
	 		return 2;
	 	}
	
	 	if (empty($id)) {
	 		$save = $this->db->query("INSERT INTO users SET " . $data);
	 	} else {
	 		$save = $this->db->query("UPDATE users SET " . $data . " WHERE id = " . $id);
	 	}
	
	 	if ($save) {
	 		return 1;
	 	}
	 }
	
	
	

	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", address = '$address' ";
		$data .= ", contact = '$contact' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * from complainants where email ='$email' ".(!empty($id) ? " and id != '$id' " : ''))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		if(empty($id))
			$save = $this->db->query("INSERT INTO complainants set $data");
		else
			$save = $this->db->query("UPDATE complainants set $data where id=$id ");
		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
				$qry = $this->db->query("SELECT * FROM complainants where id = $id ");
				if($qry->num_rows > 0){
					foreach ($qry->fetch_array() as $key => $value) {
						if($key != 'password' && !is_numeric($key))
							$_SESSION['login_'.$key] = $value;
					}
						return 1;
				}else{
					return 3;
				}
		}
	}
	// function update_account(){
	// 	extract($_POST);
	// 	$data = " name = '".$firstname.' '.$lastname."' ";
	// 	$data .= ", username = '$email' ";
	// 	if(!empty($password))
	// 	$data .= ", password = '".md5($password)."' ";
	// 	$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
	// 	if($chk > 0){
	// 		return 2;
	// 		exit;
	// 	}
	// 		$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
	// 	if($save){
	// 		$data = '';
	// 		foreach($_POST as $k => $v){
	// 			if($k =='password')
	// 				continue;
	// 			if(empty($data) && !is_numeric($k) )
	// 				$data = " $k = '$v' ";
	// 			else
	// 				$data .= ", $k = '$v' ";
	// 		}
	// 		if($_FILES['img']['tmp_name'] != ''){
	// 						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
	// 						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
	// 						$data .= ", avatar = '$fname' ";

	// 		}
	// 		$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
	// 		if($data){
	// 			foreach ($_SESSION as $key => $value) {
	// 				unset($_SESSION[$key]);
	// 			}
	// 			$login = $this->login2();
	// 			if($login)
	// 			return 1;
	// 		}
	// 	}
	// }

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['system'][$key] = $value;
		}

			return 1;
				}
	}

	function save_course(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','fid','type','amount')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM courses where course ='$course'".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO courses set $data");
			if($save){
				$id = $this->db->insert_id;
				foreach($fid as $k =>$v){
					$data = " course_id = '$id' ";
					$data .= ", description = '{$type[$k]}' ";
					$data .= ", amount = '{$amount[$k]}' ";
					$save2[] = $this->db->query("INSERT INTO fees set $data");
				}
				if(isset($save2))
					return 1;
			}
		}else{
			$save = $this->db->query("UPDATE courses set $data where id = $id");
			if($save){
				//and id not in (".implode(',',$fid).") 
				$this->db->query("DELETE FROM fees where course_id = $id ");
				foreach($fid as $k => $v){
					$feeData = " course_id = '$id' ";
					$feeData .= ", description = '{$type[$k]}' ";
					$feeData .= ", amount = '{$amount[$k]}' ";
				
					//if(empty($v)){
						$save2[] = $this->db->query("INSERT INTO fees set $feeData");
					//}//else{
						//$save2[] = $this->db->query("UPDATE fees set $feeData where id = $v");
					//}
				}
				
				if(isset($save2))
						return 1;
			}
		}

	}

	function save_course2(){
		// Check if the form data is being sent to the server
		if(!isset($_POST['course']) || !isset($_POST['fid']) || !isset($_POST['type']) || !isset($_POST['amount'])){
			return "Error: Form data not sent to the server.";
			exit;
		}
	
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$course = $_POST['course'];
		$fid = $_POST['fid'];
		$type = $_POST['type'];
		$amount = $_POST['amount'];
	
		$check = $this->db->query("SELECT * FROM courses where course ='$course'".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		$data = " course='$course' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO courses set $data");
			if($save){
				$id = $this->db->insert_id;
				foreach($fid as $k =>$v){
					$data = " course_id = '$id' ";
					$data .= ", description = '{$type[$k]}' ";
					$data .= ", amount = '{$amount[$k]}' ";
					$save2[] = $this->db->query("INSERT INTO fees set $data");
				}
				if(isset($save2))
					return 1;
			}
		}else{
			$save = $this->db->query("UPDATE courses set $data where id = $id");
			if($save){
				$this->db->query("DELETE FROM fees where course_id = $id and id not in (".implode(',',$fid).") ");
				foreach($fid as $k =>$v){
					$data = " course_id = '$id' ";
					$data .= ", description = '{$type[$k]}' ";
					$data .= ", amount = '{$amount[$k]}' ";
					if(empty($v)){
						$save2[] = $this->db->query("INSERT INTO fees set $data");
					}else{
						$save2[] = $this->db->query("UPDATE fees set $data where id = $v");
					}
				}
				if(isset($save2))
					return 1;
			}
		}
	}

	function delete_course(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM courses where id =$id");
		$delete2 = $this->db->query("DELETE FROM fees where course_id =$id");
		if($delete && $delete2){
			return 1;
		}
	}

	function save_student(){
		extract($_POST);
		$data = "";
		$transaction_data = "";
		$student_id = "";
	
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id', 'amount')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}else if($k == 'amount'){
				$transaction_data .= " amount='$v' ";
			}else if($k == 'id'){
				$student_id = $v;
			}
		}
	
		$check = $this->db->query("SELECT * FROM student where id_no ='$id_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
	
		if(empty($id)){
			$save = $this->db->query("INSERT INTO student set $data");
			$student_id = $this->db->insert_id; // get the id of the inserted student
		}else{
			$save = $this->db->query("UPDATE student set $data where id = $id");
		}
	
		if($save){
			$this->db->query("DELETE FROM transactions where student_id = $student_id");
			// save the transaction data
			$transaction_data .= " student_id='$student_id' ";
			$save_transaction = $this->db->query("INSERT INTO transactions set $transaction_data");
	
			if($save){
				return 1;
			}
		}
	}

	function save_student2(){
		extract($_POST);
		$data = "";
		$transaction_data = "";
		$student_id = "";
	
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id', 'amount')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}else if($k == 'amount'){
				$transaction_data .= " amount='$v' ";
			}else if($k == 'id'){
				$student_id = $v;
			}
		}
	
		$check = $this->db->query("SELECT * FROM student where id_no ='$id_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
	
		if(empty($id)){
			$save = $this->db->query("INSERT INTO student set $data");
			$student_id = $this->db->insert_id; // get the id of the inserted student
		}else{
			$save = $this->db->query("UPDATE student set $data where id = $id");
		}
	
		// Check if there's already a transaction for the student
		$transaction_check = $this->db->query("SELECT * FROM transactions where student_id ='$student_id'")->num_rows;
	
		if($transaction_check > 0){
			// Update the transaction data
			$save_transaction = $this->db->query("UPDATE transactions set $transaction_data where student_id = $student_id");
		}else{
			// Insert a new row for the transaction
			$transaction_data .= " student_id='$student_id' ";
			$save_transaction = $this->db->query("INSERT INTO transactions set $transaction_data");
		}
	
		if($save && $save_transaction){
			return 1;
		}
	}


	function delete_student(){
		extract($_POST);
		// Delete the transaction record with the given student_id
		$delete_transaction = $this->db->query("DELETE FROM transactions WHERE student_id = {$id}");
	
		// Delete the student record with the given id
		$delete = $this->db->query("DELETE FROM student WHERE id = {$id}");
	
		if($delete_transaction && $delete){
			return 1;
		}
	}


	function save_fees(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'total_fee'){
					$v = str_replace(',', '', $v);
				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM student_ef_list where ef_no ='$ef_no' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO student_ef_list set $data");
		}else{
			$save = $this->db->query("UPDATE student_ef_list set $data where id = $id");
		}
		if($save)
			return 1;
	}
	function delete_fees(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM student_ef_list where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_payment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'amount'){
					$v = str_replace(',', '', $v);
				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
    		$save = $this->db->query("INSERT INTO payments set $data");

		if($save)
        	$id= $this->db->insert_id;
	
		$stmt = $this->db->prepare("SELECT ef_id FROM payments WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$student_id = $row['ef_id'];

		// update the amount column in the transactions table
		$stmt = $this->db->prepare("UPDATE transactions SET amount = amount - ? WHERE student_id = ?");
		$stmt->bind_param("di", $amount, $student_id);
		$success = $stmt->execute();
		}else{
    	$save = $this->db->query("UPDATE payments set $data where id = $id");
		$stmt = $this->db->prepare("SELECT ef_id FROM payments WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$student_id = $row['ef_id'];

		// update the amount column in the transactions table
		$stmt = $this->db->prepare("UPDATE transactions SET amount = amount - ? WHERE student_id = ?");
		$stmt->bind_param("di", $amount, $student_id);
		$success = $stmt->execute();
		}

		if($save)
    		return json_encode(array('ef_id'=>$ef_id, 'pid'=>$id,'status'=>1));
	}

	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payments where id = ".$id);
		if($delete){
			return 1;
		}
	}
}