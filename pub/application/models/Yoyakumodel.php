<?php
class Yoyakumodel extends CI_Model {

	/**
	 * デフォルトコンストラクタ
	 */
	function  __construct(){
		parent::__construct();

		//ライブラリをロード
		$this->load->library ( "Yoyaku_m_stlib" );
	}

	/**
	 * コメントを書き込む
	 * @param int $userid
	 * @param int $goodsid
	 * @param string $comment
	 * @return DBへのデータ挿入結果
	 */
	function createcomment($userid, $goodsid, $comment) {
		$sql = Yoyaku_m_stlib::CREATE_COMMENT;

		$res = $this->db->query ( $sql, array (
				$userid,
				$goodsid,
				$comment
		) );

		return $res;
	}
	/**
	 * 品目に結び付けられているコメント一覧を取得する
	 * @param int $goodsid 品目
	 */
	function getgoodscomment($goodsid) {
		//SQLの設定
		$sql =Yoyaku_m_stlib::GET_GOODS_COMMENT;

		$res = $this->db->query ( $sql, $goodsid );

		$counter = 0;
		$ret = array ();
		foreach ( $res->result () as $r ) {

			// 単純に配列に詰めた時のインデックスを保存しておきたい
			$ret [$counter] ["index"] = $counter;

			$ret [$counter] ["id"] = $r->id;
			$ret [$counter] ["userid"] = $r->user_id;
			$ret [$counter] ["goodsid"] = $r->goods_id;
			$ret [$counter] ["createtime"] = $r->createtime;
			$ret [$counter] ["updatetime"] = $r->updatetime;
			$ret [$counter] ["comment"] = $r->comment;

			//leftjoinしたユーザー名
			$ret [$counter] ["username"] = $r->username;

			$counter ++;
		}

		return $ret;
	}
	function creategoods($title) {
		$sql = Yoyaku_m_stlib::CREATE_GOODS;

		$res = $this->db->query ( $sql, $title );

		return $res;
	}
	function deletereservation($userid, $reservationid) {
		$ret = false;

		// selectで対象のレコードが存在するかチェックする
		$sql = Yoyaku_m_stlib::EXIST_RESERVATION;

		$res = $this->db->query ( $sql, array (
				$userid,
				$reservationid
		) );

		if ($res->num_rows () === 1) {
			$ret = true;

			//削除操作(実際にはレコードは削除せず、無効フラグを立てる)
			$sql = Yoyaku_m_stlib::DELETE_RESERVATION;

			$res = $this->db->query ( $sql, array (
					$userid,
					$reservationid
			) );
		}

		return $ret;
	}
	function createreservation($userid, $goodsid, $start, $end, $status) {
		$sql = Yoyaku_m_stlib::CREATE_RESERVATION;

		$res = $this->db->query ( $sql, array (
				$userid,
				$goodsid,
				$start,
				$end,
				$status
		) );

		return $res;
	}
	function checkreservation($goodsid, $start, $end) {
		$ret = false;

		// SQL文
		$sql = Yoyaku_m_stlib::CHECK_RESERVATION;

		$res = $this->db->query ( $sql, array (
				$goodsid,
				$start,
				$end,
				$start,
				$end,
				$start,
				$end,
				$start,
				$end,

		) );

		// 予約が重複してなかった場合
		if ($res->num_rows () == 0) {
			$ret = true;
		}

		return $ret;
	}

	/**
	 * 引数で与えたgoodsidの情報を取得する
	 *
	 * @param unknown $goodsid
	 * @return unknown
	 */
	function getgoodsinfo($goodsid) {
		$sql = Yoyaku_m_stlib::GET_GOODS_INFO;

		$res = $this->db->query ( $sql, $goodsid);

		if ($res->num_rows () == 1) {
			$r = $res->row ();

			// 自動採番なので安全
			$ret ["goodsid"] = $r->id;
			$ret ["goodsname"] = $r->name;

			return $ret;
		}

		return array ();
	}
	/**
	 * 指定されたgoodsidの予約一覧を取得する
	 *
	 * @param unknown $goodsid
	 */
	function getgoodsreservation($goodsid, $flag) {

		// 生成するSQL
		$sql = Yoyaku_m_stlib::GET_GOODS_RESERVATION;
		// 実行
		$res = $this->db->query ( $sql, array($goodsid,$flag) );

		$counter = 0;
		$ret = array ();
		foreach ( $res->result () as $r ) {

			// 単純に配列に詰めた時のインデックスを保存しておきたい
			// 予約削除の時に使う
			$ret [$counter] ["index"] = $counter;

			$ret [$counter] ["id"] = $r->id;
			$ret [$counter] ["userid"] = $r->user_id;
			$ret [$counter] ["goodsid"] = $r->goods_id;
			$ret [$counter] ["start"] = $r->start;
			$ret [$counter] ["end"] = $r->end;
			$ret [$counter] ["status"] = $r->status;
			$ret [$counter] ["createtime"] = $r->createtime;
			$ret [$counter] ["updatetime"] = $r->updatetime;
			$ret [$counter] ["username"] = $r->username;

			$counter ++;
		}
		return $ret;
	}
	/**
	 * 品目一覧を取得する
	 */
	function loadgoodslist() {

		// SQL
		$sql = Yoyaku_m_stlib::GET_GOODS_LISt;

		//実行
		$res = $this->db->query ( $sql );

		// 結果を取り出す
		$result = $res->result ();

		$counter = 0;
		$goodslist = array ();

		foreach ( $result as $r ) {

			$goodslist [$counter] ["id"] = $r->id;
			$goodslist [$counter] ["name"] = $r->name;

			$counter ++;
		}

		return $goodslist;
	}
}