<?php

class Record extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // ライブラリをロード
        $this->load->library("Yoyaku_c_stlib");
        $this->load->library("My_smarty_lib", "", "mylib");
    }

    /**
     * 予約フォームを表示するためのAPI
     */
    function reservation_form()
    {
        $title = $this->input->get("title") ? $this->input->get("title") : "新規登録";

        $this->mylib->setsmarty("title", $title);

        echo $this->smarty->view("yoyaku/part/reservation_form.html");

        log_message("debug", "予約フォームAPIが呼ばれたよ");
    }

    /**
     * 予約一覧を取得するAPI
     * postで品目IDを送信するか
     * セッションに保存されている品目IDを利用
     */
    function get()
    {
        $currentgoodsid = -10;
        $mode = 0;

        // ユーザーIDはセッションに保存されている（はず）
        $userid = isset ($_SESSION ["userid"]) ? $_SESSION ["userid"] : -1;

        if ($this->input->get("goodsid")) {
            $currentgoodsid = $this->input->get("goodsid");

            // 渡されてきたIDが無効フラグ(-1)だった場合,セッションから読み込む
            if (($currentgoodsid == -1) && (isset ($_SESSION ['current_goodsid']))) {
                $currentgoodsid = $_SESSION ['current_goodsid'];
            }
        }
        if ($this->input->get("mode")) {
            $userid = $this->input->get("mode");
        }

        // 現在選択中の品目名
        $currntgoodsname = "";

        // 品目情報を取得
        $res = $this->Yoyakumodel->getgoodsinfo($currentgoodsid);

        // 品目情報が正常に取得されていた場合
        if (count($res) > 0) {
            $currntgoodsname = $res ["goodsname"];

            // セッションに現在選択された品目IDと名前を入れる
            $_SESSION ["current_goodsid"] = $res ["goodsid"];
            $_SESSION ["current_goodsname"] = $res ["goodsname"];
        }

        // 予約一覧を取得
        $res = $this->Yoyakumodel->getgoodsreservation($currentgoodsid, $mode);
        $reservationlist = $res;

        // セッションに予約一覧を突っ込んでおく
        $_SESSION ["reservationliost"] = $res;

        // 描画のためにセット
        $this->mylib->setsmarty("currentgoodsid", $currentgoodsid);
        $this->mylib->setsmarty("currentgoodsname", $currntgoodsname);
        $this->mylib->setsmarty("reservationlist", $reservationlist);
        $this->mylib->setsmarty("userid", $userid);

        echo $this->smarty->view("yoyaku/part/reservation_list.html");
    }

    /**
     * 予約を作成するAPI
     */
    function post()
    {

    	//レスポンス用の配列
    	$resary =array();

        // 送信された内容を取得
        $syear = $this->input->post("syear") ? $this->input->post("syear") : -1;
        $smonth = $this->input->post("smonth") ? $this->input->post("smonth") : -2;
        $sday = $this->input->post("sday") ? $this->input->post("sday") : -3;
        $shour = $this->input->post("shour") ? $this->input->post("shour") : -4;
        $sminute = $this->input->post("sminute") ? $this->input->post("sminute") : -5;

        $startarray = array(
            $syear,
            $smonth,
            $sday,
            $shour,
            $sminute
        );

        $eyear = $this->input->post("eyear") ? $this->input->post("eyear") : -11;
        $emonth = $this->input->post("emonth") ? $this->input->post("emonth") : -12;
        $eday = $this->input->post("eday") ? $this->input->post("eday") : -13;
        $ehour = $this->input->post("ehour") ? $this->input->post("ehour") : -14;
        $eminute = $this->input->post("eminute") ? $this->input->post("eminute") : -15;

        $endarray = array(
            $eyear,
            $emonth,
            $eday,
            $ehour,
            $eminute
        );

        // 自分で整形
        $start = $syear . "-" . $smonth . "-" . $sday . " " . $shour . ":" . $sminute . ":00";
        $end = $eyear . "-" . $emonth . "-" . $eday . " " . $ehour . ":" . $eminute . ":00";

        // 仮初期化
        $starttime = new DateTime ();
        $endtime = new DateTime ();

        // postされたデータが不正だとエラーを吐くので、try-catchで対処
        try {
            $starttime = new DateTime ($start);
            $endtime = new DateTime ($end);
        } catch (Exception $e) {
            log_message("error", "予約日時の生成に失敗しました");

            $resary["response"] = false;
            $resary["message"]="予約日時が選択されていません。";

            echo json_encode( $resary);
            return;
        }

        // 現在の時刻を取得
        $now = new DateTime ();

        // エラーメッセージ
        unset ($errormessage);

        // 開始時間が過去になっている場合
        if ($starttime < $now) {
            $errormessage = Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_START;
        }

        // 終了時刻が開始時刻より早い状態
        if ($starttime >= $endtime) {
            if (isset ($errormessage)) {
                $errormessage = $errormessage . Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_END;
            } else {
                $errormessage = Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_END;
            }
        }

        // 予約重複のチェック
        if (!$this->Yoyakumodel->checkreservation($_SESSION ['current_goodsid'], $start, $end)) {
            if (isset ($errormessage)) {
                $errormessage = $errormessage . Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_DUPLICATE;
            } else {
                $errormessage = Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_DUPLICATE;
            }
        }

        // 一応セーフティーに動かすために
        // セッションにuseridとcurrent_goodsidが仕込まれてるかチェックする
        if (!isset ($_SESSION ["userid"], $_SESSION ['current_goodsid'])) {
            if (isset ($errormessage)) {
                $errormessage = $errormessage . "エラーが発生しました。";
            } else {
                $errormessage = "エラーが発生しました。";
            }
            log_message("error", "セッションに必要な情報が格納されていません。");
        }

        // エラーが発生してる場合
        if (isset ($errormessage)) {

        	$resary["response"] = false;
        	$resary["message"]=$errormessage;

        } else {
            // 予約実行
            $res = $this->Yoyakumodel->createreservation($_SESSION ["userid"], $_SESSION ['current_goodsid'], $start, $end, "0");

            $resary["response"] = true;
            $resary["message"]="予約が完了しました。";
        }

        echo json_encode($resary);
    }

    function put()
    {

        //操作対象の予約IDを取得
        $reservationid = $this->input->input_stream("reservationid") ? $this->input->input_stream("reservationid") : -100;

        // 送信された内容を取得
        $syear = $this->input->input_stream("syear") ? $this->input->input_stream("syear") : -1;
        $smonth = $this->input->input_stream("smonth") ? $this->input->input_stream("smonth") : -2;
        $sday = $this->input->input_stream("sday") ? $this->input->input_stream("sday") : -3;
        $shour = $this->input->input_stream("shour") ? $this->input->input_stream("shour") : -4;
        $sminute = $this->input->input_stream("sminute") ? $this->input->input_stream("sminute") : -5;

        $startarray = array(
            $syear,
            $smonth,
            $sday,
            $shour,
            $sminute
        );

        $eyear = $this->input->input_stream("eyear") ? $this->input->input_stream("eyear") : -11;
        $emonth = $this->input->input_stream("emonth") ? $this->input->input_stream("emonth") : -12;
        $eday = $this->input->input_stream("eday") ? $this->input->input_stream("eday") : -13;
        $ehour = $this->input->input_stream("ehour") ? $this->input->input_stream("ehour") : -14;
        $eminute = $this->input->input_stream("eminute") ? $this->input->input_stream("eminute") : -15;

        $endarray = array(
            $eyear,
            $emonth,
            $eday,
            $ehour,
            $eminute
        );

        // 自分で整形
        $start = $syear . "-" . $smonth . "-" . $sday . " " . $shour . ":" . $sminute . ":00";
        $end = $eyear . "-" . $emonth . "-" . $eday . " " . $ehour . ":" . $eminute . ":00";

        // 仮初期化
        $starttime = new DateTime ();
        $endtime = new DateTime ();

        // postされたデータが不正だとエラーを吐くので、try-catchで対処
        try {
            $starttime = new DateTime ($start);
            $endtime = new DateTime ($end);
        } catch (Exception $e) {
            log_message("error", "予約日時の生成に失敗しました");
            echo "<p>選択肢が正しく選ばれていません。</p>";
            return;
        }

        // 現在の時刻を取得
        $now = new DateTime ();

        // エラーメッセージ
        unset ($errormessage);

        // 開始時間が過去になっている場合
        if ($starttime < $now) {
            $errormessage = Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_START;
        }

        // 終了時刻が開始時刻より早い状態
        if ($starttime >= $endtime) {
            if (isset ($errormessage)) {
                $errormessage = $errormessage . Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_END;
            } else {
                $errormessage = Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_END;
            }
        }

        // 予約重複のチェック
        if (!$this->Yoyakumodel->checkreservation_update($_SESSION ['current_goodsid'], $start, $end, $reservationid)) {
            if (isset ($errormessage)) {
                $errormessage = $errormessage . Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_DUPLICATE;
            } else {
                $errormessage = Yoyaku_c_stlib::CREATE_RESERVATION_ERROR_MESSAGE_DUPLICATE;
            }
        }

        // 一応セーフティーに動かすために
        // セッションにuseridとcurrent_goodsidが仕込まれてるかチェックする
        if (!isset ($_SESSION ["userid"], $_SESSION ['current_goodsid'])) {
            if (isset ($errormessage)) {
                $errormessage = $errormessage . "エラーが発生しました。";
            } else {
                $errormessage = "エラーが発生しました。";
            }
            log_message("error", "セッションに必要な情報が格納されていません。");
        }

        // エラーが発生してる場合
        if (isset ($errormessage)) {
            // エラーメッセージを吐く
            echo $errormessage;
        } else {
            // 予約更新
            $res = $this->Yoyakumodel->updatereservation($_SESSION ["userid"], $reservationid, $start, $end);
            // 通常メッセージを吐く
            echo "<p>予約が更新されました。トップページへ移動します。</p>";

            //メッセージを表示させて移動しちゃう
            $jump = <<<EOM
<script>
// 一定時間経過後に指定ページにジャンプする
mnt = 5; // 何秒後に移動するか？
url = "/"; // 移動するアドレス
function jumpPage() {
  location.href = url;
}
setTimeout("jumpPage()",mnt*1000)
</script>
EOM;

            echo $jump;
        }
    }

    function del()
    {

        // 消す予定の予約idを取得
        $reservationid = $this->input->input_stream("reservationid") ? $this->input->input_stream("reservationid") : -1;

        // 消す
        // 現在ログインしてるユーザーの情報しか消せないようにしてある
        $res = $this->Yoyakumodel->deletereservation($_SESSION ["userid"], $reservationid);

        // 結果出力
        if ($res) {
            echo "<p>予約は削除されました。トップページへ移動します。</p>";

            //メッセージを表示させて移動しちゃう
            $jump = <<<EOM
<script>
// 一定時間経過後に指定ページにジャンプする
mnt = 5; // 何秒後に移動するか？
url = "/"; // 移動するアドレス
function jumpPage() {
  location.href = url;
}
setTimeout("jumpPage()",mnt*1000)
</script>
EOM;

            //echo $jump;
        } else {
            echo "エラーが発生しました。管理者に連絡してください。[コード $reservationid]";
            log_message("error", "予約削除エラーが発生しまいた。[コード $reservationid]");
        }
    }
}