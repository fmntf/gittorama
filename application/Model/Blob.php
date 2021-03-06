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

class Model_Blob
{
	private $path;
	private $hash;

	public function __construct($path, $hash)
	{
		$this->path = $path;
		$this->hash = $hash;
	}

	public function getContent()
	{
		$command = "git --git-dir={$this->path} cat-file blob {$this->hash}";
		$result = shell_exec($command);

		return $result;
	}

	public function getLanguage($path)
	{
		$extension = pathinfo($this->path . $path, PATHINFO_EXTENSION);

		switch ($extension) {
			case 'php':
			case 'xml':
				return $extension;
			case 'js':
				return 'javascript';
		}

		return false;
	}
}