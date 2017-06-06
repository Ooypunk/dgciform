<?php

namespace dg\DgCiForm\Elements;

use Volnix\CSRF\CSRF;
use dg\DgCiForm\Request;

class CsrfElement extends AbstractFormElement {

	const NAME_PREFIX = '_csrf_token_';

	public function __construct() {
		if (PHP_VERSION_ID < 50400) {
			// PHP < 5.4.0
			if (session_id() == '') {
				session_start();
			}
		} else {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
		}
	}

	public function getName() {
		return CSRF::getTokenName($this->name);
	}

	public function getValue() {
		return CSRF::getToken($this->name);
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
