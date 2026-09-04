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
		$qry = $this->db->query("SELECT username,password
		FROM student WHERE username='$username' AND password='$password'");
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
	// function login2(){
		
	// 	extract($_POST);		
	// 	$qry = $this->db->query("SELECT * FROM complainants where email = '".$email."' and password = '".md5($password)."' ");
	// 	if($qry->num_rows > 0){
	// 		foreach ($qry->fetch_array() as $key => $value) {
	// 			if($key != 'passwors' && !is_numeric($key))
	// 				$_SESSION['login_'.$key] = $value;
	// 		}
	// 			return 1;
	// 	}else{
	// 		return 3;
	// 	}
	// }
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
		header("location:../index_std.php");
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
		$check = $this->db->query("SELECT * FROM courses where course ='$course' and level ='$level' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
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
	function save_pay() {
		extract($_POST);
	
		// Use prepared statements to prevent SQL injection
		$data = [
			'student_id' => $this->db->real_escape_string($student_id),
			'amount' => $this->db->real_escape_string($amount)
		];
	
		// Check if the student_id exists in the students table
		$checkStudent = $this->db->query("SELECT * FROM students WHERE student_id = '{$data['student_id']}'")->num_rows;
	
		if ($checkStudent > 0) {
			$query = "INSERT INTO transactions SET ";
			$query .= implode(', ', array_map(function ($key, $value) {
				return "$key='$value'";
			}, array_keys($data), $data));
	
			$pay = $this->db->query($query);
	
			if ($pay) {
				return 1; // Success
			} else {
				return 0; // Failed to insert into transactions table
			}
		} else {
			return 2; // Student not found
		}
	}
	function save_payment1(){
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

	// function save_payment2(){
	// 	$data = array();
	// 	$errors = array();
	
	// 	// Check if the request method is POST
	// 	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// 		// Check if the required fields are not empty
	// 		if (empty($_POST['ef_id']) || empty($_POST['amount']) || empty($_POST['date'])) {
	// 			$errors['fields'] = 'Please fill in all the required fields.';
	// 		}
	
	// 		// Check if the amount is a valid number
	// 		if (!is_numeric($_POST['amount'])) {
	// 			$errors['amount'] = 'Please enter a valid amount.';
	// 		}
	
	// 		// If there are no errors, save the payment
	// 		if (empty($errors)) {
	// 			$data = array(
	// 				'ef_id' => $_POST['ef_id'],
	// 				'amount' => str_replace(',', '', $_POST['amount']),
	// 				'remarks' => $_POST['remarks'],
	// 				'date' => $_POST['date'],
	// 				'user_id' => $_POST['user_id']
	// 			);
	
	// 			if (empty($_POST['id'])) {
	// 				$save = $this->db->query("INSERT INTO payments SET " . http_build_query($data));
	// 				$id = $this->db->insert_id;
	// 			} else {
	// 				$save = $this->db->update('payments', $data, array('id' => $_POST['id']));
	// 				$id = $_POST['id'];
	// 			}
	
	// 			if ($save) {
	// 				$stmt = $this->db->prepare("SELECT ef_id FROM payments WHERE id = ?");
	// 				$stmt->bind_param("i", $id);
	// 				$stmt->execute();
	// 				$result = $stmt->get_result();
	// 				$row = $result->fetch_array();
	// 				$student_id = $row['ef_id'];
	
	// 				// update the amount column in the transactions table
	// 				$stmt = $this->db->prepare("UPDATE transactions SET amount = amount - ? WHERE student_id = ?");
	// 				$stmt->bind_param("di", $data['amount'], $student_id);
	// 				$success = $stmt->execute();
	
	// 				return json_encode(array('ef_id' => $student_id, 'pid' => $id, 'status' => 1));
	// 			} else {
	// 				$errors['save'] = 'There was a problem saving the payment. Please try again later.';
	// 			}
	// 		}
	// 	} else {
	// 		$errors['method'] = 'Invalid request method.';
	// 	}
	
	// 	return json_encode(array('errors' => $errors));
	// }

	function save_payment(){
		$data = array();
		$errors = array();
	
		// Check if the request method is POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Check if the required fields are not empty
			if (empty($_POST['ef_id']) || empty($_POST['amount']) || empty($_POST['date'])) {
				$errors['fields'] = 'Please fill in all the required fields.';
			}
	
			// Check if the amount is a valid number
			if (!is_numeric($_POST['amount'])) {
				$errors['amount'] = 'Please enter a valid amount.';
			}
	
			// If there are no errors, save the payment
			if (empty($errors)) {
				$data = array(
					'ef_id' => $_POST['ef_id'],
					'amount' => str_replace(',', '', $_POST['amount']),
					'remarks' => $_POST['remarks'],
					'date' => $_POST['date'],
					'user_id' => $_POST['user_id']
				);
	
				$columns = implode(',', array_keys($data));
				$values = implode(',', array_values($data));
				$query = "INSERT INTO payments ($columns) VALUES ($values) ON DUPLICATE KEY UPDATE $columns";
	
				$save = $this->db->query($query);
				$id = $this->db->insert_id;
	
				if ($save) {
					$stmt = $this->db->prepare("SELECT ef_id FROM payments WHERE id = ?");
					$stmt->bind_param("i", $id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_array();
					$student_id = $row['ef_id'];
	
					// update the amount column in the transactions table
					$stmt = $this->db->prepare("UPDATE transactions SET amount = amount - ? WHERE student_id = ?");
					$stmt->bind_param("di", $data['amount'], $student_id);
					$success = $stmt->execute();
	
					return json_encode(array('ef_id' => $student_id, 'pid' => $id, 'status' => 1));
				} else {
					$errors['save'] = 'There was a problem saving the payment. Please try again later.';
				}
			}
		} else {
			$errors['method'] = 'Invalid request method.';
		}
	
		return json_encode(array('errors' => $errors));
	}

	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payments where id = ".$id);
		if($delete){
			return 1;
		}
	}

}