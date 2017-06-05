<?php

namespace dg\DgCiForm;

class Request {

	private $method;

	private function __construct() {
		/*
		 * Constructor marked private, so "new Request" won't work.
		 * RequestData needs to be a Singleton, or else the element caching
		 * won't work properly.
		 */
		$this->method = strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD'));
	}

	/**
	 * Call this method to get singleton
	 *
	 * @return Request
	 */
	public static function instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new self();
		}
		return $inst;
	}

	public function getData($key) {
		switch ($this->method) {
			case 'post':
				return filter_input(INPUT_POST, $key);
			case 'get':
				return filter_input(INPUT_GET, $key);
			default:
				throw new \Exception('Method unknown: ' . $this->method);
		}
	}
}
