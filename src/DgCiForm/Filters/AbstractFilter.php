<?php

namespace dg\DgCiForm\Filters;

abstract class AbstractFilter {

	protected $config;

	public function setConfig($config) {
		$this->config = $config;
	}

	abstract public function getFiltered($value);
}
