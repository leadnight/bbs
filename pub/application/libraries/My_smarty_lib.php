<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class My_smarty_lib {
	/**
	 * Smartyに出力するためにhtmlエスケープと変数セットをする
	 *
	 * @param unknown $name
	 *        	セットする変数名
	 * @param unknown $val
	 *        	セットする変数
	 */
	function setsmarty($name, $val) {
		$CI =& get_instance();
		$CI->smarty->assign ( $name, static::myhtmlescape ( $val ) );
	}
	/**
	 * htmlのエスケープをする
	 *
	 * @param $string 文字列または配列
	 */
	function myhtmlescape($string) {
		if (is_array ( $string )) {
			return array_map ( 'static::myhtmlescape', $string );
		} else {
			return htmlspecialchars ( $string, ENT_QUOTES, "UTF-8" );
		}
	}
}