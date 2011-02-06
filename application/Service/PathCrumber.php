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

class Service_PathCrumber
{
	private $repositoryName;
	private $baseHash;

	public function __construct($repositoryName, $baseHash)
	{
		$this->repositoryName = $repositoryName;
		$this->baseHash = $baseHash;
	}

	public function getParts($path)
	{
		if ($path == '/') {
			return array($this->repositoryName);
		}

		$parts = explode('/', $path);
		$parts[0] = $this->repositoryName;
		return $parts;
	}

	public function getHtml(Model_Tree $tree, $path)
	{
		$printables = $this->getParts($path);
		$paths = explode('/', $path);
		$path = '';

		$last = array_pop($printables);
		$html = array('<ul>');
		foreach ($printables as $i=>$printable) {
			if ($i == 0) {
				$pathUrl = '';
			} else {
				$path .= '/' . $paths[$i];
				$hash = $tree->getHash($path);
				$pathUrl = "hash/$hash/path/" . base64_encode($path) . '/';
			}
			$url = "/tree/repository/{$this->repositoryName}/from/{$this->baseHash}/$pathUrl";
			$html[] = "<li><a href=\"$url\">$printable</a></li>";
		}

		$html[] = "<li>$last</li>";
		$html[] = '</ul>';

		return implode('', $html);
	}
}