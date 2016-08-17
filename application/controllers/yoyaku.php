<?php
/**
 * @author n-hiiro
 *
 */
class Yoyaku extends CI_Controller {
	/**
	 *
	 * @var string トップページへのアドレス(ダミー挟む)
	 */
	const TOMAIN = "yoyaku/dummytomain.html";
	/**
	 *
	 * @var string エラーページヘのアドレス
	 */
	const ERROR = "yoyaku/error.html";
	/**
	 *
	 * @var string ユーザーページ作成へのアドレス
	 */
	const CREATEUSER = "yoyaku/createuser.html";
	/**
	 * コメントを追加する
	 */
	public function createcomment() {
		// エラーメッセージ初期化
		static::unseterrormessage ();

		// ログインチェック
		static::islogin ();

		// postでデータが送られてきたかチェック
		static::isposted ();

		// ======バリデーション======
		// ルール作成
		$this->form_validation->set_rules ( 'comment', 'コメント', 'trim|required' );

		// メッセージのセット(使ってない)
		$this->form_validation->set_message ( "required", "項目 [ %s ] は必須項目です。" );

		// チェック
		$vcheck = $this->form_validation->run ();

		// チェックしてダメなら戻す
		if ($vcheck == false) {

			$_SESSION ["comment_error"] = "<p>コメントを入れてください</p>";

			$this->smarty->view ( static::TOMAIN );
			return;
		}
		// =====================

		// Postデータを取得
		$comment = $this->input->post ( "comment" );

		// 挿入
		$res = $this->Yoyakumodel->createcomment ( $_SESSION ["userid"], $_SESSION ['current_goodsid'], $comment );

		// 項目作成完了ページを表示
		if ($res) {
			$this->smarty->view ( "yoyaku/createcomment_success.html" );
		} else {
			$this->smarty->view ( static::ERROR );
		}
	}

	/**
	 * 品目を追加する
	 */
	public function creategoods() {

		// エラーメッセージ初期化
		static::unseterrormessage ();

		// ログインチェック
		static::islogin ();

		// postでデータが送られてきたかチェック
		static::isposted ();

		// Postデータの取得
		$title = $this->input->post ( "title", true );

		// ======バリデーション======
		// ルール作成
		$this->form_validation->set_rules ( 'title', 'ユーザ名', 'trim|required' );

		// メッセージのセット(使ってない)
		$this->form_validation->set_message ( "required", "項目 [ %s ] は必須項目です。" );

		// チェック
		$vcheck = $this->form_validation->run ();

		// チェックしてダメなら戻す
		if ($vcheck == false) {

			$_SESSION ["create_goods_error"] = "<p>品目を入れてください</p>";

			$this->smarty->view ( static::TOMAIN );
			return;
		}
		// =====================

		// Postデータを取得
		$goodsname = $this->input->post ( "title" );

		// 挿入
		$res = $this->Yoyakumodel->creategoods ( $goodsname );

		// 項目作成完了ページを表示
		if ($res) {
			$this->smarty->view ( "yoyaku/createitem_success.html" );
		} else {
			$this->smarty->view ( static::ERROR );
		}
	}

	/**
	 * 実際に予約を消すコントローラー
	 */
	public function deletereservation() {
		// ログインチェック
		static::islogin ();

		// Postでユーザー名が送られてきたかチェック
		static::isposted ();

		// 消す予定の予約idを取得(formでhiddenしてある)
		$reservationid = $this->input->post ( "reservationid" );

		// 消す
		// 現在ログインしてるユーザーの情報しか消せないようにしてある
		$res = $this->Yoyakumodel->deletereservation ( $_SESSION ["userid"], $reservationid );

		// 結果のページを出力
		if ($res) {
			$this->smarty->view ( "yoyaku/deletereservation_success.html" );
		} else {
			$this->smarty->view ( static::ERROR );
		}
	}
	/**
	 * データを削除する確認ページ用コントローラー
	 * 引数として、表示中の予約リストの何番目のレコードを操作するか与える
	 *
	 * @param int $reservationindex
	 *        	現在表示されている予約データで何番目のレコードであるか
	 */
	public function deletereservation_check($reservationindex) {
		// ログインしているか確認
		static::islogin ();

		// 削除対象の予約データが入ります
		$reservation = array ();

		// 予約リスト(現在出力されている分)
		$list = $_SESSION ["reservationliost"];

		//存在しないレコードが指定されちゃった場合
		if(!isset($list [$reservationindex])){
			$this->smarty->view ( static::ERROR );
			return;
		}

		// 引数として与えられた番号を使って削除対象のレコードを表示する
		$reservation = $list [$reservationindex];

		// Smartyに予約情報をセット
		static::setsmarty ( "reservation", $reservation );

		// 確認ページ出力
		$this->smarty->view ( "yoyaku/deletereservation.html" );
	}

	/**
	 * 予約を作成する
	 */
	public function createreservation() {

		// エラーメッセージを削除
		static::unseterrormessage ();

		// ログインしているか確認
		static::islogin ();

		// Postでユーザー名が送られてきたかチェック
		static::isposted ();

		// 送信された内容を取得
		$syear = $this->input->post ( "syear" );
		$smonth = $this->input->post ( "smonth" );
		$sday = $this->input->post ( "sday" );
		$shour = $this->input->post ( "shour" );
		$sminute = $this->input->post ( "sminute" );

		$startarray = array($syear,$smonth,$sday,$shour,$sminute);

		$eyear = $this->input->post ( "eyear" );
		$emonth = $this->input->post ( "emonth" );
		$eday = $this->input->post ( "eday" );
		$ehour = $this->input->post ( "ehour" );
		$eminute = $this->input->post ( "eminute" );

		$endarray = array($eyear,$emonth,$eday,$ehour,$eminute);

		// 自分で整形
		$start = $syear . "-" . $smonth . "-" . $sday . " " . $shour . ":" . $sminute . ":00";
		$end = $eyear . "-" . $emonth . "-" . $eday . " " . $ehour . ":" . $eminute . ":00";

		// 仮初期化
		$starttime = new DateTime ();
		$endtime = new DateTime ();

		// postされたデータが不正だとエラーを吐くので、try-catchで対処
		try {
			$starttime = new DateTime ( $start );
			$endtime = new DateTime ( $end );
		} catch ( Exception $e ) {
			$this->smarty->view ( static::ERROR );

			//エラーメッセージをログに吐く

			return;
		}

		// 現在の時刻を取得
		$now = new DateTime ();

		// 開始時間が過去になっている場合
		if ($starttime < $now) {
			$_SESSION ["yoyaku_error_message"] = "<p>開始の日時が正しくありません</p>";
		}

		// 終了時刻が開始時刻とかぶっている
		if ($starttime >= $endtime) {
			if (isset ( $_SESSION ["yoyaku_error_message"] )) {
				$_SESSION ["yoyaku_error_message"] = $_SESSION ["yoyaku_error_message"] . "<p>終了の日時が正しくありません</p>";
			} else {
				$_SESSION ["yoyaku_error_message"] = "<p>終了の日時が正しくありません</p>";
			}
		}

		// 予約重複のチェック
		if (! $this->Yoyakumodel->checkreservation ( $_SESSION ['current_goodsid'], $start, $end )) {
			if (isset ( $_SESSION ["yoyaku_error_message"] )) {
				$_SESSION ["yoyaku_error_message"] = $_SESSION ["yoyaku_error_message"] . "<p>予約が重複しています</p>";
			} else {
				$_SESSION ["yoyaku_error_message"] = "<p>予約が重複しています</p>";
			}
		}

		// 予約日時がおかしいのでトップページへ
		if (isset ( $_SESSION ["yoyaku_error_message"] )) {
			$this->smarty->view ( static::TOMAIN );

			//セッションに選択された値を保存しておく
			$_SESSION["startselected"] = $startarray;
			$_SESSION["endselected"] = $endarray;

			return;
		}

		// 予約実行
		$res = $this->Yoyakumodel->createreservation ( $_SESSION ["userid"], $_SESSION ['current_goodsid'], $start, $end, "0" );

		// 予約完了ページを出力
		if ($res) {
			$this->smarty->view ( "yoyaku/yoyaku_success.html" );
		} else {
			$this->smarty->view ( static::ERROR );
		}
	}

	/**
	 * 現在閲覧中の予約品目をセッションにセットし、mainページへ出力できるようにする
	 * 引数としてgoodsidが渡されているはずなので、それを利用
	 *
	 * @param unknown $goodsid
	 */
	public function loadgoods($goodsid, $mode) {

		// エラーメッセージを削除
		static::unseterrormessage ();

		// ログインしているか確認
		static::islogin ();

		$res = $this->Yoyakumodel->getgoodsinfo ( $goodsid );

		// 不正な値が渡されていなかったら
		if (count ( $res ) > 0) {
			$_SESSION ["current_goodsid"] = $res ["goodsid"];
			$_SESSION ["current_goodsname"] = $res ["goodsname"];
		}

		if (is_int ( $mode )) {
			$_SESSION ["currnt_goodsmode"] = $mode;
		} else {
			$_SESSION ["currnt_goodsmode"] = 1;
		}

		// トップページへ
		$this->smarty->view ( static::TOMAIN );
	}

	/**
	 * ユーザー作成
	 */
	public function createuser() {

		// 遷移先が違うのでここだけ手書き
		// Postでフォームから送信されたかを確認する
		$check = $this->input->post ( "check" );

		// 初訪問だったら、登録フォームへ
		// URL直打ちでも登録フォームへ
		if ($check != 1) {
			$this->smarty->view ( static::CREATEUSER );
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
		$vcheck = $this->form_validation->run ();

		// チェックしてダメなら戻す
		if ($vcheck == false) {
			$this->smarty->view ( static::CREATEUSER );
			return;
		}

		// ユーザー名の重複がないかチェック
		$usercount = $this->Usermodel->checkuser_i ( $username );

		// ユーザー名が重複していた場合
		if ($usercount >= 1) {

			// エラーメッセージを作成
			$myerrormessage = "<p>ユーザー名はすでに使われています。</p>";

			// セット
			$this->smarty->assign ( "myerrormessage", $myerrormessage );

			// 登録ページヘ戻す
			$this->smarty->view ( static::CREATEUSER );
			return;
		}

		// ユーザー情報をDBに登録
		$this->Usermodel->registeruser_i ( $username, $password );

		// sleep(2);//２秒待つ

		// ログイン処理をしてuseridを取得する
		$res = $this->Loginmodel->login_userinfo ( $username, $password );

		// 成功すればセッション変数にユーザー名をセット
		// 失敗した場合失敗ページを出力
		if (count ( $res ) > 0) {
			// ログイン成功
			$_SESSION ["username"] = $res ["username"];
			$_SESSION ["userid"] = $res ["userid"];
		}

		// 登録完了ページを表示
		$this->smarty->view ( 'yoyaku/createuser_success.html' );
	}

	/**
	 * ユーザーのデリート
	 */
	public function deleteuser() {
		// ログインしているか確認
		static::islogin ();

		// Postで踏んできたかチェック(不十分だけど)
		static::isposted ();

		// 描画先にユーザー名をセット
		$this->setuserinfo ();

		// パスワードを取得
		$password = $this->input->post ( "password" );

		// =====バリデーション======

		// ルール作成
		$this->form_validation->set_rules ( 'password', 'パスワード', 'trim|required' );

		// チェック
		$vcheck = $this->form_validation->run ();

		// パスワード入ってない時
		if ($vcheck == false) {

			// エラーメッセージ
			$myerrormessage = "<p>パスワードを入力してください。</p>";

			// アサインする
			$this->smarty->assign ( "myerrormessage", $myerrormessage );

			// プロファイルページを表示させる
			$this->smarty->view ( 'yoyaku/profile.html' );
			return;
		}

		// ユーザー名
		$username = $_SESSION ["username"];

		// 入力されたパスワードが正しいのかチェック
		$res = $this->Loginmodel->logincheck_i ( $username, $password );

		if ($res == false) {
			// エラーメッセージ
			$myerrormessage = "<p>パスワードが違います。</p>";

			$this->smarty->assign ( "myerrormessage", $myerrormessage );

			// プロファイルページを表示させる
			$this->smarty->view ( 'yoyaku/profile.html' );
			return;
		}

		// ユーザーを削除する
		$res = $this->Usermodel->deleteuser_i ( $username );

		// 正常に削除できなかった場合
		if ($res == false) {
			$this->smarty->view ( static::ERROR );
			return;
		}

		// ログアウト処理
		$this->logout_sub ();

		// アカウント削除ページを表示
		$this->smarty->view ( "yoyaku/deleteaccount.html" );
	}
	/**
	 * パスワードの変更
	 */
	public function changepassword() {
		// ログインしているか確認
		static::islogin ();

		// Postでユーザー名が送られてきたかチェック
		static::isposted ();

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

		// パスワードの更新
		$res = $this->Usermodel->updatepassword_i ( $username, $newpassword );

		// エラーが起きたらエラーページを表示
		if ($res == false) {
			$this->smarty->view ( static::ERROR );
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
		static::islogin ();

		// ユーザー名をセット
		$this->setuserinfo ();

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
		static::isposted ();

		// ログイン処理を開始する

		// ユーザー名とパスワードの取得
		$username = $this->input->post ( "username" );
		$password = $this->input->post ( "password" );

		// ログイン
		// 失敗した場合は空の配列が返ってくる
		$res = $this->Loginmodel->login_userinfo ( $username, $password );

		// 成功すればセッション変数にユーザー名をセット
		// 失敗した場合失敗ページを出力
		if (count ( $res ) > 0) {
			// ログイン成功
			$_SESSION ["username"] = $res ["username"];
			$_SESSION ["userid"] = $res ["userid"];
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

		// ユーザー名とユーザーIDをsmartyにセット
		$this->setuserinfo ();

		// 予約アイテム一覧を取得
		$goodslist = $this->Yoyakumodel->loadgoodslist ();

		// Smarty変数にセット
		static::setsmarty ( "goodslist", $goodslist );

		// 選択中のgoodsidなどが入ります
		$currentgoodsid = 0;
		$currentgoodsname = "";

		// 予約情報一覧
		$reservationlist = array ();

		$commentlist = array ();

		// 予約項目が選択されていた場合に詳細をセット
		if (isset ( $_SESSION ['current_goodsid'] )) {
			$currentgoodsid = $_SESSION ['current_goodsid'];
			$currentgoodsname = $_SESSION ["current_goodsname"];

			// 予約状況を取得(現在はすべてを取得)
			$res = $this->Yoyakumodel->getgoodsreservation ( $_SESSION ['current_goodsid'], $_SESSION ["currnt_goodsmode"] );
			$reservationlist = $res;

			// とりあえず、予約リストをセッションに保存しておく
			$_SESSION ["reservationliost"] = $res;

			// コメントリストを取得する

			$res2 = $this->Yoyakumodel->getgoodscomment ( $_SESSION ['current_goodsid'] );
			$commentlist = $res2;

			// コメントリストもとりあえずセッションに持たせておく
			$_SESSION ["commentlist"] = $res2;
		}

		// smartyにセット
		static::setsmarty ( "currentgoodsid", $currentgoodsid );
		static::setsmarty ( "currentgoodsname", $currentgoodsname );
		static::setsmarty ( "reservationlist", $reservationlist );
		static::setsmarty_comment ( "commentlist", $commentlist );

		// 予約作成時のエラーメッセージ
		$yoyaku_error_message = "";
		if (isset ( $_SESSION ["yoyaku_error_message"] )) {
			$yoyaku_error_message = $_SESSION ["yoyaku_error_message"];
		}

		$this->smarty->assign ( "yoyaku_error_message", $yoyaku_error_message );

		// 新規品目追加時のエラー
		$create_goods_error = "";

		if (isset ( $_SESSION ["create_goods_error"] )) {
			$create_goods_error = $_SESSION ["create_goods_error"];
		}

		$this->smarty->assign ( "create_goods_error", $create_goods_error );

		// コメント追加時のエラー
		$comment_error = "";

		if (isset ( $_SESSION ["comment_error"] )) {
			$comment_error = $_SESSION ["comment_error"];
		}

		$this->smarty->assign ( "comment_error", $comment_error );

		//選択された予約日時を渡す
		$startselected =  array("","","","","");
		$endselected = array("","","","","");

		if(isset($_SESSION["startselected"])){
			$startselected= $_SESSION["startselected"];
		}

		if(isset($_SESSION["endselected"])){
			$endselected=$_SESSION["endselected"];
		}

		static::setsmarty("startselected",$startselected);
		static::setsmarty("endselected", $endselected);

		// メインページを表示する
		$this->smarty->view ( "yoyaku/main.html" );
	}
	/**
	 * コメント欄専用のSmarty出力用メソッド
	 * 改行コードのところに<br>を挟む都合で、エスケープ後に処理をする
	 *
	 * @param unknown $name
	 *        	セットする変数名
	 * @param unknown $val
	 *        	変数
	 */
	private function setsmarty_comment($name, $val) {
		$res = static::myhtmlescape ( $val );
		if (is_array ( $res )) {
			foreach ( $res as &$r ) {
				$r ["comment"] = nl2br ( $r ["comment"] );
			}
		} else {
			$res = nl2br ( $res );
		}
		$this->smarty->assign ( $name, $res );
	}
	/**
	 * Smartyに出力するためにhtmlエスケープと変数セットをする
	 *
	 * @param unknown $name
	 *        	セットする変数名
	 * @param unknown $val
	 *        	セットする変数
	 */
	private function setsmarty($name, $val) {
		$this->smarty->assign ( $name, static::myhtmlescape ( $val ) );
	}
	/**
	 * htmlのエスケープをする
	 *
	 * @param $string 文字列または配列
	 */
	private function myhtmlescape($string) {
		if (is_array ( $string )) {
			return array_map ( 'static::myhtmlescape', $string );
		} else {
			return htmlspecialchars ( $string, ENT_QUOTES, "UTF-8" );
		}
	}
	/**
	 * postでデータが送られてきたか
	 * まぁ気休めではある
	 */
	private function isposted() {
		// Postでデータがが送られてきたかチェック
		$check = $this->input->post ( "check" );

		// URLの入力などで直接飛んできたと判定したらダミー挟んでトップページへ飛ばす
		if ($check != 1) {
			$this->smarty->view ( static::TOMAIN );
		}
	}
	/**
	 * ログインしてるか確認
	 */
	private function islogin() {
		// ログインしているか確認
		$login = $this->Loginmodel->islogin ();

		// ログインしていない場合、トップページへ飛ばす
		if (! $login) {
			$this->smarty->view ( static::TOMAIN );
		}
	}
	/**
	 * セッションに保存してあるエラーメッセージを全部消す
	 */
	private function unseterrormessage() {
		unset ( $_SESSION ["create_goods_error"] );
		unset ( $_SESSION ["yoyaku_error_message"] );
		unset ( $_SESSION ["yoyaku_choufuku_message"] );
		unset ( $_SESSION ["comment_error"] );
	}

	/**
	 * smartyの変数としてユーザー名をセットする
	 */
	private function setuserinfo() {
		static::setsmarty ( "username", $_SESSION ["username"] );
		static::setsmarty ( "userid", $_SESSION ["userid"] );
	}
}