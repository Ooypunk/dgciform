<?php

namespace dg\DgCiForm\Filters;

class LimitLength extends AbstractFilter {

	public function getFiltered($value) {
		return substr($value, 0, (int) $this->config);
	}

}
