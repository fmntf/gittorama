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
		$result = trim(shell_exec("git --git-dir={$this->path} rev-list {$this->hash} --max-count=1 --header"));

		$default = "[\*]?";
		$noun = "[\w\-\.]+";
		$hash = "[a-z0-9]+";
		$return = "\n";
		$space = "\s+";
		$phrase = ".*";
		$multiLinePharse = "[\w\W\s]*";
		$contact = "<($noun@$noun\.$noun)>";
		$time = "(\d+) \+(\d+)";

		$pattern  = "/($hash)$return";
		$pattern .= "tree ". "($hash)$return";
		$pattern .= "author " . "($phrase)$space($contact)$space($time)$return";
		$pattern .= "committer " . "($phrase)$space($contact)$space($time)$return";
		$pattern .= "($multiLinePharse)/";

		preg_match($pattern, $result, $matches);

		return array(
			'tree' => $matches[2],
			'author' => array(
				'name' => $matches[3],
				'email' => $matches[5],
				'timestamp' => $matches[7],
				'offset' => $matches[8]
			),
			'committer' => array(
				'name' => $matches[9],
				'email' => $matches[11],
				'timestamp' => $matches[13],
				'offset' => $matches[14]
			),
			'message' => trim($matches[15])
		);
	}

}