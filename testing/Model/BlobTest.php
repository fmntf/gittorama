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

class Model_BlobTest extends PHPUnit_Framework_TestCase
{
	public function testGetsFileContent()
	{
		$path = unpackRepository('simple');
		$fileHash = '3b7613d607009961a6d37a96e6c1f73f09c44ef4';

		$file = new Model_Blob($path, $fileHash);

		$content = $file->getContent();

		$this->assertEquals("Hi, I'm allone..\n\n", $content);
	}

	public function testDetectsIfFilesAreFormattable()
	{
		$path = unpackRepository('simple');
		$file = new Model_Blob($path, 'any');

		$this->assertEquals('php', $file->getLanguage('file.php'));
		$this->assertFalse($file->getLanguage('file.txt'));
	}
}