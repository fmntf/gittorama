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

class Model_LogTest extends PHPUnit_Framework_TestCase
{

	public function testCanGetLogInfo()
	{
		$path = unpackRepository('simple');
		$log = new Model_Log($path . '/.git', 'db57541ba4f7686c2063d7d1290eba612b30bf59');

		$info = $log->getInfo();

		$this->assertEquals('db57541ba4f7686c2063d7d1290eba612b30bf59', $info['hash']);
		$this->assertEquals('ac18b0b728d770f6864046e7d3b8c7f1ca09cf1f', $info['tree']);
		$this->assertEquals('Simple commit message', $info['message']);
		$this->assertEquals('Francesco Montefoschi', $info['author']['name']);
		$this->assertEquals('francesco.monte@gmail.com', $info['author']['email']);
		$this->assertEquals(1285956453, $info['author']['timestamp']);
		$this->assertEquals($info['author'], $info['committer']);
	}

}
