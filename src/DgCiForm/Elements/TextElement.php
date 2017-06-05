<?php

namespace dg\DgCiForm\Elements;

class TextElement extends AbstractFormElement {

	protected $config_keys = ['type', 'name', 'label'];

	public function isValid() {
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
