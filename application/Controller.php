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

class Controller
{

	/**
	 * @var StdClass
	 */
	protected $view;

	/**
	 * @var array
	 */
	private $params;

	/**
	 * @var Configuration
	 */
	private $userConfig;

	public function  __construct(Configuration $config, array $params)
	{
		$this->view = new StdClass;
		$this->userConfig = $config;
		$this->params = $params;
	}

	/**
	 * Render a view script.
	 *
	 * @param string $name
	 */
	public function render($name)
	{
		$viewScript = APPLICATION_PATH . '/View/' . $name . '.phtml';
		new View($this->view, $viewScript, true, $this->getParams());
	}

	/**
	 * Get request params.
	 *
	 * @return array
	 */
	protected function getParams()
	{
		return $this->params;
	}

	/**
	 * Gets the value of the specified request parameter.
	 * If that parameter is not in the request, provides the specified default value.
	 *
	 * @param string $param
	 * @param mixed $defaultValue
	 * @return mixed
	 */
	protected function getParam($param, $defaultValue = null)
	{
		if (!isset($this->params[$param])) {
			return $defaultValue;
		}

		return $this->params[$param];
	}

	/**
	 * Get user configuration
	 *
	 * @return Configuration
	 */
	protected function getUserConfiguration()
	{
		return $this->userConfig;
	}

}