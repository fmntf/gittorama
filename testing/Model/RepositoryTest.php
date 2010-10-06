<?php

/**
 * gittorama - a websvn for git
 * Copyright (C) 2010  Francesco Montefoschi <francesco.monte@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @license http://www.gnu.org/licenses/agpl-3.0.html  GNU AGPL 3.0
 */

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

	public function testGetsAListOfBranches()
	{
		$path = unpackRepository('simple');
		$repo = new Model_Repository($path);

		$expected = array(
			array(
				'name' => 'master',
				'hash' => 'db57541',
				'message' => 'Simple commit message'
			)
		);

		$this->assertEquals($expected, $repo->getBranches());
	}

	public function testGetsAListOfBranchesInComplicatedRepo()
	{
		$path = unpackRepository('pro');
		$repo = new Model_Repository($path);

		$expected = array(
			array(
				'name' => 'master',
				'hash' => '2c32835',
				'message' => '3rd commit'
			),
			array(
				'name' => 'mybranch',
				'hash' => '3040837',
				'message' => 'first commit of branch'
			),
		);

		$this->assertEquals($expected, $repo->getBranches());
	}

	public function testDetectsIfABranchExists()
	{
		$path = unpackRepository('simple');
		$repo = new Model_Repository($path);

		$this->assertTrue($repo->hasBranch('master'));
		$this->assertFalse($repo->hasBranch('mastah'));
	}

	public function testGetsLogsOfABranch()
	{
		$path = unpackRepository('simple');
		$repo = new Model_Repository($path);

		$logs = $repo->getLogs('master');
		$this->assertEquals(1, count($logs));
		$this->isInstanceOf('Model_Log', $logs[0]);
	}

	public function testGetsLogsOfABranchInProRepository()
	{
		$path = unpackRepository('pro');
		$repo = new Model_Repository($path);

		$logs = $repo->getLogs('master');

		$this->assertEquals(3, count($logs));
		$this->isInstanceOf('Model_Log', $logs[0]);

		$commitInfo = $logs[1]->getInfo();
		$this->assertEquals('second commit', $commitInfo['message']);
	}

}