<?php

/**
 * ログイン用API基底クラス
 */
class Login extends CI_Controller
{
    /**
     * Login constructor.
     * デフォルトコンストラクタ
     */
    function __construct()
    {
        parent::__construct();

        // ライブラリをロード
        $this->load->library("Yoyaku_c_stlib");
        $this->load->library("My_smarty_lib", "", "mylib");
    }


    /**
     * ログインAPI
     * HTMLコードを吐き出す
     */
    function get()
    {

        // ユーザー名とパスワードの取得
        $username = $this->input->get("username") ? $this->input->get("username") : "";
        $password = $this->input->get("password") ? $this->input->get("password") : "";

        // ログイン
        // 失敗した場合は空の配列が返ってくる
        $res = $this->Loginmodel->login_userinfo($username, $password);

        // 成功すればセッション変数にユーザー名をセット
        // 失敗した場合メッセージを出力
        if (count($res) > 0) {
            // ログイン成功
            $_SESSION ["username"] = $res ["username"];
            $_SESSION ["userid"] = $res ["userid"];
            log_message("info", "[$username]のログイン成功");
            echo "<p>ログインに成功しました。トップページへ移行します。</p>";

            //メッセージを表示させてトップページへ飛ばしちゃう
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

        } else {
            // ログイン失敗
            log_message("error", "[$username]のログイン失敗 ($_SERVER[REMOTE_ADDR])");
            echo "<p>ログイン情報に誤りがあります。</p>";
        }

    }
}