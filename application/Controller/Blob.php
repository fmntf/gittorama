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

class Controller_Blob extends Controller
{
	public function run()
	{
		$hash = $this->getParam('hash');
		$path = base64_decode($this->getParam('path'));

		$conf = $this->getUserConfiguration();
		$path = Utils::getRepositoryPath($conf, $this->getParam('repository'));
		
		$blob = new Model_Blob($path, $hash);

		$this->view->content = $blob->getContent();

		$this->render('blob');
	}
}
