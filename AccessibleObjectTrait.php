<?php
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @copyright 2010 onwards James McQuillan (http://pdyn.net)
 * @author James McQuillan <james@pdyn.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace pdyn\testing;

/**
 * A trait that can be used in test to allow access to all protected/private properties and methods.
 *
 * @codeCoverageIgnore
 */
trait AccessibleObjectTrait {
	/**
	 * Magic method run protected/private methods.
	 *
	 * @param string $name The called method name.
	 * @param array $arguments Array of arguments.
	 */
	public function __call($name, $arguments) {
		if (method_exists($this, $name)) {
			return call_user_func_array([$this, $name], $arguments);
		}
	}

	/**
	 * Magic method run protected/private static methods.
	 *
	 * @param string $name The called method name.
	 * @param array $arguments Array of arguments.
	 */
	public static function __callStatic($name, $arguments) {
		$class = get_called_class();
		if (method_exists($class, $name)) {
			return forward_static_call_array([$class, $name], $arguments);
		}
	}

	/**
	 * Magic isset function inspect protected/private properties.
	 *
	 * @param string $name The name of the property.
	 * @return bool Whether the property is set.
	 */
	public function __isset($name) {
		return (isset($this->$name)) ? true : false;
	}

	/**
	 * Magic unset function to unset protected/private properties.
	 *
	 * @param string $name The name property to unset.
	 */
	public function __unset($name) {
		if (isset($this->$name)) {
			unset($this->$name);
		}
	}

	/**
	 * Get the value of a protected/private property.
	 *
	 * @param string $name The name of the property.
	 * @return mixed The value.
	 */
	public function __get($name) {
		return (isset($this->$name)) ? $this->$name : false;
	}

	/**
	 * Set the value of a protected/private property.
	 *
	 * @param string $name The name of the property.
	 * @param mixed $val The value to set.
	 */
	public function __set($name, $val) {
		$this->$name = $val;
	}
}
