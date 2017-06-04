<?php

namespace dg\DgCiForm\Elements;

class SelectElement extends AbstractFormElement {

	protected $options = [];
	protected $config_keys = ['type', 'name', 'label', 'options'];

	public function getOptions() {
		return $this->options;
	}

	/**
	 * @todo: fill this function
	 * @param string|int $option_value Value to check
	 * @return boolean Check if given value was selected (when form was submitted)
	 */
	public function isSelected($option_value) {
		return false;
	}

}
