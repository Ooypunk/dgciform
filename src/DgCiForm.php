<?php

namespace dg;

use dg\DgCiFormConfig;
use dg\DgCiForm\Output\OutputGenerator;
use dg\DgCiForm\ElementFactory;
use dg\DgCiForm\ElementsContainer;

class DgCiForm {

	public $config;
	public $config_form_key;
	public $factory;

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
		$form_config = $this->config->getFormConfig($this->config_form_key);
		$elements_container = ElementsContainer::fromConfigArray($form_config['elements']);

		// Add Form elements to front and back
		$elements_container->prependElement($this->getFormOpenElement());
		$elements_container->appendElement($this->getFormCloseElement());

		// Put elements into generator, get output
		$generator->setElements($elements_container);
		return $generator->output();
	}

	public function getFormOpenElement() {
		$form_config = $this->config->getFormConfig($this->config_form_key);

		$factory = ElementFactory::instance();
		return $factory->getElem(ElementFactory::ELEM_FORM_OPEN, $form_config['form']);
	}

	public function getFormCloseElement() {
		$factory = ElementFactory::instance();
		return $factory->getElem(ElementFactory::ELEM_FORM_CLOSE, []);
	}

}
