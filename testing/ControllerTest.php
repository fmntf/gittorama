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

class ControllerTest extends PHPUnit_Framework_TestCase
{

	private function getController()
	{
		$conf = new Configuration();
		return new Controller($conf, array());
	}

	public function testUrlFriendlyUrlsAreAlwaysLowercase()
	{
		$controller = $this->getController();
		$translated = $controller->toUrl('Test');

		$this->assertEquals('test', $translated);
	}

	public function testReplacesSpacesWithHypensString()
	{
		$controller = $this->getController();
		$translated = $controller->toUrl('my repo');

		$this->assertEquals('my-repo', $translated);
	}

	public function testReplacesAccentedLettersInString()
	{
		$controller = $this->getController();
		$translated = $controller->toUrl('àèéìòù');

		$this->assertEquals('aeeiou', $translated);
	}

	public function testRemovesSibmolsInString()
	{
		$controller = $this->getController();
		$translated = $controller->toUrl("repo(sitory)!i,s.n'i:c;e?");

		$this->assertEquals('repositoryisnice', $translated);
	}

}