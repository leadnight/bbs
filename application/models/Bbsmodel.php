<?php
class Bbsmodel extends CI_Model {

	/**
	 * デフォルトコンストラクター
	 */
	function __construct() {
		parent::__construct ();
	}

	function insertmessage($message){
		// データベース接続
		$this->load->database ();

		$sql = "insert into sample.bbs (message,createtime,updatetime)values($message,now(),now())";

		// SQL実行
		$res = $this->db->query ( $sql );

		return $res;
	}

	/**
	 * BBSデータ全件表示
	 *
	 * @return BBSデータ 配列で返される。
	 *         [][0]=管理番号(mysqlによる自動採番)
	 *         [][1]=メッセージ内容
	 */
	function getmessage() {
		return $this->getmessage_limit ( 0 );
	}
	/**
	 * BBSデータ制限表示
	 * 引数で0以下を渡すと全件表示になる
	 *
	 * @return BBSデータ 配列で返される。
	 *         [][0]=管理番号(mysqlによる自動採番)
	 *         [][1]=メッセージ内容
	 *         [][2]=作成日時
	 *         [][3]=更新日時
	 */
	function getmessage_limit($limit) {
		// データベース接続
		$this->load->database ();

		// データ呼び出し(全件表示)
		$sql = "select * from sample.bbs order by createtime asc limit " + $limit + ";";

		// $limitが無効化されていた場合(0以下)SQL文を書き換える
		if ($limit <= 0) {
			$sql = "select * from sample.bbs order by createtime asc;";
		}

		// SQL実行
		$res = $this->db->query ( $sql );

		$result = $res->result ();

		$counter = 0;
		$bbsmessage = array();
		foreach ( $result as $r ) {

			$bbsmessage [$counter] [0] = $r->id;
			$bbsmessage [$counter] [1] = $r->message;
			$bbsmessage [$counter] [2] = $r->createtime;
			$bbsmessage [$counter] [3] = $r->updatetime;

			$counter ++;
		}

		return $bbsmessage;
	}

	/**
	 * BBSに登録されているメッセージ件数を取得する
	 *
	 * @return 登録されているメッセージ件数
	 */
	function messagecount() {
		// データベース接続
		$this->load->database ();

		$sql = "select count(*) as count from sample.bbs;";

		// 登録件数の確認
		$res = $this->db->query ( $sql );
		$regrows = $res->row_array ();
		$regrows = $regrows ["count"];

		return $regrows;
	}
}