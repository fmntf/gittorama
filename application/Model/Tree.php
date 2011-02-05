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

class Model_Tree
{

	private $path;
	private $hash;
	private $files;

	public function __construct($path, $hash)
	{
		$this->path = $path;
		$this->hash = $hash;
	}

	public function getFiles()
	{
		if ($this->files === null) {
			$this->files = $this->fetchFiles();
		}

		return $this->files;
	}

	public function getBisectedFiles()
	{
		$tree = $this->fetchFiles();

		$predicate = function($item) {
			return $item['type'] == 'tree';
		};
		$trees = array_values(array_filter($tree, $predicate));

		$predicate = function($item) {
			return $item['type'] == 'blob';
		};
		$blobs = array_values(array_filter($tree, $predicate));

		return array(
			'trees' => $trees,
			'blobs' => $blobs
		);
	}

	private function fetchFiles()
	{
		$command = "git --git-dir={$this->path} ls-tree {$this->hash}";
		$result = trim(shell_exec($command));

		$mode = "\d+";
		$space = "\s+";
		$type = "\w+";
		$hash = "[a-z0-9]+";
		$noun = "[\w\w\.]+";

		$pattern  = "/($mode)$space($type)$space($hash)$space($noun)/";

		$files = array();

		foreach (explode("\n", trim($result)) as $file) {
			preg_match($pattern, $file, $matches);

			$files[] = array(
				'mode' => $matches[1],
				'type' => $matches[2],
				'hash' => $matches[3],
				'name' => $matches[4]
			);
		}

		return $files;
	}

}