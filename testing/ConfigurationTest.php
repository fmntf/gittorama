<?php

/**
 * gittorama - a stupid web interface for a stupid content tracker
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

class ConfigurationTest extends PHPUnit_Framework_TestCase
{

	public function testKeepsConfiguredPath()
	{
		$config = new SimpleConfig();
		$list = $config->getRepositories();

		$this->assertEquals(1, count($list));
		$this->assertArrayHasKey('Empty', $list);
	}

	public function testKeepsMoreThanOneRepository()
	{
		$config = new MultipleRepoConfig();
		$list = $config->getRepositories();

		$this->assertEquals(2, count($list));
		$this->assertArrayHasKey('Empty', $list);
		$this->assertArrayHasKey('Simple', $list);
	}

}

// fixtures

class SimpleConfig extends Configuration
{
	protected function setUp()
	{
		$path = unpackRepository('empty');
		$this->addRepository('Empty', $path);
	}
}

class MultipleRepoConfig extends Configuration
{
	protected function setUp()
	{
		$path = unpackRepository('empty');
		$this->addRepository('Empty', $path);

		$path = unpackRepository('simple');
		$this->addRepository('Simple', $path);
	}
}
