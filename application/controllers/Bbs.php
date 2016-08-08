<?php
class Bbs extends CI_Controller {
	public function login() {
		$this->smarty->view ( 'login.html' );
	}
	public function regist() {

		// モデルのロード
		$this->load->model ( "Bbsmodel" );

		// データベース接続
		$this->load->database ();

		// メッセージの取得
		$message = $this->input->post ( "message" );

		$message = $this->db->escape ( $message );

		// var_dump($message);

		// メッセージをDBに当登録
		$res = $this->Bbsmodel->insertmessage ( $message );

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

		// urlヘルパーのロード
		$this->load->helper ( 'url' );

		// ログインしているか確認
		$login = isset ( $_SESSION ["username"] );

		// ログインしていない場合、ログイン画面へ飛ばす
		if (! $login) {
			$this->login();
			return;
		}

		// データベース接続
		$this->load->database ();

		// 登録されているメッセージ件数を取得
		$regrows = $this->Bbsmodel->messagecount ();

		// メッセージを取得(全件)
		$bbsmessage = $this->Bbsmodel->getmessage ();

		// 登録件数
		$this->smarty->assign ( "regrows", $regrows );

		// メッセージ
		$this->smarty->assign ( "bbs", $bbsmessage );

		// テンプレ起動
		$this->smarty->view ( 'bbs.html' );
	}
}
