<?php

namespace dg\DgCiForm;

class RuleFactory {

	private $cache = [];

	const RULE_REQUIRED = 'required';
	const RULE_MIN_LENGTH = 'minLength';

	private function __construct() {
		/*
		 * Constructor marked private, so "new RuleFactory" won't work.
		 * RuleFactory needs to be a Singleton, or else the element caching
		 * won't work properly.
		 */
	}

	/**
	 * Call this method to get singleton
	 *
	 * @return RuleFactory
	 */
	public static function instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new self();
		}
		return $inst;
	}

	public function getRule($elem_type, $config) {
		if (isset($this->cache[$elem_type])) {
			return $this->getInstanceFromCache($elem_type, $config);
		}
		switch ($elem_type) {
			case self::RULE_REQUIRED:
				$this->cache[$elem_type] = new Rules\Required();
				break;
			case self::RULE_MIN_LENGTH:
				$this->cache[$elem_type] = new Rules\MinLength();
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
