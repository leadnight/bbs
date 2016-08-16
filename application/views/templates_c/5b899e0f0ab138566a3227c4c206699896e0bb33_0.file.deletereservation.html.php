<?php
/* Smarty version 3.1.29, created on 2016-08-15 17:57:59
  from "/mnt/hgfs/workspace/html/application/views/templates/yoyaku/deletereservation.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57b184177d2223_89211147',
  'file_dependency' => 
  array (
    '5b899e0f0ab138566a3227c4c206699896e0bb33' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/yoyaku/deletereservation.html',
      1 => 1471249753,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57b184177d2223_89211147 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>削除確認</title>
<style>
.delete{
	padding:10px;
	font-size:20pt;
}
</style>
</head>
<body>
<p>本当に以下の予約を削除しますか？</p>
		<p>予約ID : <?php echo $_smarty_tpl->tpl_vars['reservation']->value["id"];?>
</p>
		<p>予約日時 : <?php echo $_smarty_tpl->tpl_vars['reservation']->value["createtime"];?>
</p>
		<p>予約者 : <?php echo $_smarty_tpl->tpl_vars['reservation']->value["username"];?>
</p>
		<p>開始 : <?php echo $_smarty_tpl->tpl_vars['reservation']->value["start"];?>
</p>
		<p>終了 : <?php echo $_smarty_tpl->tpl_vars['reservation']->value["end"];?>
</p>
	<form action="/yoyaku/deletereservation/" method="post" accept-charset="utf-8">
		<input type="hidden"	name="check" value="1">
		<input type="hidden" name = "reservationid" value="<?php echo $_smarty_tpl->tpl_vars['reservation']->value['id'];?>
">
		<input type="submit" value="削除" class="delete">
	</form>
<br>
<a href="/yoyaku">トップページへ戻る</a>
</body>
</html><?php }
}
