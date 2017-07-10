<?php

namespace dg\DgCiForm\Elements;

use dg\DgCiForm\Request;
use dg\DgCiForm\FilterFactory;

abstract class AbstractFormElement extends AbstractElement {

	protected $type;
	protected $value;
	protected $request_value;
	protected $name;
	protected $label;
	protected $rules;
	protected $filters;
	protected $error_messages = [];

	public function setConfig(array $config_array) {
		parent::setConfig($config_array);
		foreach (['rules', 'filters'] as $key) {
			if (isset($config_array[$key]) && is_array($config_array[$key])) {
				$this->{$key} = $config_array[$key];
			}
		}
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	public function getValue() {
		$request = Request::instance();
		$this->request_value = $request->getData($this->name);

		if ($this->request_value !== null) {
			return $this->request_value;
		}
		return $this->value;
	}

	public function setValue($value) {
		$this->value = $value;
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function getLabel() {
		return $this->label;
	}

	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}

	abstract function isValid();

	public function getErrorMessages() {
		return $this->error_messages;
	}

	public function getData() {
		$value = $this->getValue();
		if (is_array($this->filters) && count($this->filters) > 0) {
			$factory = FilterFactory::instance();
			foreach ($this->filters as $filter_key => $filter_args) {
				$filter = $factory->getFilter($filter_key, $filter_args);
				$value = $filter->getFiltered($value);
			}
		}
		return $value;
	}

}
