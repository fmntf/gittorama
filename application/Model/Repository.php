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

class Model_Repository
{

	/**
	 * @var string Full path to the repository directory
	 */
	protected $path;

	/**
	 * @param string $path Full path to repository
	 */
	public function __construct($path)
	{
		$this->path = $path;
	}

	/**
	 * Tests if the repository effectively exists.
	 *
	 * @return bool
	 */
	public function exists()
	{
		return is_dir($this->path . '/.git');
	}

	/**
	 * Get the internal repository description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		$description = file_get_contents($this->path . '/.git/description');

		return trim($description);
	}

	/**
	 * Tests if the repository has the default description test, of if it has
	 * been changed.
	 *
	 * @return bool
	 */
	public function hasDefaultDescription()
	{
		$description = file_get_contents($this->path . '/.git/description');
		$default = "Unnamed repository; edit this file 'description' to name the repository.";

		return trim($description) == $default;
	}

	/**
	 * Get all the branches in the repository.
	 * 
	 * @return array
	 */
	public function getBranches()
	{
		$path = $this->path . '/.git';
		$result = shell_exec("git --git-dir=$path branch -v --no-color");

		// @todo: move me
		$default = "[\*]?";
		$noun = "[a-zA-Z0-9_\-]+";
		$commit = "[a-z0-9]+";
		$phrase = ".*";
		$space = "\s*";

		$pattern = "/($default)$space($noun)$space($commit)$space($phrase)/";

		$branches = array();

		foreach (explode("\n", trim($result)) as $rawBranch) {
			preg_match($pattern, $rawBranch, $matches);
			$branches[] = array(
				'name' => $matches[2],
				'hash' => $matches[3],
				'message' => $matches[4],
			);
		}

		return $branches;
	}

	/**
	 * Detects if the repository has a branch with the specified name.
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function hasBranch($name)
	{
		$found = false;
		foreach ($this->getBranches() as $branch) {
			if ($branch['name'] == $name) $found = true;
		}

		return $found;
	}


	public function getLogs($branchName)
	{
		foreach ($this->getBranches() as $branch) {
			if ($branch['name'] == $branchName) $hash = $branch['hash'];
		}

		$logs = array();

		$path = $this->path . '/.git';
		$result = shell_exec("git --git-dir=$path rev-list $branchName");

		foreach (explode("\n", trim($result)) as $hash) {
			$logs[] = new Model_Log($path, $hash);
		}

		return $logs;
	}

}