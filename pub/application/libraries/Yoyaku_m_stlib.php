<?php
if (! defined ( 'BASEPATH' )) {
	exit ( 'No direct script access allowed' );
}
/**
 * Yoyaku model で利用するSQL文のライブラリ
 * @author n-hiiro
 */
class Yoyaku_m_stlib {
	/**
	 * コメント書き込み
	 * @var string
	 */
	const CREATE_COMMENT = "insert into goods_comment (user_id,goods_id,createtime,updatetime,comment)
			values(?,?,now(),now(),?);";

	/**
	 * コメント取得
	 * @var string
	 */
	const GET_GOODS_COMMENT = "select goods_comment.*,user.username from goods_comment
			left join user on goods_comment.user_id = user.id where goods_id=? order by createtime asc;";

	/**
	 * 項目追加
	 * @var string
	 */
	const CREATE_GOODS = "insert into goods_list (name) values (?); ";

	/**
	 * 予約レコード存在チェック
	 * @var string
	 */
	const EXIST_RESERVATION =  "select * from goods_reservation where user_id = ? and id = ?;";

	/**
	 * 予約レコード削除(実際は削除フラグを立てる)
	 * @var string
	 */
	const DELETE_RESERVATION ="update goods_reservation set status=-1 where user_id = ? and id = ?;";

	/**
	 * 予約レコード作成
	 * @var string
	 */
	const CREATE_RESERVATION ="insert into goods_reservation
			(user_id,goods_id,start,end,status,createtime,updatetime) values (?,?,?,?,?,now(),now());";

	/**
	 * 予約レコード重複チェック
	 * @var string
	 */
	const CHECK_RESERVATION = "select * from goods_reservation where goods_id = ? and
			status = 0 and ((start >= ? and start < ?) or (start <= ? and end >= ?) or (end > ? and end <= ?) or (start >= ? and end <= ?));";

	/**
	 * 予約レコード取得
	 * @var string
	 */
	const GET_GOODS_RESERVATION = "SELECT goods_reservation.*,user.username FROM
			goods_reservation left join user on goods_reservation.user_id = user.id
			where goods_id = ? and goods_reservation.status = ? order by start asc";

	/**
	 * 項目情報取得
	 * @var string
	 */
	const GET_GOODS_INFO = "SELECT * FROM goods_list where id = ?;";

	/**
	 * 項目リスト取得
	 * @var string
	 */
	const GET_GOODS_LISt = "select * from goods_list order by id asc";
}