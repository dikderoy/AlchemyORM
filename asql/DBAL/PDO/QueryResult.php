<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 07.01.14
 * Time: 22:37
 */

namespace asql\DBAL\PDO;

use asql\DBAL\IQueryResult;
use \PDOStatement as BaseQueryResult;

class QueryResult extends BaseQueryResult implements IQueryResult
{
	/**
	 * @var \PDO
	 */
	public $dbh;

	/**
	 * this constructor override is needed (otherwise it is not working)
	 *
	 * @param $dbh - either a connection handle or statement object
	 *
	 * should be saved within QueryResult object
	 *
	 * for PDO results it's a class extended from PDOStatement
	 * and it should accept PDO object and store it
	 * in public attribute $dbh
	 *
	 * for non PDO drivers its a statement object to fetch results from
	 * and it should be stored in protected attribute $statement
	 */
	protected function __construct($dbh)
	{
		$this->dbh = $dbh;
	}

	/**
	 * fetch first column from row of result query as is
	 *
	 * @return mixed
	 */
	public function fetchScalar()
	{
		return parent::fetchColumn();
	}

	/**
	 * fetch Nth column values as array
	 *
	 * @param int $columnNumber
	 *
	 * @return array
	 */
	public function fetchColumn($columnNumber = 0)
	{
		return $this->fetchAll(\PDO::FETCH_COLUMN, $columnNumber);
	}

	/**
	 * pass next row of query result into existing object instance
	 *
	 * @param $obj - object to fetch into
	 *
	 * @return boolean
	 */
	public function fetchIntoObject($obj)
	{
		$this->setFetchMode(\PDO::FETCH_INTO, $obj);
		$res = $this->fetch();
		$this->setFetchMode(\PDO::FETCH_BOTH);
		return $res;
	}

	/**
	 * fetch all rows of query result as array of objects of given class
	 *
	 * @param string $class name of class which instance should be returned
	 * @param array  $params array of parameters passed to class constructor
	 *
	 * @param null   $index
	 *
	 * @return object[]|boolean
	 */
	public function fetchObjectCollection($class, $params = null, $index = null)
	{
		if ($index) {
			$set = array();
			$this->setFetchMode(\PDO::FETCH_CLASS, $class, $params);
			while ($row = $this->fetch())
				$set[$row->$index] = $row;
			$this->setFetchMode(\PDO::FETCH_BOTH);
			return $set;
		}
		return $this->fetchAll(\PDO::FETCH_CLASS, $class, $params);
	}

	/**
	 * fetch next row of query result as array of key-paired values
	 *
	 * @param boolean $numericalKeys fetch row with numerical keys instead of string keys
	 *
	 * @return array|boolean
	 */
	public function fetchArray($numericalKeys = false)
	{
		$numericalKeys = ($numericalKeys) ? \PDO::FETCH_NUM : \PDO::FETCH_ASSOC;
		return $this->fetch($numericalKeys);
	}

	/**
	 * fetch all rows of query result as collection arrays of key-paired values (optionally indexed by $index)
	 *
	 * @param null|string $index field name to fetch result by (if null - collection will have numeric index)
	 * @param boolean     $numericalKeys fetch row with numerical keys instead of string keys
	 *
	 * @return array[]|boolean
	 */
	public function fetchArrayCollection($numericalKeys = false, $index = null)
	{
		$numericalKeys = ($numericalKeys) ? \PDO::FETCH_NUM : \PDO::FETCH_ASSOC;
		if ($index) {
			$set = array();
			while ($row = $this->fetch($numericalKeys))
				$set[$row[$index]] = $row;
			return $set;
		}
		return $this->fetchAll($numericalKeys);
	}
}