<?php
class Loginmodel extends CI_Model {

	/**
	 * デフォルトコンストラクター
	 */
	function __construct() {
		parent::__construct ();
	}
	function logincheck($username, $password) {
		$res = false; // 認証できたかのフラグ

		// データベース接続
		$this->load->database ();

		// ユーザー名が一致するものあるか
		$sqlu = "select count(*) as num from sample.user where username = " . $username . ";";
		$sqlp = "select count(*) as num from sample.user where password = md5(" . $password . ");";

		// SQL実行
		$resu = $this->db->query ( $sqlu ); //ユーザーネームとのマッチ件数
		$resp = $this->db->query ( $sqlp ); //パスワードとのマッチ件数

		//結果を取り出す処理
		$resu = $resu->row ();
		$resp = $resp->row ();

		//一致したレコード数を代入
		$resu = $resu->num;
		$resp = $resp->num;

		if ($resu == 1 && $resp == 1) {
			$res = true;
		}

		return $res;
	}
}