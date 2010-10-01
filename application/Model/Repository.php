<?php

class Model_Repository
{

	protected $path;

	public function __construct($path)
	{
		$this->path = $path;
	}

	public function exists()
	{
		return is_dir($this->path . '/.git');
	}

	public function getDescription()
	{
		$description = file_get_contents($this->path . '/.git/description');

		return trim($description);
	}

	public function getPath()
	{
		return $this->path;
	}

}