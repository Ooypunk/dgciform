<?php

namespace dg\DgCiForm\Filters;

class Trim extends AbstractFilter {

	public function getFiltered($value) {
		return trim($value);
	}

}
