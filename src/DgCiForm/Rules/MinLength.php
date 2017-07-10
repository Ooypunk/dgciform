<?php

namespace dg\DgCiForm\Rules;

class MinLength extends AbstractRule {

	protected $error_message = 'Minimale lengte voor veld ":label:" is :config:.';

	public function getFiltered($value) {
		return substr($value, 0, (int) $this->config);
	}

	public function isValid($value = null) {
		return is_string($value) && strlen($value) > (int) $this->config;
	}

}
