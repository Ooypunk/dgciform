<?php

namespace dg;

use dg\DgCiForm\ElementFactory;

class DgCiForm {

	public $factory;

	public function __construct() {
		$this->factory = new ElementFactory();
		print "<pre>";
		print_r($this);
		die('@debug in ' . __FILE__ . ' @' . __LINE__ . "\n");
	}

}
