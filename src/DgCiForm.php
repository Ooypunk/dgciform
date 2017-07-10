<?php

namespace dg;

use dg\DgCiFormConfig;
use dg\DgCiForm\Output\OutputGenerator;
use dg\DgCiForm\ElementFactory;
use dg\DgCiForm\ElementsContainer;
use dg\DgCiForm\Elements\AbstractFormElement;

class DgCiForm {

	public $config;
	public $config_form_key;
	public $error_messages = [];

	public function __construct($config_key = null) {
		$this->config_form_key = $config_key;
		$this->loadConfig();
	}

	public function loadConfig() {
		$CI = & get_instance();
		$CI->load->config('dgciform');

		$config_array = $CI->config->item('dgciform');
		$config = new DgCiFormConfig($config_array);
		$this->config = $config;
	}

	public function output() {
		// Start generator
		$generator = new OutputGenerator();
		$generator->setSkin($this->config->getSkin());

		// Get Elements container
		$elements_container = $this->getFilledElementsContainer();

		// Put elements into generator, get output
		$generator->setElements($elements_container);
		return $generator->output();
	}

	public function getFilledElementsContainer() {
		// Get Elements container
		$form_config = $this->config->getFormConfig($this->config_form_key);
		$elements_container = ElementsContainer::fromConfigArray($form_config['elements']);

		// Add Form elements to front and back
		$elements_container->prependElement($this->getCsrfElement());
		$elements_container->prependElement($this->getFormOpenElement());
		$elements_container->appendElement($this->getFormCloseElement());
		return $elements_container;
	}

	public function getFormOpenElement() {
		$form_config = $this->config->getFormConfig($this->config_form_key);

		$factory = ElementFactory::instance();
		return $factory->getElem(ElementFactory::ELEM_FORM_OPEN, $form_config['form']);
	}

	public function getCsrfElement() {
		$form_config = $this->config->getFormConfig($this->config_form_key);

		$factory = ElementFactory::instance();
		$element = $factory->getElem(ElementFactory::ELEM_FORM_CSRF, []);
		$element->setName($form_config['form']['name']);
		return $element;
	}

	public function getFormCloseElement() {
		$factory = ElementFactory::instance();
		return $factory->getElem(ElementFactory::ELEM_FORM_CLOSE, []);
	}

	public function getRequestData() {
		$form_config = $this->config->getFormConfig($this->config_form_key);
		$form_method = $form_config['form']['method'];

		$CI = & get_instance();
		return (array) $CI->input->{$form_method}();
	}

	public function isSubmitted() {
		$request_data = $this->getRequestData();

		$form_config = $this->config->getFormConfig($this->config_form_key);

		$submit_element = $this->getSubmitElement($form_config);
		$submit_name = $submit_element['name'];

		return isset($request_data[$submit_name]);
	}

	private function getSubmitElement(array $form_config) {
		foreach ($form_config['elements'] as $config_entry) {
			if ($config_entry['type'] === ElementFactory::ELEM_TYPE_SUBMIT) {
				return $config_entry;
			}
		}
	}

	public function isValid() {
		$is_valid = true;
		$this->error_messages = [];
		$elements_container = $this->getFilledElementsContainer();
		foreach ($elements_container as $elem) {
			if (!($elem instanceof AbstractFormElement)) {
				continue;
			}
			if (!$elem->isValid()) {
				$is_valid = false;
				$this->addErrorMessages($elem->getErrorMessages());
			}
		}
		return $is_valid;
	}

	public function addErrorMessages(array $error_messages) {
		foreach ($error_messages as $message) {
			$this->error_messages[] = $message;
		}
	}

	public function getErrorMessages() {
		return $this->error_messages;
	}

	public function getData() {
		$data = [];
		$elements_container = $this->getFilledElementsContainer();
		foreach ($elements_container as $elem) {
			if (!($elem instanceof AbstractFormElement)) {
				continue;
			}
			$data[$elem->getName()] = $elem->getData();
		}
		return $data;
	}

}
