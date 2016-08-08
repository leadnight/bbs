<?php
/* Smarty version 3.1.29, created on 2016-08-05 17:49:13
  from "/mnt/hgfs/workspace/html/application/views/templates/bbs.php" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57a45309dc6fd0_14033626',
  'file_dependency' => 
  array (
    '73c443e4ec920ef593e05a4a9cde46262ffe8a11' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/bbs.php',
      1 => 1470386909,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57a45309dc6fd0_14033626 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>超しょぼいBBS</title>
</head>
<body>
	<h1>仮タイトル</h1>
	<form action=""></form>
	<?php echo $_smarty_tpl->tpl_vars['regrows']->value;?>
件のメッセージが登録されています。
	<hr>
	<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (count($_smarty_tpl->tpl_vars['bbs']->value)-1)+1 - (0) : 0-((count($_smarty_tpl->tpl_vars['bbs']->value)-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?> <?php echo $_smarty_tpl->tpl_vars['bbs']->value[$_smarty_tpl->tpl_vars['i']->value][0];?>
:<?php echo $_smarty_tpl->tpl_vars['bbs']->value[$_smarty_tpl->tpl_vars['i']->value][1];?>

	<br> <?php }
}
?>

</body>
</html><?php }
}
