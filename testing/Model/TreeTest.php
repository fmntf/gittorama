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

class Model_TreeTest extends PHPUnit_Framework_TestCase
{

	public function testListsFilesOfSimpleRepository()
	{
		$path = unpackRepository('simple');
		$hash = 'ac18b0b728d770f6864046e7d3b8c7f1ca09cf1f';

		$tree = new Model_Tree($path, $hash);
		$files = $tree->getFiles();

		$this->assertEquals(1, count($files));
		$this->assertEquals('alone.txt', $files[0]['name']);
		$this->assertEquals('3b7613d607009961a6d37a96e6c1f73f09c44ef4', $files[0]['hash']);
		$this->assertEquals('blob', $files[0]['type']);
	}

	public function testListsFilesOfProRepository()
	{
		$path = unpackRepository('pro');
		$hash = '30408371f601849dfc77abe96f41b88be2592c62';

		$tree = new Model_Tree($path, $hash);
		$files = $tree->getFiles();

		$this->assertEquals(3, count($files));

		$known = array('dir', 'file.php', 'file.txt');
		foreach ($files as $file) {
			if (!in_array($file['name'], $known)) {
				$this->fail('unexpected file: ' . $file['name']);
			}
		}
	}

	public function testListsRepositoryBisectingBlobsAndTrees()
	{
		$path = unpackRepository('pro');
		$tree = new Model_Tree($path, 'HEAD');

		$files = $tree->getBisectedFiles();

		$this->assertArrayHasKey('blobs', $files);
		$this->assertArrayHasKey('trees', $files);

		$this->assertEquals('file.php', $files['blobs'][0]['name']);
		$this->assertEquals('file.txt', $files['blobs'][1]['name']);
		$this->assertEquals('dir', $files['trees'][0]['name']);
	}
}