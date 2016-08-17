<?php
class Yoyakumodel extends CI_Model {

	function createcomment($userid, $goodsid, $comment){

		$sql = "insert into sample.goods_comment (user_id,goods_id,createtime,updatetime,comment) values(?,?,now(),now(),?);";

		$res=$this->db->query($sql,array($userid,$goodsid,$comment));

		return $res;

	}

	function getgoodscomment($goodsid) {
		$sql = "select sample.goods_comment.*,sample.user.username from sample.goods_comment left join sample.user on sample.goods_comment.user_id = sample.user.id where goods_id=? order by createtime asc;";

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

			$ret [$counter] ["comment"] =$r->comment;

			$ret [$counter] ["username"] = $r->username;

			$counter ++;
		}

		return $ret;
	}
	function creategoods($title) {
		$sql = "insert into sample.goods_list (name) values (?); ";

		$res = $this->db->query ( $sql, $title );

		return $res;
	}
	function deletereservation($userid, $reservationid) {
		$sql = "delete from sample.goods_reservation where user_id = ? and id = ?;";

		$res = $this->db->query ( $sql, array (
				$userid,
				$reservationid
		) );

		return $res;
	}
	function createreservation($userid, $goodsid, $start, $end, $status) {
		$sql = "insert into sample.goods_reservation (user_id,goods_id,start,end,status,createtime,updatetime) values (?,?,?,?,?,now(),now());";

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
		$sql = "select * from sample.goods_reservation where goods_id = ? and ((start <= ? and end > ?) or (end >= ? and start < ?));";

		$res = $this->db->query ( $sql, array (
				$goodsid,
				$start,
				$start,
				$end,
				$end
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
		$sql = "SELECT * FROM sample.goods_list where id = ?;";

		$res = $this->db->query ( $sql, $goodsid );

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
		$sql = "SELECT sample.goods_reservation.*,sample.user.username FROM sample.goods_reservation left join sample.user on sample.goods_reservation.user_id = sample.user.id where goods_id = ? order by start asc";



		// 実行
		$res = $this->db->query ( $sql, $goodsid );

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

		// SQLの設定
		$this->db->order_by ( "id", "asc" );

		// 実行
		$res = $this->db->get ( "sample.goods_list" );

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