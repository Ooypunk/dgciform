<?php

namespace dg\DgCiForm\Elements;

use dg\DgCiForm\RuleFactory;

class TextElement extends AbstractFormElement {

	protected $config_keys = ['type', 'name', 'label'];

	public function isValid() {
		$is_valid = true;
		if (is_array($this->rules)) {
			$factory = RuleFactory::instance();
			foreach ($this->rules as $rule_key => $rule_arguments) {
				$rule = $factory->getRule($rule_key, $rule_arguments);
				if (!$rule->isValid($this->getValue())) {
					$is_valid = false;
					$this->error_messages[] = $rule->getErrorMessage($this);
				}
			}
		}
		return $is_valid;
	}

}
