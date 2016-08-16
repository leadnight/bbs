<?php
class Loginmodel extends CI_Model {

	/**
	 * ログインしているかチェックする
	 * セッション変数に"username"として
	 * 値が設定されているかを確認
	 *
	 * @return ture:ログイン中 false:ログインしてない
	 */
	function islogin() {
		$res = false;
		$res = isset ( $_SESSION ["username"] );
		return $res;
	}

	/**
	 * ログインかつユーザー情報を取得
	 * 予約管理の方で利用
	 */
	function login_userinfo($username, $password) {
		$response = array ();

		//SQL文
		$sql = "select * from sample.user where username=? and password = md5(?)";

		// SQL実行
		$res = $this->db->query ( $sql, array($username,$password));

		$tmp = $this->db->last_query ();

		// 正常に取得出来た場合
		if ($res->num_rows () == 1) {

			// トップデータを取得
			$r = $res->row ();

			$response ["username"] = $r->username;
			$response ["userid"] = $r->id;
		}

		return $response;
	}

	function logincheck_i($username,$password){
		$ret = false;

		$sql = "select * from sample.user where username = ? and password = md5(?)";

		$res = $this->db->query($sql,array($username,$password));

		if($res->num_rows()==1){
			$ret = true;
		}

		return $ret;
	}

	/**
	 * ログインチェック
	 * (ヘルパー使って書き直したほうがいいのかもしれない)
	 *
	 * @param String $username
	 *        	ユーザー名
	 * @param String $password
	 *        	パスワード
	 * @return boolean true:ログイン成功 false:ログイン失敗
	 */
	function logincheck($username, $password) {
		$response = false; // 認証できたかのフラグ

		// データベース接続
		$this->load->database ();

		// ユーザー名が一致するものあるか
		$sql = "select count(*) as num from sample.user where username = " . $username . " and password = md5(" . $password . ");";

		// SQL実行
		$res = $this->db->query ( $sql ); // ユーザーネームとのマッチ件数

		// 結果を取り出す処理
		$res = $res->row ();

		// 一致したレコード数を代入
		$res = $res->num;

		if ($res == 1) {
			$response = true;
		}

		return $response;
	}
}