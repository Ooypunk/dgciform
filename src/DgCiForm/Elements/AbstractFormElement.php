<?php

namespace dg\DgCiForm\Elements;

use dg\DgCiForm\Request;

abstract class AbstractFormElement extends AbstractElement {

	protected $type;
	protected $value;
	protected $request_value;
	protected $name;
	protected $label;
	protected $rules;

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
}
