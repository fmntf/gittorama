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

class Application
{
	public function bootstrap()
	{
		$this->loadConfiguration();

		$request = $this->getRequest();

		if ($this->actionExists($request['action'])) {
			$this->dispatch($request);
		} else {
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

		switch (count($parts)) {

			case 0:
				$action = 'index';
				break;

			case 1:
				$action = 'repository';
				$params['name'] = $parts[1];
				break;

//			default:
//				var_dump(count($parts));
//				var_dump($parts);

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

		return $parts;
	}

	private function actionExists($action)
	{
		$actionFile = APPLICATION_PATH . '/Controller/' . ucfirst($action) . '.php';

		return is_file($actionFile);
	}

	private function dispatch($request)
	{
		$class = 'Controller_' . ucfirst($request['action']);

		$controller = new $class($request['params']);
		$controller->run();
	}

	private function loadConfiguration()
	{
		$config = APPLICATION_PATH . '/../config.php';

		if (is_file($config)) {
			require $config;
		} else {
			throw new Exception('Missing configuration file. Copy config.php.dist to config.php and set your repositories.');
		}
	}

}
