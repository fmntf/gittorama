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

class Model_Log
{

	private $path;
	private $hash;
	private $info;

	public function __construct($path, $hash)
	{
		$this->path = $path;
		$this->hash = $hash;
	}

	public function getInfo()
	{
		if ($this->info === null) {
			$this->info = $this->fetchInfo();
		}

		return $this->info;
	}

	private function fetchInfo()
	{
		$command = "git --git-dir={$this->path} rev-list {$this->hash} --max-count=1 --header";
		$result = trim(shell_exec($command));

		$default = "[\*]?";
		$noun = "[\w\-\.]+";
		$hash = "[a-z0-9]+";
		$return = "\n";
		$space = "\s+";
		$phrase = ".*";
		$multiLinePharse = "[\w\W\s]*";
		$contact = "<($noun@.*)>";
		$time = "(\d+) \+(\d+)";

		$pattern  = "/($hash)$return";
		$pattern .= "tree ". "($hash)$return";
		$pattern .= "(parent ". "($hash)$return)?";
		$pattern .= "(parent ". "($hash)$return)?";
		$pattern .= "author " . "($phrase)$space($contact)$space($time)$return";
		$pattern .= "committer " . "($phrase)$space($contact)$space($time)$return";
		$pattern .= "($multiLinePharse)/";

		preg_match($pattern, $result, $matches);

		$info = array(
			'hash' => $matches[1],
			'tree' => $matches[2],
			'author' => array(
				'name' => $matches[7],
				'email' => $matches[9],
				'timestamp' => $matches[11],
				'offset' => $matches[12]
			),
			'committer' => array(
				'name' => $matches[13],
				'email' => $matches[15],
				'timestamp' => $matches[17],
				'offset' => $matches[18]
			),
			'message' => trim($matches[19])
		);
		
		$parent = ($matches[4] == '') ? null : $matches[4];
		if ($matches[6] == '') {
			$info['parent'] = $parent;
		} else {
			$info['parents'] = array($parent, $matches[6]);
		}

		return $info;
	}

}