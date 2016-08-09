<?php
class Bbs extends CI_Controller {

	public function register(){

		//ヘルパーのロード(使うか未定)
		$this->load->helper(array('form', 'url'));

		//バリデーションモジュール
		$this->load->library('form_validation');

		$username = $this->input->post ( "username" );

		//初訪問
		if($username==null){
			$this->smarty->view ( 'register.html' );
			return;
		}

		//チェック
		$check = $this->form_validation->run();

		$this->smarty->view ( 'register.html' );

	}

	/**
	 * 板の新規作成
	 */
	public function createboard(){
		// フォームからデータが送られてきたかチェックする
		// 隠し要素でwriteを持っているかどうかで判定
		// 偽装されたら？んー・・・
		$write = $this->input->post ( "write2" );
		if (! isset ( $write )) {
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

		//作成処理
		$res = $this->Bbsmodel->createboard($title);

		//選択中の掲示板IDを初期化しておく
		unset($_SESSION ["boardid"] );

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
		// セッション変数を全て解除する
		$_SESSION = array ();

		// セッションを切断するにはセッションクッキーも削除する。
		// Note: セッション情報だけでなくセッションを破壊する。
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 42000, '/' );
		}

		// 最終的に、セッションを破壊する
		session_destroy ();

		$this->smarty->view ( "logout.html" );
	}

	/**
	 * ログイン処理を行う
	 */
	public function login() {

		// モデルのロード
		$this->load->model ( "Loginmodel" );

		// データベース接続
		$this->load->database ();

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

		//htmlで正常に表示させるために記号を書き換え
		$message = htmlspecialchars($message);

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
		// モデルのロード
		$this->load->model ( "Bbsmodel" );

		// ログインしているか確認
		$login = isset ( $_SESSION ["username"] );

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
}
