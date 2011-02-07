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

class Application
{

	private $userConfiguration;

	public function bootstrap()
	{
		$this->loadConfiguration();

		$request = $this->getRequest();

		if ($this->actionExists($request['action'])) {
			$this->dispatch($request);
		} else {
			var_dump($request);
			throw new Exception('Invalid request.');
		}
	}

	/**
	 * Detects the request type.
	 *
	 * @return array Action to dispatch and params.
	 */
	public function getRequest()
	{
		$parts = $this->getRequestParts();
		$params = array();

		if (count($parts) == 0) {
			$parts[1] = 'index';
		}

		$action = $parts[1];

		for ($i = 2; $i < count($parts); $i=$i+2) {

			$param = $parts[$i];
			$value = $parts[$i+1];

			$params[$param] = $value;

		}

		return array(
			'action' => $action,
			'params' => $params
		);
	}

	/**
	 * Splits the request URL into pieces.
	 *
	 * @return array
	 */
	private function getRequestParts()
	{
		$request = $_SERVER['REQUEST_URI'];
		$last = strlen($request) - 1;

		if ($request[$last] == '/') {
			$request = substr($request, 0, -1);
		}

		$parts = explode('/', $request);
		unset($parts[0]);

		if (strpos(end($parts), '?')) {
			$qs = explode('?', end($parts));
			$parts[count($parts)] = $qs[0];

			//process $qs[1];
		}

		return $parts;
	}

	/**
	 * Tests if the specified action exists.
	 *
	 * @param string $action
	 * @return bool
	 */
	private function actionExists($action)
	{
		$actionFile = APPLICATION_PATH . '/Controller/' . ucfirst($action) . '.php';

		return is_file($actionFile);
	}

	/**
	 * Dispatch the request.
	 *
	 * @param array $request
	 */
	private function dispatch($request)
	{
		$class = 'Controller_' . ucfirst($request['action']);

		$controller = new $class($this->userConfiguration, $request['params']);
		$controller->run();
	}

	/**
	 * Load user configuration from config.php
	 */
	private function loadConfiguration()
	{
		$config = APPLICATION_PATH . '/../config.php';

		if (is_file($config)) {
			require_once $config;
			$this->userConfiguration = new UserConfig();
		} else {
			throw new Exception('Missing configuration file. Copy config.php.dist to config.php and set your repositories.');
		}
	}

}
