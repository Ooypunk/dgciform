<?php

namespace dg\DgCiForm\Elements;

use Volnix\CSRF\CSRF;
use dg\DgCiForm\Request;

class CsrfElement extends AbstractFormElement {

	const NAME_PREFIX = '_csrf_token_';

	public function getName() {
		return CSRF::getTokenName($this->name);
	}

	public function getValue() {
		return CSRF::getToken();
	}

	public function setName($name) {
		parent::setName(self::NAME_PREFIX . $name);
	}

	public function isValid() {
		$request = Request::instance();
		$request_data = [
			$this->getName() => $request->getData($this->getName()),
		];
		return CSRF::validate($request_data, $this->getName());
	}

}
