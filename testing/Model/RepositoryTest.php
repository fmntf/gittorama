<?php

class Model_RepositoryTest extends PHPUnit_Framework_TestCase
{

	public function testCanAccessGitMetadata()
	{
		$path = unpackRepository('empty');
		$repo = new Model_Repository($path);

		$this->assertTrue($repo->exists());
	}

	public function testReadRepositoryDescription()
	{
		$path = unpackRepository('empty');
		$repo = new Model_Repository($path);

		$defaultDescription = "Unnamed repository; edit this file 'description' to name the repository.";
		$this->assertEquals($defaultDescription, $repo->getDescription());
	}

	public function testDetectsIfRepositoryHasDefaultDescription()
	{
		$path = unpackRepository('empty');
		$repo = new Model_Repository($path);

		$this->assertTrue($repo->hasDefaultDescription());
	}

}