<?php

namespace dg\DgCiForm;

class FilterFactory {

	private $cache = [];

	const FILTER_TRIM = 'trim';
	const FILTER_LIMIT_LENGTH = 'limitLength';

	private function __construct() {
		/*
		 * Constructor marked private, so "new FilterFactory" won't work.
		 * FilterFactory needs to be a Singleton, or else the element caching
		 * won't work properly.
		 */
	}

	/**
	 * Call this method to get singleton
	 *
	 * @return FilterFactory
	 */
	public static function instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new self();
		}
		return $inst;
	}

	public function getFilter($elem_type, $config) {
		if (isset($this->cache[$elem_type])) {
			return $this->getInstanceFromCache($elem_type, $config);
		}
		switch ($elem_type) {
			case self::FILTER_TRIM:
				$this->cache[$elem_type] = new Filters\Trim();
				break;
			case self::FILTER_LIMIT_LENGTH:
				$this->cache[$elem_type] = new Filters\LimitLength();
				break;
			default:
				print "<pre>";
				var_dump($elem_type);
				var_dump($config);
				print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
				die('@debug in ' . __FILE__ . ' @' . __LINE__ . "\n");
		}
		return $this->getInstanceFromCache($elem_type, $config);
	}

	public function getInstanceFromCache($elem_type, $config) {
		$instance = clone $this->cache[$elem_type];
		$instance->setConfig($config);
		return $instance;
	}

}
