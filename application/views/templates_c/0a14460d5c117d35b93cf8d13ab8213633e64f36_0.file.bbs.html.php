<?php
/* Smarty version 3.1.29, created on 2016-08-08 11:57:27
  from "/mnt/hgfs/workspace/html/application/views/templates/bbs.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a7f5179f1a03_18423441',
  'file_dependency' => 
  array (
    '0a14460d5c117d35b93cf8d13ab8213633e64f36' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/bbs.html',
      1 => 1470625046,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a7f5179f1a03_18423441 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>超しょぼいBBS</title>
</head>
<body>
	<h1>仮タイトル</h1>
	<form action="/bbs/regist" method="post" accept-charset="utf-8">
		<textarea rows="10" cols="60" name="message"></textarea>
		<input type="submit" value="書き込み">
	</form>


	<?php echo $_smarty_tpl->tpl_vars['regrows']->value;?>
件のメッセージが登録されています。
	<hr>

	<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (count($_smarty_tpl->tpl_vars['bbs']->value)-1)+1 - (0) : 0-((count($_smarty_tpl->tpl_vars['bbs']->value)-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>

	<?php echo $_smarty_tpl->tpl_vars['bbs']->value[$_smarty_tpl->tpl_vars['i']->value][0];?>
:<?php echo $_smarty_tpl->tpl_vars['bbs']->value[$_smarty_tpl->tpl_vars['i']->value][2];?>
<br><br>
	<?php echo $_smarty_tpl->tpl_vars['bbs']->value[$_smarty_tpl->tpl_vars['i']->value][1];?>
<br>

	<br>

	<?php }
}
?>


</body>
</html><?php }
}
