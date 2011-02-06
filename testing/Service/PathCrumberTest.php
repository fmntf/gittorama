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

class Service_PathCrumberTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->crumber = new Service_PathCrumber('MyRepo', 'sha1');
	}

	public function testRendersRootNode()
	{
		$parts = $this->crumber->getParts('/');

		$this->assertEquals(1, count($parts));
		$this->assertEquals('MyRepo', $parts[0]);
	}
	
	public function testRendersSubdirectories()
	{
		$parts = $this->crumber->getParts('/my/Dir');

		$this->assertEquals(3, count($parts));
		$this->assertEquals('MyRepo', $parts[0]);
		$this->assertEquals('my', $parts[1]);
		$this->assertEquals('Dir', $parts[2]);
	}

	public function testRendersPathToHtml()
	{
		$html = $this->crumber->getHtml('/my/file.txt');

		$url = '/tree/repository/MyRepo/hash/sha1/';
		$my = $url . 'path/' . base64_encode('/my') . '/';

		$expected = "<ul><li><a href=\"$url\">MyRepo</a></li>" .
					"<li><a href=\"$my\">my</a></li><li>file.txt</li></ul>";
		$this->assertEquals($expected, $html);
	}
}