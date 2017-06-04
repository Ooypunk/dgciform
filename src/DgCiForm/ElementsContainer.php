<?php

namespace dg\DgCiForm;

use dg\DgCiForm\ElementFactory;
use dg\DgCiForm\Elements\AbstractElement;

class ElementsContainer implements \Iterator {

	private $position = 0;
	private $elements = [];

	public function __construct() {
		$this->position = 0;
	}

	public static function fromConfigArray(array $config_array) {
		$factory = ElementFactory::instance();
		$self = new self();

		foreach ($config_array as $config_entry) {
			$new_elem = $factory->getElem($config_entry['type'], $config_entry);
			$self->appendElement($new_elem);
		}
		return $self;
	}

	public function current() {
		return $this->elements[$this->position];
	}

	public function key() {
		return $this->position;
	}

	public function next() {
		++$this->position;
	}

	public function rewind() {
		$this->position = 0;
	}

	public function valid() {
		return isset($this->elements[$this->position]);
	}

	public function appendElement(AbstractElement $element) {
		$this->elements[] = $element;
	}

	public function prependElement(AbstractElement $element) {
		$elements = $this->elements;
		array_unshift($elements, $element);
		$this->elements = $elements;
	}

}
