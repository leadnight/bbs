<?php
class Yoyaku extends CI_Controller {
	/**
	 * ユーザーのデリート
	 */
	public function deleteuser() {
		// ログインしているか確認
		$login = $this->Loginmodel->islogin ();

		// ログインしていない場合、トップページへ飛ばす
		if (! $login) {
			$this->smarty->view ( "yoyaku/dummytomain.html" );
			return;
		}

		// Postで踏んできたかチェック(不十分だけど)
		$check = $this->input->post ( "check" );

		// URLの入力などで直接飛んできたと判定したらダミー挟んでトップページへ飛ばす
		if ($check != 1) {
			$this->smarty->view ( '/yoyaku/dummytomain.html' );
			return;
		}

		// 描画先にユーザー名をセット
		$this->setusername();

		// パスワードを取得
		$password = $this->input->post ( "password" );

		// ルール作成
		$this->form_validation->set_rules ( 'password', 'パスワード', 'required' );

		// メッセージのセット
		$this->form_validation->set_message ( "required", "項目 [ %s ] は必須項目です。" );

		// チェック
		$vcheck = $this->form_validation->run ();

		// チェックしてダメならプロファイル変更画面へ戻る
		if ($vcheck == false) {
			$this->smarty->view ( "yoyaku/profile.html" );
			return;
		}

		// エスケープ処理
		$password = $this->db->escape ( $password );

// 		// パスワード入ってない時
// 		if ($password == "''") {
// 			// エラーメッセージ
// 			$myerrormessage = "<p>パスワードを入力してください。</p>";

// 			$this->smarty->assign ( "myerrormessage", $myerrormessage );

// 			// プロファイルページを表示させる
// 			$this->smarty->view ( 'yoyaku/profile.html' );
// 			return;
// 		}

		// ユーザー名
		$username = $_SESSION ["username"];

		// 入力されたパスワードが正しいのかチェック
		$res = $this->Loginmodel->logincheck ( $username, $password );

		if ($res == false) {
			// エラーメッセージ
			$myerrormessage = "<p>パスワードが違います。</p>";

			$this->smarty->assign ( "myerrormessage", $myerrormessage );

			// プロファイルページを表示させる
			$this->smarty->view ( 'yoyaku/profile.html' );
			return;
		}

		// ユーザーを削除する
		$res = $this->Usermodel->deleteuser ( $username );

		// 正常に削除できなかった場合
		if ($res == false) {
			$this->smarty->view ( 'yoyaku/error.html' );
			return;
		}

		// ログアウト処理
		$this->logout_sub ();

		// アカウント削除ページを表示
		$this->smarty->view ( "yoyaku/deleteaccount.html" );
	}
	public function changepassword() {
		// ログインしているか確認
		$login = $this->Loginmodel->islogin ();

		// ログインしていない場合、トップページへ飛ばす
		if (! $login) {
			$this->smarty->view ( "yoyaku/dummytomain.html" );
			return;
		}

		// Postでユーザー名が送られてきたかチェック
		$check = $this->input->post ( "check" );

		// URLの入力などで直接飛んできたと判定したらダミー挟んでトップページへ飛ばす
		if ($check != 1) {
			$this->smarty->view ( 'yoyaku/dummytomain.html' );
			return;
		}

		// ユーザー名をセッションから取り出す
		$username = $_SESSION ["username"];

		// POSTで新しいパスワードを取得
		$newpassword = $this->input->post ( "newpassword" );

		// ルール作成
		$this->form_validation->set_rules ( 'newpassword', '新しいパスワード', 'trim|required|alpha_numeric' );

		// メッセージのセット
		$this->form_validation->set_message ( "required", "項目 [ %s ] は必須項目です。" );
		$this->form_validation->set_message ( "alpha_numeric", "項目 [ %s ] は半角英数字で構成されている必要があります。" );

		// チェック
		$vcheck = $this->form_validation->run ();

		// チェックしてダメならプロファイル変更画面へ戻る
		if ($vcheck == false) {
			$this->smarty->view ( "yoyaku/profile.html" );
			return;
		}

		// エスケープ
		$newpassword = $this->db->escape ( $newpassword );

		// パスワードの更新
		$res = $this->Usermodel->updatepassword ( $username, $newpassword );

		// エラーが起きたらエラーページを表示
		if ($res == false) {
			$this->smarty->view ( "yoyaku/error.html" );
			return;
		}

		// パスワード変更完了ページを表示
		$this->smarty->view ( "yoyaku/password_changed.html" );
	}

	/**
	 * ユーザープロファイル編集用コントローラー
	 */
	public function profile() {
		// ログインしているか確認
		$login = $this->Loginmodel->islogin ();

		// ログインしていない場合、トップページへ飛ばす
		if (! $login) {
			$this->smarty->view ( "yoyaku/dummytomain.html" );
			return;
		}

		// ユーザー名をセット
		$this->setusername ();

		// プロファイル編集ページを表示
		$this->smarty->view ( "yoyaku/profile.html" );
	}

	/**
	 * ログアウトコントローラー
	 */
	public function logout() {
		$this->logout_sub ();

		$this->smarty->view ( "yoyaku/logout.html" );
	}

	/**
	 * ログアウト処理のメインメソッド
	 */
	private function logout_sub() {
		// セッション変数を全て解除する
		$_SESSION = array ();

		// セッションを切断するにはセッションクッキーも削除する。
		// Note: セッション情報だけでなくセッションを破壊する。
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 42000, '/' );
		}

		// 最終的に、セッションを破壊する
		session_destroy ();
	}

	/**
	 * ログインコントローラー
	 */
	public function login() {

		// postでこのページに移行したかをチェックする
		$username = $this->input->post ( "check" );

		// urlを直打ちで移行してきた場合メインページへ飛ばす
		if ($username != 1) {
			$this->smarty->view ( "yoyaku/dummytomain.html" );
			return;
		}

		// ログイン処理を開始する

		// ユーザー名とパスワードの取得
		$username = $this->input->post ( "username" );
		$password = $this->input->post ( "password" );

		// エスケープ処理
		$username = $this->db->escape ( $username );
		$password = $this->db->escape ( $password );

		// ログイン
		$res = $this->Loginmodel->logincheck ( $username, $password );

		// 成功すればセッション変数にユーザー名をセット
		// 失敗した場合失敗ページを出力
		if ($res) {
			// ログイン成功
			$_SESSION ["username"] = $username;
			$this->smarty->view ( "yoyaku/login_success.html" );
		} else {
			// ログイン失敗
			$this->smarty->view ( "yoyaku/login_fail.html" );
		}
	}

	/**
	 * indexコントローラー
	 */
	public function index() {
		// ログインしているか確認
		$login = $this->Loginmodel->islogin ();

		// ログインしていない場合、ログイン画面を表示
		if (! $login) {
			$this->smarty->view ( "yoyaku/login.html" );
			return;
		}

		// ユーザー名をセット
		$this->setusername ();

		// メインページを表示する
		$this->smarty->view ( "yoyaku/main.html" );
	}

	/**
	 * smartyの変数としてユーザー名をセットする
	 */
	private function setusername() {
		$this->smarty->assign ( "username", htmlspecialchars ( str_replace ( "'", "", $_SESSION ["username"] ) ) );
	}
}