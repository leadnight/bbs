<?php
/* Smarty version 3.1.29, created on 2016-08-16 10:59:06
  from "/mnt/hgfs/workspace/html/application/views/templates/yoyaku/createuser.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57b2736a2f5708_27582951',
  'file_dependency' => 
  array (
    'cf4a67b10558a003230a15d9cfe40b168acb3e77' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/yoyaku/createuser.html',
      1 => 1470985643,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57b2736a2f5708_27582951 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>楽しいユーザー登録</title>
</head>
<body>
<h1>ユーザー登録</h1>
<?php  echo validation_errors();
echo $_smarty_tpl->tpl_vars['myerrormessage']->value;?>

	<form action="/yoyaku/createuser/" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<th>ユーザー名</th>
				<td><input type="text" name="username" value="<?php  echo set_value('username'); ?>"></td>
			</tr>
			<tr>
				<th>パスワード</th>
				<td><input type="password" name="password"></td>
			</tr>
		</table>
		<input type="hidden" name = "check" value="1">
		<input type="submit" value="登録">

	</form>

	<p><a href="/yoyaku/">トップページへ戻る</a></p>
</body>
</html><?php }
}
