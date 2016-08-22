<?php
class Bbsmodel extends CI_Model {

	/**
	 * デフォルトコンストラクター
	 */
	function __construct() {
		parent::__construct ();
	}
	function createboard($title) {
		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "insert into sample.bbstable (boardname,num) values ($title,0);";

		// SQL実行
		$res = $this->db->query ( $sql );

		return $res;
	}

	/**
	 * 掲示板idの板情報をDBから抽出する
	 *
	 * @param unknown $boardid
	 *        	掲示板id,掲示板名,投稿数を配列にして返す
	 */
	function getboardinfo($boardid) {
		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "select * from sample.bbstable where boardid = $boardid;";

		// SQL実行
		$res = $this->db->query ( $sql );

		// 結果を取得
		$result = $res->row ();

		$bbsinfo = null;

		if ($result != null) {
			$bbsinfo ["boardid"] = $result->boardid;
			$bbsinfo ["boardname"] = $result->boardname;
			$bbsinfo ["num"] = $result->num;
		}

		return $bbsinfo;
	}

	/**
	 * 板一覧を取得
	 */
	function getboardlist() {
		// データベース接続
		$this->load->database ();

		// SQL
		$sql = "SELECT * FROM sample.bbstable order by boardid;";

		// SQL実行
		$res = $this->db->query ( $sql );

		// 結果を取得
		$result = $res->result ();

		$counter = 0;
		$bbsboard = array ();

		foreach ( $result as $r ) {

			$bbsboard [$counter] [0] = $r->boardid;
			$bbsboard [$counter] [1] = $r->boardname;
			$bbsboard [$counter] [2] = $r->num;

			$counter ++;
		}

		return $bbsboard;
	}

	/**
	 *
	 * @param string $message
	 *        	書き込み用のメッセージ
	 * @return boolean 書き込みの結果
	 */
	function insertmessage($message, $boardid) {
		// データベース接続
		$this->load->database ();

		// 最新の板情報を取得する
		$boardinfo = $this->getboardinfo ( $boardid );

		// このメッセージのレス番号
		$boardnum_w = $boardinfo ["num"] + 1;

		$sql = "update sample.bbstable set num=$boardnum_w where boardid = $boardid;";

		// SQL実行
		$res = $this->db->query ( $sql );

		// メッセージを挿入する
		$sql = "insert into sample.bbs (message,createtime,updatetime,boardid,boardnum)values($message,now(),now(),$boardid,$boardnum_w);";

		// SQL実行
		$res = $this->db->query ( $sql );

		return $res;
	}

	/**
	 * BBSデータ全件表示
	 */
	function getmessage($boardid) {
		return $this->getmessage_limit ( $boardid, 0 );
	}
	/**
	 * BBSデータ制限表示
	 * 引数で0以下を渡すと全件表示になる
	 *
	 * @return BBSデータ 配列で返される。
	 *         [][0]=管理番号
	 *         [][1]=メッセージ内容
	 *         [][2]=作成日時
	 *         [][3]=更新日時
	 */
	function getmessage_limit($boardid, $limit) {
		// データベース接続
		$this->load->database ();

		// データ呼び出し(全件表示)
		$sql = "select * from sample.bbs where boardid = $boardid order by createtime asc limit  $limit ;";

		// $limitが無効化されていた場合(0以下)SQL文を書き換える
		if ($limit <= 0) {
			$sql = "select * from sample.bbs where boardid = $boardid order by createtime asc;";
		}

		// SQL実行
		$res = $this->db->query ( $sql );

		$result = $res->result ();

		$counter = 0;
		$bbsmessage = array ();
		foreach ( $result as $r ) {

			$bbsmessage [$counter] [0] = $r->boardnum;
			$bbsmessage [$counter] [1] = nl2br ( $r->message, false ); // 改行コードの場所に<br>を入れる
			$bbsmessage [$counter] [2] = $r->createtime;
			$bbsmessage [$counter] [3] = $r->updatetime;

			$counter ++;
		}

		return $bbsmessage;
	}

	/**
	 * BBSに登録されているメッセージ件数を取得する
	 *
	 * @return int 登録されているメッセージ件数
	 */
	function messagecount($boardid) {
		// データベース接続
		$this->load->database ();

		$sql = "select count(*) as count from sample.bbs where boardid = $boardid;";

		// 登録件数の確認
		$res = $this->db->query ( $sql );
		$regrows = $res->row_array ();
		$regrows = $regrows ["count"];

		return $regrows;
	}
}