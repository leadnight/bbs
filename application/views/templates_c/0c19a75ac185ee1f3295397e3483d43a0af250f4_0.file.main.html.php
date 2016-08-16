<?php
/* Smarty version 3.1.29, created on 2016-08-16 16:33:58
  from "/mnt/hgfs/workspace/html/application/views/templates/yoyaku/main.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_57b2c1e681c3e5_44468912',
  'file_dependency' => 
  array (
    '0c19a75ac185ee1f3295397e3483d43a0af250f4' => 
    array (
      0 => '/mnt/hgfs/workspace/html/application/views/templates/yoyaku/main.html',
      1 => 1471329513,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57b2c1e681c3e5_44468912 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>予約管理ページ</title>
<style>
.delete{
color:red;
}
</style>
</head>
<body>
	<h1>予約管理ページ</h1>
	<p>こんにちは <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
 さん</p>
	<br>
	<br>
	<p>
		<a href="/yoyaku/profile/">アカウント設定</a>
	</p>
	<br>
	<br>
	<form action="/yoyaku/logout/" method="post" accept-charset="utf-8">
		<input type="submit" value="ログアウト">
	</form>
	<hr>
	<h2>予約品目一覧</h2>
	<p><?php echo $_smarty_tpl->tpl_vars['create_goods_error']->value;?>
</p>
	<form action="/yoyaku/creategoods/" method="post" accept-charset="utf-8">
		<input type="text" name="title">
		<input type="hidden"	name="check" value="1">
		<input type="submit" value="新規作成">
	</form>
	<br>
	<br>
	<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (count($_smarty_tpl->tpl_vars['goodslist']->value)-1)+1 - (0) : 0-((count($_smarty_tpl->tpl_vars['goodslist']->value)-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
		<a href="/yoyaku/loadgoods/<?php echo $_smarty_tpl->tpl_vars['goodslist']->value[$_smarty_tpl->tpl_vars['i']->value]['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['goodslist']->value[$_smarty_tpl->tpl_vars['i']->value]["id"];?>
:<?php echo $_smarty_tpl->tpl_vars['goodslist']->value[$_smarty_tpl->tpl_vars['i']->value]["name"];?>
</a>
		<br>
	<?php }
}
?>

	<hr>

	<?php if ($_smarty_tpl->tpl_vars['currentgoodsid']->value > 0) {?>
		<h2>新規予約</h2>
	<?php echo $_smarty_tpl->tpl_vars['yoyaku_error_message']->value;?>

	<form action="/yoyaku/createreservation/" method="post"
		accept-charset="utf-8">
		予約開始日時 : <select name="syear">
			<option value="2016">2016</option>
			<option value="2017">2017</option>
			<option value="2018">2018</option>
			<option value="2019">2019</option>
			<option value="2020">2020</option>
		</select>年
		<SELECT name="smonth">
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</SELECT> 月
		<SELECT name="sday">
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>日
		<select name="shour">
			<option value="00">0</option>
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
		</select> 時
		<select name="sminute">
			<option value="00">00</option>
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="50">50</option>
		</select> 分
		<br>
		予約終了日時 :
		<select name="eyear">
			<option value="2016">2016</option>
			<option value="2017">2017</option>
			<option value="2018">2018</option>
			<option value="2019">2019</option>
			<option value="2020">2020</option>
		</select>年
		<SELECT name="emonth">
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
		</SELECT> 月
		<SELECT name="eday">
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>日
		<select name="ehour">
			<option value="00">0</option>
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
		</select> 時
		<select name="eminute">
			<option value="00">00</option>
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="50">50</option>
		</select> 分
		<br>
		<input type="hidden" name="check" value="1">
		<input type="submit" value="予約作成">
	</form>
	<hr>
		<h2>予約状況:<?php echo $_smarty_tpl->tpl_vars['currentgoodsname']->value;?>
</h2>
		
	<?php }?>
	<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (count($_smarty_tpl->tpl_vars['reservationlist']->value)-1)+1 - (0) : 0-((count($_smarty_tpl->tpl_vars['reservationlist']->value)-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
		<p><?php echo $_smarty_tpl->tpl_vars['reservationlist']->value[$_smarty_tpl->tpl_vars['i']->value]["id"];?>
 : 予約日時 <?php echo $_smarty_tpl->tpl_vars['reservationlist']->value[$_smarty_tpl->tpl_vars['i']->value]["createtime"];?>
</p>
		<p>予約者 : <?php echo $_smarty_tpl->tpl_vars['reservationlist']->value[$_smarty_tpl->tpl_vars['i']->value]["username"];?>
</p>
		<p>開始 : <?php echo $_smarty_tpl->tpl_vars['reservationlist']->value[$_smarty_tpl->tpl_vars['i']->value]["start"];?>
</p>
		<p>終了 : <?php echo $_smarty_tpl->tpl_vars['reservationlist']->value[$_smarty_tpl->tpl_vars['i']->value]["end"];?>
</p>
		<?php if ($_smarty_tpl->tpl_vars['reservationlist']->value[$_smarty_tpl->tpl_vars['i']->value]["userid"] == $_smarty_tpl->tpl_vars['userid']->value) {?>
			<p class="delete"><a href = "/yoyaku/deletereservation_check/<?php echo $_smarty_tpl->tpl_vars['reservationlist']->value[$_smarty_tpl->tpl_vars['i']->value]['index'];?>
"><b>予約取り消し</b></a></p>
		<?php }?>
	<?php }
}
?>

	<?php if ($_smarty_tpl->tpl_vars['currentgoodsid']->value > 0) {?>
	<hr>
	<h2>コメント : <?php echo $_smarty_tpl->tpl_vars['currentgoodsname']->value;?>
</h2>
	<?php echo $_smarty_tpl->tpl_vars['comment_error']->value;?>

		<form action="/yoyaku/createcomment" method="post" accept-charset="utf-8">
		<textarea rows="10" cols="60" name="comment"></textarea>
		<input type="hidden" name="check" value="1">
		<input type="submit" value="書き込み">
	</form>
	<hr>
	<?php }?>
	<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? (count($_smarty_tpl->tpl_vars['commentlist']->value)-1)+1 - (0) : 0-((count($_smarty_tpl->tpl_vars['commentlist']->value)-1))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
		<p>ユーザー名 : <?php echo $_smarty_tpl->tpl_vars['commentlist']->value[$_smarty_tpl->tpl_vars['i']->value]["username"];?>
 (<?php echo $_smarty_tpl->tpl_vars['commentlist']->value[$_smarty_tpl->tpl_vars['i']->value]["createtime"];?>
) </p>
		<p><?php echo $_smarty_tpl->tpl_vars['commentlist']->value[$_smarty_tpl->tpl_vars['i']->value]["comment"];?>
</p>
	<?php }
}
?>

</body>
</html><?php }
}
