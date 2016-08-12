<?php
/* Smarty version 3.1.29, created on 2016-08-10 18:21:53
  from "/mnt/hgfs/workspace/html/application/views/templates/profile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57aaf2312a7524_09017744',
  'file_dependency' => 
  array (
    'fd8aade9d6ee8aa739f01e75bc966e5afdf4b737' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/profile.html',
      1 => 1470820911,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57aaf2312a7524_09017744 ($_smarty_tpl) {
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
		<a href="/bbs">トップページへ戻る</a>
	</p>
	<p>パスワードの変更</p>
	<?php  echo validation_errors(); ?>
	<form action="/bbs/changepassword" method="post" accept-charset="utf-8">
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
	<form action="/bbs/deleteuser" method="post" accept-charset="utf-8">
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
