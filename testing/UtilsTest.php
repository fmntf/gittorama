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

class UtilsTest extends PHPUnit_Framework_TestCase
{
	public function testUrlFriendlyUrlsAreAlwaysLowercase()
	{
		$utils = new Utils();
		$translated = $utils->toUrl('Test');

		$this->assertEquals('test', $translated);
	}

	public function testReplacesSpacesWithHypensString()
	{
		$utils = new Utils();
		$translated = $utils->toUrl('my repo');

		$this->assertEquals('my-repo', $translated);
	}

	public function testReplacesAccentedLettersInString()
	{
		$utils = new Utils();
		$translated = $utils->toUrl('àèéìòù');

		$this->assertEquals('aeeiou', $translated);
	}

	public function testRemovesSibmolsInString()
	{
		$utils = new Utils();
		$translated = $utils->toUrl("repo(sitory)!i,s.n'i:c;e?");

		$this->assertEquals('repositoryisnice', $translated);
	}
}