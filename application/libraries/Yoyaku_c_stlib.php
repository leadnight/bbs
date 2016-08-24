<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Yoyaku_c_stlib {
	// ======================
	// Smarty描画用テンプレートアドレス
	// ======================
	/**
	 * メインページへのアドレス
	 *
	 * @var string
	 */
	const MAIN = "yoyaku/main.html";

	/**
	 * エラーページヘのアドレス
	 *
	 * @var string
	 */
	const ERROR = "yoyaku/error.html";

	/**
	 * トップページへのアドレス(ダミー挟む)
	 *
	 * @var string
	 */
	const TOMAIN = "yoyaku/dummytomain.html";

	// ログイン
	/**
	 * ログインページへのアドレス
	 *
	 * @var string
	 */
	const LOGIN = "yoyaku/login.html";
	/**
	 * ログイン失敗へのアドレス
	 *
	 * @var string
	 */
	const LOGIN_FAIL = "yoyaku/login_fail.html";
	/**
	 * ログイン成功へのアドレス
	 *
	 * @var string
	 */
	const LOGIN_SUCCESS = "yoyaku/login_success.html";
	/**
	 * ログアウトへのアドレス
	 *
	 * @var string
	 */
	const LOGOUT = "yoyaku/logout.html";

	// ユーザープロファイル
	/**
	 * ユーザープロファイルへのアドレス
	 *
	 * @var string
	 */
	const USER_PROFILE = "yoyaku/profile.html";
	/**
	 * パスワード変更完了ページへのアドレス
	 *
	 * @var string
	 */
	const PASSWORD_CHANGED = "yoyaku/password_changed.html";
	/**
	 * ユーザー削除へのアドレス
	 *
	 * @var string
	 */
	const USER_DELETE = "yoyaku/deleteaccount.html";

	// ユーザー作成
	/**
	 * ユーザーページ作成へのアドレス
	 *
	 * @var string
	 */
	const CREATE_USER = "yoyaku/createuser.html";
	/**
	 * ユーザー作成成功へのアドレス
	 *
	 * @var string
	 */
	const CREATE_USER_SUCCESS = "yoyaku/createuser_success.html";

	// 予約
	/**
	 * 予約成功ページへのアドレス
	 *
	 * @var string
	 */
	const CREATE_RESERVATION_SUCCESS = "yoyaku/yoyaku_success.html";
	/**
	 * 予約削除確認ページヘのアドレス
	 *
	 * @var string
	 */
	const DELETE_RESERVATION_CHECK = "yoyaku/deletereservation.html";
	/**
	 * 予約削除完了ページヘのアドレス
	 *
	 * @var string
	 */
	const DELETE_RESERVATION_SUCCESS = "yoyaku/deletereservation_success.html";

	// 雑多
	/**
	 * 項目追加成功ページヘのアドレス
	 *
	 * @var string
	 */
	const CREATE_ITEM_SUCCESS = "yoyaku/createitem_success.html";
	/**
	 * コメント書き込み成功へのアドレス
	 *
	 * @var string
	 */
	const CREATE_COMMENT_SUCCESS = "yoyaku/createcomment_success.html";

	// ======================
	// バリデーションチェックメッセージ
	// ======================
	/**
	 * alpha_numeric用のメッセージ
	 *
	 * @var string
	 */
	const VAL_ALPHA_NUMERIC_MESSAGE = "項目 [ %s ] は半角英数字で構成されている必要があります。";
	/**
	 * Required用のメッセージ
	 *
	 * @var string
	 */
	const VAL_REQUIRED_MESSAGE = "項目 [ %s ] は必須項目です。";

	// =================
	// エラーメッセージ
	// =================

	// ユーザー操作
	/**
	 * 削除時にパスワードが違う
	 *
	 * @var string
	 */
	const DELETE_USER_ERROR_MESSAGE_PASSWORD = "<p>パスワードが違います。</p>";
	/**
	 * 削除時にパスワードが未入力
	 *
	 * @var string
	 */
	const DELETE_USER_ERROR_MESSAGE_ENTER = "<p>パスワードを入力してください。</p>";
	/**
	 * ユーザー名が重複した
	 *
	 * @var string
	 */
	const CREATE_USER_ERROR_MESSAGE = "<p>ユーザー名はすでに使われています。</p>";

	// 予約
	/**
	 * 予約日時に不正な値が渡された
	 *
	 * @var string
	 */
	const CREATE_RESERVATION_ERROR_MESSAGE_POST = "不正な予約日時が与えられました。";
	/**
	 * 予約重複
	 *
	 * @var string
	 */
	const CREATE_RESERVATION_ERROR_MESSAGE_DUPLICATE = "<p>予約が重複しています</p>";
	/**
	 * 予約作成時のエラー 終了時間不正
	 *
	 * @var string
	 */
	const CREATE_RESERVATION_ERROR_MESSAGE_END = "<p>終了の日時が正しくありません</p>";
	/**
	 * 予約作成時の時のエラー 開始時間不正
	 *
	 * @var string
	 */
	const CREATE_RESERVATION_ERROR_MESSAGE_START = "<p>開始の日時が正しくありません</p>";

	// 雑多
	/**
	 * コメント未記入時のエラー
	 *
	 * @var string
	 */
	const CREATE_COMMENT_ERROR_MESSAGE = "<p>コメントを入れてください</p>";
	/**
	 * 品目未入力時のエラー
	 *
	 * @var string
	 */
	const CREATE_GOODS_ERROR_MESSAGE = "<p>品目を入れてください</p>";
}