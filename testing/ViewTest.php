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

class ViewTest extends PHPUnit_Framework_TestCase
{
	public function testRenderViewScript()
	{
		$properties = new StdClass;
		$properties->prop = 'erty';

		ob_start();
		$view = new View($properties, 'fixtures/view.phtml');
		$rendering = ob_get_clean();

		$this->assertEquals('<b>erty</b>', $rendering);
	}

	public function testCannotAccessToUnexistingProperties()
	{
		$properties = new StdClass;

		try {
			ob_start();
			$view = new View($properties, 'fixtures/view.phtml');
			$this->fail();
		} catch (Exception $e) {
			ob_clean();
		}
	}

	public function testUrlFriendlyUrlsAreAlwaysLowercase()
	{
		$view = $this->getView();
		$translated = $view->toUrl('Test');

		$this->assertEquals('test', $translated);
	}

	public function testReplacesSpacesWithHypensString()
	{
		$view = $this->getView();
		$translated = $view->toUrl('my repo');

		$this->assertEquals('my-repo', $translated);
	}

	public function testReplacesAccentedLettersInString()
	{
		$view = $this->getView();
		$translated = $view->toUrl('àèéìòù');

		$this->assertEquals('aeeiou', $translated);
	}

	public function testRemovesSibmolsInString()
	{
		$view = $this->getView();
		$translated = $view->toUrl("repo(sitory)!i,s.n'i:c;e?");

		$this->assertEquals('repositoryisnice', $translated);
	}

	public function testCanCreateUrlFromEmptyRequest()
	{
		$view = $this->getView();

		$url = $view->getUrl(array(
			'a' => 'b',
			'c' => 'd'
		));

		$this->assertEquals('/a/b/c/d/', $url);
	}

	public function testCanCreateUrlFromExistingRequest()
	{
		$view = $this->getView(array(
			'name' => 'pippo'
		));

		$url = $view->getUrl(array(
			'age' => 'dummy',
			'name' => 'pippa'
		));

		$this->assertEquals('/name/pippa/age/dummy/', $url);
	}

	private function getView($params = array())
	{
		return new View(new StdClass, '/dev/null', false, $params);
	}
}