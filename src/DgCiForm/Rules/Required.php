<?php

namespace dg\DgCiForm\Rules;

class Required extends AbstractRule {

	public function getFiltered($value) {
		return substr($value, 0, (int) $this->config);
	}

	public function isValid($value = null) {
		return !empty($value);
	}

}
