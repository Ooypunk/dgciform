<?php

namespace dg\DgCiForm\Elements;

class FormOpenElement extends AbstractElement {

	protected $method = 'post';
	protected $action;
	protected $config_keys = ['method', 'action'];

	const METHOD_POST = 'post';
	const METHOD_GET = 'get';

	public function getAction() {
		return $this->action;
	}

	public function setAction($action) {
		$this->action = $action;
		return $this;
	}

	public function getMethod() {
		return $this->method;
	}

	public function setMethod($method) {
		$this->method = $method;
		return $this;
	}

}
