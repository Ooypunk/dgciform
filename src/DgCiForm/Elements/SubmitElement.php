<?php

namespace dg\DgCiForm\Elements;

class SubmitElement extends AbstractFormElement {

	protected $config_keys = ['type', 'name', 'label'];

	public function isValid() {
		return true;
	}

}
