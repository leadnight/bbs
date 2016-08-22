<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Yoyaku_string_lib {

	const CREATE_GOODS_ERROR="<p>品目を入れてください</p>";
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

	const VAL_REQUIRED_MESSAGE = "項目 [ %s ] は必須項目です。";
}