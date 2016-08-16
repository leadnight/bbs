<?php
class Usermodel extends CI_Model {

	function deleteuser_i($username){
		// SQL文
		$sql = "update sample.user set status = 1 where username = ?;";

		// 削除処理(フラグ立てるだけ)
		$res = $this->db->query ( $sql ,$username);

		return $res;
	}

	function deleteuser($username) {
		// データベース接続
		$this->load->database ();

		// SQL文
		$sql = "delete FROM sample.user where username = $username;";

		// 削除処理
		$res = $this->db->query ( $sql );

		return $res;
	}

	function updatepassword_i($username,$password){
		// SQL
		$sql = "update sample.user set password = md5(?) where username = ?;";

		// SQL実行
		$res = $this->db->query ( $sql ,array($password,$username));

		return $res;
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
	function checkuser_i($username) {

		// SQL
		$sql = "select *from sample.user where username = ?;";

		// SQL実行
		$res = $this->db->query ( $sql ,$username);

		// 返答
		$usercount = $res->num_rows();

		return $usercount;

	}

	/**
	 * ユーザーDBを検索して重複するユーザー名があるかチェックする
	 *
	 * @param string $username
	 *        	チェックするユーザー名
	 * @return number 重複した人数(1以上であれば重複している)
	 *         でも2とか重複する場合ないはずなんだけどね
	 *
	 * @deprecated エスケープを忘れるとインジェクション起きる
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

	function registeruser_i($username, $password){
		// SQL
		$sql = "insert into sample.user (username,password) values (?,md5(?));";

		// SQL実行
		$res = $this->db->query ( $sql ,array($username,$password));

		return $res;
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