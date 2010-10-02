<?php

class Configuration
{

	private $repositories;

	public function __construct()
	{
		$this->setUp();
	}

	public function addRepository($path)
	{
		$this->repositories[] = $path;
	}

	public function getRepositories()
	{
		return $this->repositories;
	}

	protected function setUp()
	{
	}

}
