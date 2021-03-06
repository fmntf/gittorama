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

class View
{

	/**
	 * @var StdClass
	 */
	private $properties;

	/**
	 * @var array
	 */
	private $requestParams;

	public function __get($property)
	{
		if (isset($this->properties->$property)) {
			return $this->properties->$property;
		} else {
			throw new Exception('Unknown property: ' . $property);
		}
	}

	public function __construct($data, $file, $autoRender = true, $requestParams = array())
	{
		$this->properties = $data;
		$this->requestParams = $requestParams;

		if ($autoRender) {
			include $file;
		}
	}

	/**
	 * Make a string URL friendly.
	 *
	 * @param string $string
	 * @return string
	 */
	public function toUrl($string)
	{
		return Utils::toUrl($string);
	}


	/**
	 * Adds (or replace) the actual request parameters with the given params.
	 *
	 * @param array $params
	 * @return string
	 */
	public function getUrl(array $params)
	{
		$requestParams = $this->requestParams;

		foreach ($params as $param => $value) {
			$requestParams[$param] = $value;
		}

		$url = '/';
		
		foreach ($requestParams as $param => $value) {
			$url .= "$param/$value/";
		}

		return $url;
	}
}