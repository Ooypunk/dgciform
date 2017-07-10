<?php

namespace dg\DgCiForm\Rules;

use dg\DgCiForm\Elements\AbstractFormElement;

abstract class AbstractRule {

	protected $config;
	protected $error_message = 'Regel ":rulename:" gefaald voor veld ":label:"';

	public function setConfig($config) {
		$this->config = $config;
	}

	public function getErrorMessage(AbstractFormElement $element) {
		$translation = _($this->error_message);
		$search = [
			':field:',
			':label:',
			':rulename:',
			':config:',
		];
		$replace = [
			$element->getName(),
			$element->getLabel(),
			basename(get_called_class()),
			$this->config,
		];
		$replaced = str_replace($search, $replace, $translation);
		return $replaced;
	}

	abstract public function isValid($value);
}
