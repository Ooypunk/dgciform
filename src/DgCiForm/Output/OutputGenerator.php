<?php

namespace dg\DgCiForm\Output;

use dg\DgCiForm\ElementsContainer;

class OutputGenerator {

	private $skin;
	private $elements;

	public function getSkin() {
		return $this->skin;
	}

	public function setSkin($skin) {
		$this->skin = $skin;
		return $this;
	}

	public function getElements() {
		return $this->elements;
	}

	public function setElements(ElementsContainer $elements) {
		$this->elements = $elements;
		return $this;
	}

	public function output() {
		$output = '';
		foreach ($this->elements as $element) {
			$element->setSkin($this->getSkin());
			$output .= $element->output();
		}
		return $output;
	}

}
