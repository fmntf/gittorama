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

class Utils
{

	/**
	 * Make a string URL friendly.
	 *
	 * @param string $string
	 * @return string
	 */
	public static function toUrl($string)
	{
		$search  = array('à', 'è', 'é', 'ì', 'ò', 'ù', ' ', '(', ')', ';', ',', '.', ':', '!', '?', "'");
		$replace = array('a', 'e', 'e', 'i', 'o', 'u', '-', '',  '',  '',  '',  '',  '',  '',  '',  '');

		return str_replace($search, $replace, strtolower($string));
	}

}