<?php
class Usermodel extends CI_Model {

	/**
	 * デフォルトコンストラクター
	 */
	function __construct() {
		parent::__construct ();
	}

	function updatepassword($username, $password) {
		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "update sample.user set password = md5($password) where username = $username;";

		// SQL実行
		$res = $this->db->query ( $sql );

		return $res;
	}

	/**
	 * ユーザーDBを検索して重複するユーザー名があるかチェックする
	 *
	 * @param string $username
	 *        	チェックするユーザー名
	 * @return number 重複した人数(1以上であれば重複している)
	 *         でも2とか重複する場合ないはずなんだけどね
	 */
	function checkuser($username) {

		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "select count(*) as num from sample.user where username = $username;";

		// SQL実行
		$res = $this->db->query ( $sql );

		// 結果を取得
		$result = $res->row ();

		// 返答
		$usercount = - 1;

		if ($result != null) {
			$usercount = $result->num;
		}

		return $usercount;
	}
	/**
	 * ユーザーを新規追加する
	 *
	 * @param string $username
	 *        	ユーザー名(エスケープ済み)
	 * @param string $password
	 *        	パスワード(エスケープ済み この時点では生だから注意)
	 * @return boolean 成功したかどうか
	 */
	function registeruser($username, $password) {
		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "insert into sample.user (username,password) values ($username,md5($password));";

		// SQL実行
		$res = $this->db->query ( $sql );

		return $res;
	}
}