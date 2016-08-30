<?php
class Comment extends CI_Controller {
	function __construct() {
		parent::__construct ();

		// ライブラリをロード
		$this->load->library ( "Yoyaku_c_stlib" );
		$this->load->library ( "My_smarty_lib", "", "mylib" );
	}

	function comment_form(){
		$currentgoodsid = $this->input->get ( "goodsid" ) ? $this->input->get ( "goodsid" ) : - 10;

		// 現在選択中の品目名
		$currntgoodsname = "";

		// 品目情報を取得
		$res = $this->Yoyakumodel->getgoodsinfo ( $currentgoodsid );

		// 品目情報が正常に取得されていた場合
		if (count ( $res ) > 0) {
			$currntgoodsname = $res ["goodsname"];
		}

		//smartyにセット
		$this->mylib->setsmarty("currentgoodsname",$currntgoodsname);

		//出力
		echo $this->smarty->view("yoyaku/part/comment_form.html");

		//ログ
		log_message("info", "コメント用フォームが呼び出されました。");
	}

	function refleshcomment(){
		$currentgoodsid = $this->input->get ( "goodsid" ) ? $this->input->get ( "goodsid" ) : - 10;

		$res2 = $this->Yoyakumodel->getgoodscomment ( $currentgoodsid );
		$commentlist = $res2;

		// コメントリストもとりあえずセッションに持たせておく
		$_SESSION ["commentlist"] = $res2;

		//コメントリストを更新
		$this->mylib->setsmarty_comment ( "commentlist", $commentlist );
		echo $this->smarty->view ( "yoyaku/part/comment_list.html" );
	}

	function get() {
		$currentgoodsid = $this->input->get ( "goodsid" ) ? $this->input->get ( "goodsid" ) : - 10;

		$res2 = $this->Yoyakumodel->getgoodscomment ( $currentgoodsid );
		$commentlist = $res2;

		// コメントリストもとりあえずセッションに持たせておく
		$_SESSION ["commentlist"] = $res2;

		// 描画のためにセット
		$this->mylib->setsmarty_comment ( "commentlist", $commentlist );
		echo $this->smarty->view ( "yoyaku/part/comment_list.html" );
	}

	function post() {

		// ======バリデーション======
		// ルール作成
		$this->form_validation->set_rules ( 'comment', 'コメント', 'trim|required' );

		// チェック
		$vcheck = $this->form_validation->run ();

		// =====================

		// チェックしてダメならメッセージを出す
		if (! $vcheck) {
			echo "(・∀・)空欄だから修正汁";
			log_message("info", "空コメントが書き込まれました。");
		}
		else {
			// Postデータを取得
			$comment = $this->input->post ( "comment" );

			// 挿入
			$res = $this->Yoyakumodel->createcomment ( $_SESSION ["userid"], $_SESSION ['current_goodsid'], $comment );

			// 項目作成完了ページを表示
			if ($res) {
				echo "書き込みが完了しました。";
			} else {
				echo "(・∀・)ナンカエラーダッテ";
			}

		}

	}
	function put() {
	}
	function del() {
	}
}