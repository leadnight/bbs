<?php
class Bbs extends CI_Controller {
	public function regist() {

		// モデルのロード
		$this->load->model ( "Bbsmodel" );

		// データベース接続
		$this->load->database ();

		$message = $this->input->post ( "message" );

		$message = $this->db->escape ( $message );

		var_dump($message);

		$res = $this->Bbsmodel->insertmessage ( $message );

		if ($res == true) {
			$this->smarty->view ( "thanks.html" );
		} else {
			$this->smarty->view ( 'error.html');
		}
	}
	public function index() {
		// モデルのロード
		$this->load->model ( "Bbsmodel" );

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
