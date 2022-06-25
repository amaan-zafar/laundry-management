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
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 1;
		}
	}

	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}

	function save_customer(){
		extract($_POST);
		$data = " id = '$id' ";
		$data .= ", name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", email = '$email' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", price = '$price' ";
		$data .= ", max_capacity = '$max_capacity' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO laundry_categories set ".$data);
		}else{
			$save = $this->db->query("UPDATE laundry_categories set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM laundry_categories where id = ".$id);
		if($delete)
			return 1;
	}

	function save_laundry(){
		extract($_POST);
		$data = " customer_name = '$customer_name' ";
		$data .= ", total_amount = '$tamount' ";
		if(isset($status))
			$data .= ", status = '$status' ";
		if(empty($id)){
			$queue = $this->db->query("SELECT `queue` FROM laundry_list where status != 3 order by id desc limit 1");
			$queue =$queue->num_rows > 0 ? $queue->fetch_array()['queue']+1 : 1;
			$data .= ", queue = '$queue' ";
			$save = $this->db->query("INSERT INTO laundry_list set ".$data);
			if($save){
				$id = $this->db->insert_id;
				foreach ($weight as $key => $value) {
					$items = " laundry_id = '$id' ";
					$items .= ", laundry_category_id = '$laundry_category_id[$key]' ";
					$items .= ", weight = '$weight[$key]' ";
					$items .= ", unit_price = '$unit_price[$key]' ";
					$items .= ", amount = '$amount[$key]' ";
					$save2 = $this->db->query("INSERT INTO laundry_items set ".$items);
				}
				return 1;
			}		
		} else {
			$save = $this->db->query("UPDATE laundry_list set ".$data." where id=".$id);
			if($save){
				$this->db->query("DELETE FROM laundry_items where id not in (".implode(',',$item_id).") ");
				foreach ($weight as $key => $value) {
					$items = " laundry_id = '$id' ";
					$items .= ", laundry_category_id = '$laundry_category_id[$key]' ";
					$items .= ", weight = '$weight[$key]' ";
					$items .= ", unit_price = '$unit_price[$key]' ";
					$items .= ", amount = '$amount[$key]' ";
					if(empty($item_id[$key]))
						$save2 = $this->db->query("INSERT INTO laundry_items set ".$items);
					else
						$save2 = $this->db->query("UPDATE laundry_items set ".$items." where id=".$item_id[$key]);
				}
				return 1;
			}	

		}
	}

	function delete_laundry(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM laundry_list where id = ".$id);
		$delete2 = $this->db->query("DELETE FROM laundry_items where laundry_id = ".$id);
		if($delete && $delete2)
			return 1;
	}
	

}