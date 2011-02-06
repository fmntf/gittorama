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
		$from = $this->getParam('from');
		$hash = $this->getParam('hash');
		$this->view->path = base64_decode($this->getParam('path'));
		$repository = $this->getParam('repository');
		$this->view->crumber = new Service_PathCrumber($repository, $from);

		$conf = $this->getUserConfiguration();
		$path = Utils::getRepositoryPath($conf, $repository);
		
		$blob = new Model_Blob($path, $hash);

		$language = $blob->getLanguage($this->view->path);
		if ($language) {
			$geshiPath = realpath(__DIR__ . '/../../library/Geshi') . '/';
			require_once $geshiPath . 'geshi.php';
			$geshi = new GeSHi($blob->getContent(), $language, $geshiPath);
			$this->view->content = $geshi->parse_code();
		} else {
			$this->view->content = nl2br($blob->getContent());
		}

		$this->view->tree = new Model_Tree($path, $from);
		$this->render('blob');
	}
}
