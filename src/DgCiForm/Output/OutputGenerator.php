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

	/**
	 * Gather output of all assigned elements and return as one string.
	 * @return string Return output of all assigned elements
	 */
	public function output() {
		// Init output string
		$output = '';

		// Get output of all elements and append to output string
		foreach ($this->elements as $element) {
			$element->setSkin($this->getSkin());
			$output .= $element->output();
		}

		// Remove empty attributes
		$filtered = $this->filterEmptyAttributes($output);

		// Done
		return $filtered;
	}

	public function filterEmptyAttributes($input) {
		$pattern = '/\s[a-zA-Z-]+=""/';
		$output = preg_replace($pattern, '', $input);
		return $output;
	}

}
