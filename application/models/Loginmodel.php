<?php
class Loginmodel extends CI_Model {

	/**
	 * デフォルトコンストラクター
	 */
	function __construct() {
		parent::__construct ();
	}

	function  logincheck($username,$password){
		// データベース接続
		$this->load->database ();

		$sql = "insert into sample.bbs (message,createtime,updatetime)values($message,now(),now())";

		// SQL実行
		$res = $this->db->query ( $sql );

		return $res;
	}


}