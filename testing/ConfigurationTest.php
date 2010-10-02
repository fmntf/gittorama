<?php

class ConfigurationTest extends PHPUnit_Framework_TestCase
{

	public function testKeepsConfiguredPath()
	{
		$config = new SimpleConfig();
		$this->assertEquals(1, count($config->getRepositories()));
	}

	public function testKeepsMoreThanOneRepository()
	{
		$config = new MultipleRepoConfig();
		$this->assertEquals(2, count($config->getRepositories()));
	}

}

// fixtures

class SimpleConfig extends Configuration
{
	protected function setUp()
	{
		$path = unpackRepository('empty');
		$this->addRepository($path);
	}
}

class MultipleRepoConfig extends Configuration
{
	protected function setUp()
	{
		$path = unpackRepository('empty');
		$this->addRepository($path);

		$path = unpackRepository('simple');
		$this->addRepository($path);
	}
}
