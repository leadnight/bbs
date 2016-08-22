<?php
class Bbs extends CI_Controller {
	/**
	 * ユーザーのデリート
	 */
	public function deleteuser() {
		// ログインしていなかった場合 叩き出す
		if (! $this::islogin ()) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// Postで踏んできたかチェック(不十分だけど)
		$check = $this->input->post ( "check" );

		// URLの入力などで直接飛んできたと判定したらダミー挟んでトップページへ飛ばす
		if ($check != 1) {
			$this->smarty->view ( 'dummy.html' );
			return;
		}

		// 描画先にユーザー名をセット
		$this->smarty->assign ( "username", str_replace ( "'", "", $_SESSION ["username"] ) );

		// パスワードを取得
		$password = $this->input->post ( "password" );

		// エスケープ処理
		$password = $this->db->escape ( $password );

		// パスワード入ってない時
		if ($password == "''") {
			// エラーメッセージ
			$myerrormessage = "<p>パスワードを入力してください。</p>";

			$this->smarty->assign ( "myerrormessage", $myerrormessage );

			// プロファイルページを表示させる
			$this->smarty->view ( 'profile.html' );
			return;
		}

		// ユーザー名
		$username = $_SESSION ["username"];

		// 入力されたパスワードが正しいのかチェック
		$res = $this->Loginmodel->logincheck ( $username, $password );

		if ($res == false) {
			// エラーメッセージ
			$myerrormessage = "<p>パスワードが違います。</p>";

			$this->smarty->assign ( "myerrormessage", $myerrormessage );

			// プロファイルページを表示させる
			$this->smarty->view ( 'profile.html' );
			return;
		}

		// ユーザーを削除する
		$res = $this->Usermodel->deleteuser ( $username );

		// 正常に削除できなかった場合
		if ($res == false) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// ログアウト処理
		$this->logout_sub ();

		// アカウント削除ページを表示
		$this->smarty->view ( "deleteaccount.html" );
	}

	/**
	 * パスワードの変更
	 */
	public function changepassword() {
		// ログインしていなかった場合 叩き出す
		if (! $this::islogin ()) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// Postでユーザー名が送られてきたかチェック
		$check = $this->input->post ( "check" );

		// URLの入力などで直接飛んできたと判定したらダミー挟んでトップページへ飛ばす
		if ($check != 1) {
			$this->smarty->view ( 'dummy.html' );
			return;
		}

		// ユーザー名をセッションから取り出す
		$username = $_SESSION ["username"];

		// ユーザー名をセット
		$this->smarty->assign ( "username", str_replace ( "'", "", $_SESSION ["username"] ) );

		// postの取得
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
			$this->smarty->view ( 'profile.html' );
			return;
		}

		// エスケープ
		$newpassword = $this->db->escape ( $newpassword );

		$res = $this->Usermodel->updatepassword ( $username, $newpassword );

		// エラー起きたら飛ばす
		if ($res == false) {
			$this->smarty->view ( "error.html" );
			return;
		}

		// 更新完了ページ
		$this->smarty->view ( "password_changed.html" );
	}
	public function profile() {
		// ログインしていなかった場合 叩き出す
		if (! $this::islogin ()) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// ヘルパーのロード(使うか未定)
		$this->load->helper ( array (
				'form',
				'url'
		) );

		// バリデーションモジュール
		$this->load->library ( 'form_validation' );

		// ユーザー名をセット
		$this->smarty->assign ( "username", str_replace ( "'", "", $_SESSION ["username"] ) );

		$this->smarty->view ( 'profile.html' );
	}

	/**
	 * ユーザー登録
	 */
	public function register() {

		// ヘルパーのロード(使うか未定)
		$this->load->helper ( array (
				'form',
				'url'
		) );

		// バリデーションモジュール
		$this->load->library ( 'form_validation' );

		// データベースモジュールをロード
		$this->load->database ();

		// モデルのロード
		$this->load->model ( "Usermodel" );
		$this->load->model ( "Loginmodel" );

		// Postでユーザー名が送られてきたかチェック
		$visited = $this->input->post ( "visited" );

		// 初訪問だったら、登録フォームへ
		if ($visited != 1) {
			$this->smarty->view ( 'register.html' );
			return;
		}

		// Postデータの取得
		$username = $this->input->post ( "username" );
		$password = $this->input->post ( "password" );

		// ルール作成
		$this->form_validation->set_rules ( 'username', 'ユーザ名', 'trim|required|alpha_numeric' );
		$this->form_validation->set_rules ( 'password', 'パスワード', 'trim|required|alpha_numeric' );

		// メッセージのセット
		$this->form_validation->set_message ( "required", "項目 [ %s ] は必須項目です。" );
		$this->form_validation->set_message ( "alpha_numeric", "項目 [ %s ] は半角英数字で構成されている必要があります。" );

		// チェック
		$check = $this->form_validation->run ();

		// チェックしてダメなら戻す
		if ($check == false) {
			$this->smarty->view ( 'register.html' );
			return;
		}

		// エスケープ処理
		$username = $this->db->escape ( $username );
		$password = $this->db->escape ( $password );

		// ユーザー名の重複がないかチェック
		$usercount = $this->Usermodel->checkuser ( $username );

		// エラーメッセージを格納する
		$myerrormessage = array ();

		// ユーザー名が重複していた場合
		if ($usercount >= 1) {
			$myerrormessage ["username"] = "<p>ユーザー名はすでに使われています。</p>";

			$this->smarty->assign ( "myerrormessage", $myerrormessage );

			// 登録ページヘ戻す
			$this->smarty->view ( 'register.html' );
			return;
		}

		// ユーザー情報をDBに登録
		$this->Usermodel->registeruser ( $username, $password );

		// セッションにユーザー名を保存
		$_SESSION ["username"] = $username;

		// 登録完了ページを表示
		$this->smarty->view ( 'register_success.html' );
	}

	/**
	 * 板の新規作成
	 */
	public function createboard() {

		// ログインしていなかった場合
		if (! $this::islogin ()) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// フォームからデータが送られてきたかチェックする
		// 隠し要素でwriteを持っているかどうかで判定
		// 偽装されたら？んー・・・
		$write = $this->input->post ( "write2" );
		if ($write != 1) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// モデルのロード
		$this->load->model ( "Bbsmodel" );

		// データベース接続
		$this->load->database ();

		// タイトルの取得
		$title = $this->input->post ( "title" );

		// エスケープ処理
		$title = $this->db->escape ( $title );

		// 作成処理
		$res = $this->Bbsmodel->createboard ( $title );

		// 選択中の掲示板IDを初期化しておく
		unset ( $_SESSION ["boardid"] );

		// 成功と失敗で遷移先を分ける
		if ($res == true) {
			$this->smarty->view ( "createboard.html" );
		} else {
			$this->smarty->view ( 'error.html' );
		}
	}

	/**
	 * 掲示板情報をロードするための関数
	 * 現在閲覧中の掲示板IDと名前、投稿数をセッションに格納する
	 *
	 * @param int $boardid
	 *        	掲示板ID
	 */
	public function loadboard($boardid) {

		// ログインしていなかった場合
		if (! $this::islogin ()) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		$this->loadboard_sub ( $boardid );

		$this->smarty->view ( "dummy.html" );
	}

	/**
	 * 掲示板情報をロードするための関数
	 * 現在閲覧中の掲示板IDと名前、投稿数をセッションに格納する
	 *
	 * @param int $boardid
	 *        	掲示板ID
	 */
	private function loadboard_sub($boardid) {
		// $test = $boardid;

		// データベース接続
		$this->load->database ();

		// エスケープ処理
		$id = $this->db->escape ( $boardid );

		// モデルのロード
		$this->load->model ( "Bbsmodel" );

		$boardinfo = $this->Bbsmodel->getboardinfo ( $id );

		if ($boardinfo != null) {
			$_SESSION ["boardid"] = $boardinfo ["boardid"];
			$_SESSION ["boardname"] = $boardinfo ["boardname"];
			$_SESSION ["boardnum"] = $boardinfo ["num"];
		}
	}

	/**
	 * ログアウト処理
	 * セッションとクッキーの破棄
	 */
	public function logout() {
		$this->logout_sub ();

		$this->smarty->view ( "logout.html" );
	}
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
	 * ログイン処理を行う
	 */
	public function login() {

		// モデルのロード
		// $this->load->model ( "Loginmodel" );

		// データベース接続
		// $this->load->database ();

		// ユーザー名とパスワードの取得
		$username = $this->input->post ( "username" );
		$password = $this->input->post ( "password" );

		// エスケープ処理
		$username = $this->db->escape ( $username );
		$password = $this->db->escape ( $password );

		// ログイン
		$res = $this->Loginmodel->logincheck ( $username, $password );

		if ($res) {
			$_SESSION ["username"] = $username;
			$this->smarty->view ( "success.html" );
		} else {
			$this->smarty->view ( "fail.html" );
		}
	}

	/**
	 * メッセージの書き込み処理
	 */
	public function writemessage() {

		// ログインしていなかった場合
		if (! $this::islogin ()) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// フォームからデータが送られてきたかチェックする
		// 隠し要素でwriteを持っているかどうかで判定
		// 偽装されたら？んー・・・
		$write = $this->input->post ( "write" );
		if (! isset ( $write )) {
			$this->smarty->view ( 'error.html' );
			return;
		}

		// モデルのロード
		$this->load->model ( "Bbsmodel" );

		// データベース接続
		$this->load->database ();

		// メッセージの取得
		$message = $this->input->post ( "message" );

		// エスケープ処理
		$message = $this->db->escape ( $message );

		// htmlで正常に表示させるために記号を書き換え
		$message = htmlspecialchars ( $message );

		// 現在閲覧してるスレッドの情報がセクションにあるはず
		// なければ不正に開かれた可能性あり
		// なくてもいいんじゃねーかっていう疑惑はある
		if (! isset ( $_SESSION ["boardid"] )) {
			$this->smarty->view ( "dummy.html" ); // ダミー噛ませてトップページへ
			return;
		}

		$boardid = $_SESSION ["boardid"];

		// メッセージをDBに登録
		$res = $this->Bbsmodel->insertmessage ( $message, $boardid );

		// 成功と失敗で遷移先を分ける
		if ($res == true) {
			$this->smarty->view ( "thanks.html" );
		} else {
			$this->smarty->view ( 'error.html' );
		}
	}
	public function index() {

		// ログインしているか確認
		$login = $this->Loginmodel->islogin();

		// ログインしていない場合、ログイン画面へ飛ばす
		if (! $login) {
			$this->smarty->view ( 'login.html' );
			return;
		}

		// ユーザー名をセット
		$this->smarty->assign ( "username", str_replace ( "'", "", $_SESSION ["username"] ) );

		// データベース接続
		$this->load->database ();

		// スレッド一覧を取得
		$boardlist = $this->Bbsmodel->getboardlist ();

		// スレッド一覧をセット
		$this->smarty->assign ( "boardlist", $boardlist );

		// 表示する掲示板番号
		$boardid = 0;
		$boardname = "";
		$boardnum = 0;

		if (isset ( $_SESSION ["boardid"] )) {
			$boardid = $_SESSION ["boardid"];

			// 書き込み件数などを更新する
			$this->loadboard_sub ( $boardid );

			$boardname = $_SESSION ["boardname"];
			$boardnum = $_SESSION ["boardnum"];
		}

		$this->smarty->assign ( "boardid", $boardid );
		$this->smarty->assign ( "boardname", $boardname );
		$this->smarty->assign ( "boardnum", $boardnum );

		$bbsmessage = array ();

		// メッセージを取得(全件)
		if ($boardid > 0) {
			$bbsmessage = $this->Bbsmodel->getmessage ( $boardid );
		}

		// メッセージ
		$this->smarty->assign ( "message", $bbsmessage );

		// テンプレ起動
		$this->smarty->view ( 'bbs.html' );
	}

	/**
	 * ログインしているかのチェック
	 * sessionにユーザー名が保存されているかで調べる
	 *
	 * @return ログインしていればture,してなければfalse
	 */
	private function islogin() {
		$res = false;
		$res = isset ( $_SESSION ["username"] );
		return $res;
	}
}
