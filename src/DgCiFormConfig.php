<?php

namespace dg;

class DgCiFormConfig {

	private $config;

	public function __construct($config) {
		if (!is_array($config)) {
			throw new \Exception('Only array allowed as input.');
		}
		if (count($config) === 0) {
			throw new \Exception('Array is empty.');
		}
		$this->config = $config;
	}

	public function getSkin() {
		return isset($this->config['skin']) ? $this->config['skin'] : null;
	}

	public function getFormConfig($key) {
		if (!isset($this->config['forms'])) {
			throw new \Exception('Forms-var not found.');
		}
		$forms = $this->config['forms'];
		if (!isset($forms[$key]) || !is_array($forms[$key]) || count($forms[$key]) === 0) {
			throw new \Exception('Forms Key [' . $key . '] not found or invalid.');
		}
		return $forms[$key];
	}

}
