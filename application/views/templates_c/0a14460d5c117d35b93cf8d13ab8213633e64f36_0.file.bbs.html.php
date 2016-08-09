<?php
/* Smarty version 3.1.29, created on 2016-08-09 17:27:12
  from "/mnt/hgfs/workspace/html/application/views/templates/bbs.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a993e088e779_96123291',
  'file_dependency' => 
  array (
    '0a14460d5c117d35b93cf8d13ab8213633e64f36' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/bbs.html',
      1 => 1470731225,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a993e088e779_96123291 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>超しょぼいBBS</title>
</head>
<body>
	<h1>仮設BBS</h1>

	<form action="/bbs/logout" method="post" accept-charset="utf-8">
		こんにちは <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
 さん <br>
		<br>
		<input type="submit" value="ログアウト">
	</form>

	<br>

	<hr>
	<h2>板一覧</h2>
	<form action="/bbs/createboard" method="post" accept-charset="utf-8">
		<input type="text" name = "title">
		<input type="hidden" name = "write2" value="1">
		<input type="submit" value="新規作成">
	</form>

	<br><br>
	<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (count($_smarty_tpl->tpl_vars['boardlist']->value)-1)+1 - (0) : 0-((count($_smarty_tpl->tpl_vars['boardlist']->value)-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
	<a href = "/bbs/loadboard/<?php echo $_smarty_tpl->tpl_vars['boardlist']->value[$_smarty_tpl->tpl_vars['i']->value][0];?>
"><?php echo $_smarty_tpl->tpl_vars['boardlist']->value[$_smarty_tpl->tpl_vars['i']->value][0];?>
(<?php echo $_smarty_tpl->tpl_vars['boardlist']->value[$_smarty_tpl->tpl_vars['i']->value][2];?>
):<?php echo $_smarty_tpl->tpl_vars['boardlist']->value[$_smarty_tpl->tpl_vars['i']->value][1];?>
</a>
	<br> <?php }
}
?>

	<hr>

	<?php if ($_smarty_tpl->tpl_vars['boardid']->value > 0) {?>
	<form action="/bbs/writemessage" method="post" accept-charset="utf-8">
		<textarea rows="10" cols="60" name="message"></textarea>
		<input type="hidden" name="write" value="1"> <input
			type="submit" value="書き込み">
	</form>
	<hr>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['boardid']->value > 0) {?>

	<h2><?php echo $_smarty_tpl->tpl_vars['boardname']->value;?>
[登録<?php echo $_smarty_tpl->tpl_vars['boardnum']->value;?>
件]</h2>

	<?php }?>

	<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (count($_smarty_tpl->tpl_vars['message']->value)-1)+1 - (0) : 0-((count($_smarty_tpl->tpl_vars['message']->value)-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
	<?php echo $_smarty_tpl->tpl_vars['message']->value[$_smarty_tpl->tpl_vars['i']->value][0];?>
:<?php echo $_smarty_tpl->tpl_vars['message']->value[$_smarty_tpl->tpl_vars['i']->value][2];?>

	<br>
	<br> <?php echo $_smarty_tpl->tpl_vars['message']->value[$_smarty_tpl->tpl_vars['i']->value][1];?>

	<br>

	<br> <?php }
}
?>


</body>
</html><?php }
}
