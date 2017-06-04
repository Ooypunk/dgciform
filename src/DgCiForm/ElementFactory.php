<?php

namespace dg\DgCiForm;

use dg\DgCiForm\Elements\FormOpenElement;
use dg\DgCiForm\Elements\FormCloseElement;
use dg\DgCiForm\Elements\TextElement;
use dg\DgCiForm\Elements\PasswordElement;
use dg\DgCiForm\Elements\SelectElement;
use dg\DgCiForm\Elements\SubmitElement;

class ElementFactory {

	private $cache = [];

	const ELEM_FORM_OPEN = 'form_open';
	const ELEM_FORM_CLOSE = 'form_close';
	const ELEM_TYPE_TEXT = 'text';
	const ELEM_TYPE_PASSWORD = 'password';
	const ELEM_TYPE_SELECT = 'select';
	const ELEM_TYPE_SUBMIT = 'submit';

	private function __construct() {
		/*
		 * Constructor marked private, so "new ElementFactory" won't work.
		 * ElementFactory needs to be a Singleton, or else the element caching
		 * won't work properly.
		 */
	}

	/**
	 * Call this method to get singleton
	 *
	 * @return ElementFactory
	 */
	public static function instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new self();
		}
		return $inst;
	}

	public function getElem($elem_type, $config) {
		if (isset($this->cache[$elem_type])) {
			return $this->getInstanceFromCache($elem_type, $config);
		}
		switch ($elem_type) {
			case self::ELEM_FORM_OPEN:
				$this->cache[$elem_type] = new FormOpenElement();
				break;
			case self::ELEM_FORM_CLOSE:
				$this->cache[$elem_type] = new FormCloseElement();
				break;
			case self::ELEM_TYPE_TEXT:
				$this->cache[$elem_type] = new TextElement;
				break;
			case self::ELEM_TYPE_PASSWORD:
				$this->cache[$elem_type] = new PasswordElement;
				break;
			case self::ELEM_TYPE_SELECT:
				$this->cache[$elem_type] = new SelectElement;
				break;
			case self::ELEM_TYPE_SUBMIT:
				$this->cache[$elem_type] = new SubmitElement;
				break;
			default:
				print "<pre>";
				var_dump($elem_type);
				var_dump($config);
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
