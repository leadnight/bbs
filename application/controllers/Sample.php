<?php
class Sample extends CI_Controller {
	public function index() {
		$data ['title'] = 'hello world';
		$this->smarty->assign("test","hehehe");
		$this->smarty->view('example.tpl');
	}
}

?>
