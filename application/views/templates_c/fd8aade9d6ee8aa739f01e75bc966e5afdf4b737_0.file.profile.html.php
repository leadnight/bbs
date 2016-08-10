<?php
/* Smarty version 3.1.29, created on 2016-08-10 15:39:43
  from "/mnt/hgfs/workspace/html/application/views/templates/profile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57aacc2f36ffc4_23466647',
  'file_dependency' => 
  array (
    'fd8aade9d6ee8aa739f01e75bc966e5afdf4b737' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/profile.html',
      1 => 1470811181,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57aacc2f36ffc4_23466647 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ユーザー情報の変更</title>
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
	<form action="/bbs/changepassward" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<th>古いパスワード</th>
				<td><input type="password" name="oldpassward"></td>
			</tr>
			<tr>
				<th>新しいパスワード</th>
				<td><input type="password" name="newpassward"></td>
			</tr>
		</table>
		<input type="hidden" name="check" value="1"><br> <input
			type="submit" name="pass" value="パスワード更新">
	</form>

</body>
</html><?php }
}
