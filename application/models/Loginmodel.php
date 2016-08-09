<?php
class Loginmodel extends CI_Model {

	/**
	 * デフォルトコンストラクター
	 */
	function __construct() {
		parent::__construct ();
	}
	function logincheck($username, $password) {
		$response = false; // 認証できたかのフラグ

		// データベース接続
		$this->load->database ();

		// ユーザー名が一致するものあるか
		$sql = "select count(*) as num from sample.user where username = " . $username . " and md5(" . $password . ");";

		// $sqlp = "select count(*) as num from sample.user where password = md5(" . $password . ");";

		// SQL実行
		$res = $this->db->query ( $sql ); // ユーザーネームとのマッチ件数
		                                  // $resp = $this->db->query ( $sqlp ); //パスワードとのマッチ件数

		// 結果を取り出す処理
		$res = $res->row ();
		// $resp = $resp->row ();

		// 一致したレコード数を代入
		$res = $res->num;
		// $resp = $resp->num;

		if ($res == 1) {
			$response = true;
		}

		return $response;
	}
}