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
		$path = unpackRepository('pro');
		$tree = new Model_Tree($path, 'HEAD');

		$html = $this->crumber->getHtml($tree, '/dir/nowwithsomecontent');

		$url = '/tree/repository/MyRepo/from/sha1/';
		$my = $url . 'hash/2524b7c38eaf0f31706ceb6e7f892f96c1c49701/path/' . base64_encode('/dir') . '/';

		$expected = "<ul><li><a href=\"$url\">MyRepo</a></li>" .
					"<li><a href=\"$my\">dir</a></li><li>nowwithsomecontent</li></ul>";
		$this->assertEquals($expected, $html);
	}
}