<?php
class Registermodel extends CI_Model {

	/**
	 * デフォルトコンストラクター
	 */
	function __construct() {
		parent::__construct ();
	}

	function checkuser($username){
		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "select count(*) as num from sample.user where username = $username;";

		// SQL実行
		$res = $this->db->query ( $sql );

		// 結果を取得
		$result = $res->row ();

		//返答
		$usercount = -1;

		if($result!=null){
			$usercount = $result->num;
		}

		return $usercount;
	}

	function  registeruser($username,$password){

		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "insert into sample.user (username,password) values ($username,md5($password));";

		// SQL実行
		$res = $this->db->query ( $sql );

		return $res;

	}

}