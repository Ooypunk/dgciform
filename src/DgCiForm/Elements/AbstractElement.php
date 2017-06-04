<?php

namespace dg\DgCiForm\Elements;

class AbstractElement {

	protected $skin;
	protected $id;
	protected $class;
	protected $config_keys = [];

	/*
	 * Getters/setters
	 */

	public function setConfig(array $config_array) {
		foreach (['id', 'class'] as $key) {
			if (isset($config_array[$key])) {
				$this->{$key} = $config_array[$key];
			}
		}
		foreach ($this->config_keys as $key) {
			$this->{$key} = $config_array[$key];
		}
	}

	public function getSkin() {
		return $this->skin;
	}

	public function setSkin($skin) {
		$this->skin = (string) $skin;
		return $this;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getClass() {
		return $this->class;
	}

	public function setClass($class) {
		$this->class = $class;
		return $this;
	}

	/*
	 * Output
	 */

	public function output() {
		$skins_dir = $this->getSkinsDir();

		// Compose filenames to get output from: current class, then walking upward
		$files = [
			basename(get_class($this)) . '.php'
		];
		$parent = get_parent_class($this);
		while ($parent !== false) {
			$files[] = basename($parent) . '.php';
			$parent = get_parent_class($parent);
		}

		// Add skins dir to file names, weed out non-existing files
		$full_files = $this->addDirToFiles($files, $skins_dir);
		$filtered_files = $this->filterExistingFiles($full_files);
		if (count($filtered_files) === 0) {
			throw new \Exception('Skin not found for: ' . basename(get_class($this)));
		}

		// Use the first of the list (existing template files
		$file = array_shift($filtered_files);

		// Get output, done
		return $this->getOutputFromFile($file);
	}

	public function getSkinsDir() {
		$dir = dirname(__FILE__) . '/../Output/skins/' . $this->skin . '/';
		if (!file_exists($dir)) {
			throw new \Exception('Skins dir not found: ' . $dir);
		}
		return $dir;
	}

	public function addDirToFiles(array $files, $dir) {
		foreach ($files as $key => $file) {
			$full_file = rtrim($dir, '/') . '/' . $file;
			$files[$key] = $full_file;
		}
		return $files;
	}

	public function filterExistingFiles(array $files) {
		$filtered = [];
		foreach ($files as $file) {
			if (file_exists($file)) {
				$filtered[] = $file;
			}
		}
		return $filtered;
	}

	public function getOutputFromFile($file, $data = null) {
		if ($data !== null) {
			extract((array) $data);
		}
		ob_start();
		require($file);
		$output = ob_get_clean();
		return $output;
	}

}
