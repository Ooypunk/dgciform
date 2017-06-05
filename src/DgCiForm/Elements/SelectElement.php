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
		return (string) $option_value === (string) $this->getValue();
	}

	public function isValid() {
		if (!in_array($this->getValue(), $this->options)) {
			return false;
		}

		$is_valid = true;
		if (is_array($this->rules)) {
			foreach ($this->rules as $rule_key => $rule_arguments) {
				print "<pre>";
				var_dump($rule_key, $rule_arguments);
				die('@debug in ' . __FILE__ . ' @' . __LINE__ . "\n");
			}
		}
		return $is_valid;
	}

}
