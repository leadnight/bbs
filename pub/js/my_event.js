

$(document).ready(function() {

	var currentgoodsid = -1;

	//何らかの品目がクリックされた際に表示させるもの
	$(".hinmoku_click").click(function() {

		// クリックされた品目IDを保存しておく
		var st_sp = this.id.split("_");
		try {
			currentgoodsid = st_sp[1];
		} catch (e) {
			alert("品目IDが正常に取得できませんでした");
			console.log("品目ID取得エラー：" + e);
			return;
		}

		//フォームを表示する
		callform();

		//予約リストを表示する
		callreservation(currentgoodsid);

		//コメントリストを表示する
		callcomment(currentgoodsid);

		//コメントフォーム
		callcomment_form(currentgoodsid);
	})
});

//フォームを表示するAjax(非同期)
var callform = function() {
	//予約登録用のフォームを読み込む
	$.ajax({
		url : "/api/record/reservation_form",
		type : "get",
		data:{
			title:"新規登録",
		}
	}).done(function(data) {

		//もし、フォームがすでに表示されていた場合
		//フォームの入力内容が取れるはずなのでそれをキープする

		// 開始時間のデータ
		var syear = $("#syear").val() ? $("#syear").val() : -1000;
		var smonth = $("#smonth").val() ? $("#smonth").val() : -1001;
		var sday = $("#sday").val() ? $("#sday").val() : -1002;
		var shour = $("#shour").val() ? $("#shour").val() :-1003;
		var sminute = $("#sminute").val() ?$("#sminute").val() :-1004;

		// 終了時間のデータ
		var eyear = $("#eyear").val() ? $("#eyear").val() : -2000;
		var emonth=$("#emonth").val() ? $("#emonth").val() : -2001;
		var eday=$("#eday").val() ? $("#eday").val() : -2002;
		var ehour=$("#ehour").val() ? $("#ehour").val() :-2003;
		var eminute= $("#eminute").val() ?$("#eminute").val() :-2004;

		//フォームを出力
		$("#reservation_form").html(data);

		//スクロール
		$(window).scrollTop($("#reservation_form").offset().top);

		//フォーム入力内容の引き継ぎ
		$("#syear").val(syear);
		$("#smonth").val(smonth);
		$("#sday").val(sday);
		$("#shour").val(shour) ;
		$("#sminute").val(sminute);
		$("#eyear").val(eyear);
		$("#emonth").val(emonth);
		$("#eday").val(eday);
		$("#ehour").val(ehour) ;
		$("#eminute").val(eminute);

		// イベント追加
		$("#reservation_create").click(function() {
			$.ajax({
				url : "/api/record",
				type : "post",
				data : {
					// 開始時間のデータ
					syear : $("#syear").val() ? $("#syear").val() : -1000,
					smonth : $("#smonth").val() ? $("#smonth").val() : -1001,
					sday : $("#sday").val() ? $("#sday").val() : -1002,
					shour : $("#shour").val() ? $("#shour").val() :-1003,
					sminute : $("#sminute").val() ?$("#sminute").val() :-1004,

					// 終了時間のデータ
					eyear : $("#eyear").val() ? $("#eyear").val() : -2000,
					emonth:$("#emonth").val() ? $("#emonth").val() : -2001,
					eday:$("#eday").val() ? $("#eday").val() : -2002,
					ehour:$("#ehour").val() ? $("#ehour").val() :-2003,
					eminute: $("#eminute").val() ?$("#eminute").val() :-2004
				}
			}).done(function(message) {

				//予約実行結果を表示する
				$("#reservation_message").html(message);

				//予約リストを表示し直す
				callreservation(-1);
			})
		})

	})
}

var callcomment_form = function(currentgoodsid) {

	$.ajax({
	url:"api/comment/comment_form",
	type:"get",
	data :{
		goodsid : currentgoodsid,
	},
	}).done(function(data) {
		$("#comment_form").html(data);

		//コメント送信イベントを追加
		$("#comment_write").click(function(){

			//メッセージ除去
			$("#comment_write_message").html("");

			$.ajax({
				url : "/api/comment",
				type : "post",
				data : {
					comment:$("#comment_text").val(),
				},
			}).done(function(message){
				$("#comment_write_message").html(message);
				//コメントリスト再描画
				callcomment(currentgoodsid);

				//コメントを空にする
				$("#comment_text").val("");
			})
		})
	})

}

//コメントリストを表示するAjax(非同期)
var callcomment = function(currentgoodsid){

	$.ajax({
		url : "/api/comment",
		type : "get",
		data :{
			goodsid : currentgoodsid,
		}
	}).done(function(data) {
		$("#comment_list").html(data);
	})
}

//予約リストを表示するAjax(非同期)
var callreservation = function(currentgoodsid) {
	$.ajax({
		url : "/api/record",
		data : {
			goodsid : currentgoodsid,
			mode : 0
		},
		type : "get"
	}).done(function(data) {

		$("#reservation_list").html(data);

//		//更新ボタンにイベントを仕込む
//		$(".reservation_change_click").click(function() {
//
//			var reservation_change_index = -1;
//
//			// クリックされた品目IDを保存しておく
//			var st_sp = this.id.split("_");
//			try {
//				reservation_change_index = st_sp[2];
//			} catch (e) {
//				alert("予約更新インデックスが正常に取得できませんでした");
//				console.log("予約更新インデックス取得エラー：" + e);
//				return;
//			}
//
//			//PUTへ送信
//			$.ajax({
//				url : "/yoyaku/changereservation/",
//				type : "post",
//				data :{
//					index : reservation_change_index
//				}
//			}).done(function(data) {
//				$("#reservation_change_message").html(data);
//			})
//		})


	})
}
