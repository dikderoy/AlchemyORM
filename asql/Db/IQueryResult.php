<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:16
 */

namespace asql\Db;

interface IQueryResult
{
	/**
	 * fetch first column from row of result query as is
	 *
	 * @return mixed
	 */
	public function fetchScalar();

	/**
	 * fetch Nth column values as array
	 *
	 * @param int $columnNumber
	 *
	 * @return array
	 */
	public function fetchColumn($columnNumber = 0);

	/**
	 * pass next row of query result into existing object instance
	 *
	 * @param $obj - object to fetch into
	 *
	 * @return boolean
	 */
	public function fetchIntoObject($obj);

	/**
	 * fetch next row of query result as an object of given class
	 *
	 * @param string $class name of class which instance should be returned
	 * @param array  $params array of parameters passed to class constructor
	 *
	 * @return object|boolean
	 */
	public function fetchObject($class, $params = null);

	/**
	 * fetch all rows of query result as array of objects of given class
	 *
	 * @param string      $class name of class which instance should be returned
	 * @param array       $params array of parameters passed to class constructor
	 * @param null|string $index field name to fetch result by (if null - collection will have numeric index)
	 *
	 * @return object[]|boolean
	 */
	public function fetchObjectCollection($class, $params = null, $index = null);

	/**
	 * fetch next row of query result as array of key-paired values
	 *
	 * @param boolean $numericalKeys fetch row with numerical keys instead of string keys
	 *
	 * @return array|boolean
	 */
	public function fetchArray($numericalKeys = false);

	/**
	 * fetch all rows of query result as collection arrays of key-paired values (optionally indexed by $index)
	 *
	 * @param boolean     $numericalKeys fetch row with numerical keys instead of string keys
	 * @param null|string $index field name to fetch result by (if null - collection will have numeric index)
	 *
	 * @return array[]|boolean
	 */
	public function fetchArrayCollection($numericalKeys = false, $index = null);
}