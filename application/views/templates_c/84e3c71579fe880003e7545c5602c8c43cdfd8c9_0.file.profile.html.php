<?php
/* Smarty version 3.1.29, created on 2016-08-12 14:47:26
  from "/mnt/hgfs/workspace/html/application/views/templates/yoyaku/profile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57ad62eec86168_62977874',
  'file_dependency' => 
  array (
    '84e3c71579fe880003e7545c5602c8c43cdfd8c9' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/yoyaku/profile.html',
      1 => 1470978954,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57ad62eec86168_62977874 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ユーザー情報の変更</title>
<style>
input#delete_button {
	background-color: #000;
	color: #fff;
}
</style>
</head>
<body>
	ユーザー名 [ <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
 ]
	<br>
	<p>
		<a href="/yoyaku">トップページへ戻る</a>
	</p>
	<p>パスワードの変更</p>
	<?php  echo validation_errors(); ?>
	<form action="/yoyaku/changepassword" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<th>新しいパスワード</th>
				<td><input type="password" name="newpassword"></td>
			</tr>
		</table>
		<input type="hidden" name="check" value="1"><br> <input
			type="submit" name="pass" value="パスワード更新">
	</form>
	<br>
	<br>
	<p>ユーザーの削除</p>
	<form action="/yoyaku/deleteuser" method="post" accept-charset="utf-8">
	<?php echo $_smarty_tpl->tpl_vars['myerrormessage']->value;?>

		<table>
			<tr>
				<th>パスワード</th>
				<td><input type="password" name="password"></td>
			</tr>
		</table>
		<input type="hidden" name="check" value="1">
		<input type="submit" id="delete_button" name="delete" value="ユーザーの削除">
	</form>

</body>
</html><?php }
}
