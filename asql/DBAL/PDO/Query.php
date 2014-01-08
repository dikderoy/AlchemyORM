<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 07.01.14
 * Time: 20:53
 */

namespace asql\DBAL\PDO;

use asql\DBAL\Exception;
use asql\DBAL\IQuery;
use asql\DBAL\IQueryResult;
use asql\DBAL\Query as BaseQuery;

class Query extends BaseQuery implements IQuery
{
	/**
	 * Connection supervisor instance
	 *
	 * @var Connection
	 */
	protected $connection;
	/**
	 * @var \PDOStatement
	 */
	protected $statement;

	/**
	 * returns array presentation of command containing information
	 * to fully recreate it
	 *
	 * @return array
	 */
	public function getQueryMeta()
	{
		return array(
			'queryString' => $this->getQueryString(),
			'queryParams' => $this->getQueryParams(),
		);
	}

	/**
	 * prepare a query for multiple execution
	 *
	 * @throws \asql\DBAL\Exception
	 * @return IQuery
	 */
	public function prepare()
	{
		try {
			$this->statement = $this->connection->getConnection()->prepare($this->getQueryString());
			return $this;
		} catch (\PDOException $e) {
			throw new Exception(
				"Failed to prepare query: {$this->getQueryString()}. \r\n" .
				$e->getMessage(),
				$e->getCode(),
				$e
			);
		}
	}

	/**
	 * prepare and execute a result-less query (such as insert or update)
	 *
	 * @param null $params
	 * @param bool $rowCount return row count if query succeeds
	 *
	 * @throws \asql\DBAL\Exception
	 * @return bool|int
	 */
	public function execute($params = null, $rowCount = false)
	{
		if (!$params) {
			$params = $this->getQueryParams();
		}
		try {
			if ($this->statement instanceof \PDOStatement)
				$this->statement->execute($params);
			else
				$this->statement = $this->connection->getConnection()->query($qs = $this->getQueryString($params));
		} catch (\PDOException $exc) {
			$qs = (isset($qs)) ? $qs : $this->getQueryString();
			throw new Exception(
				"Failed to execute query: {$qs}.\r\n" .
				'parameters(' . implode(',', $params) . ").\r\n" .
				$exc->getMessage(),
				$exc->getCode(),
				$exc
			);
		}
		return ($rowCount) ? $this->statement->rowCount() : true;
	}

	/**
	 * prepare and execute a result query (select)
	 *
	 * @param array|null $params parameters to apply,
	 * replaces ones which was configured by Command or CommandBuilder if any
	 *
	 * @throws \asql\DBAL\Exception
	 * @return IQueryResult|false
	 */
	public function query($params = null)
	{
		if (!$params) {
			$params = $this->getQueryParams();
		}
		try {
			if ($this->statement instanceof \PDOStatement)
				$this->statement->execute($params);
			else
				$this->statement = $this->connection->getConnection()->query($qs = $this->getQueryString($params));
		} catch (\PDOException $exc) {
			$qs = (isset($qs)) ? $qs : $this->getQueryString();
			throw new Exception(
				"Failed to execute query: {$qs}.\r\n" .
				'parameters(' . implode(',', $params) . ").\r\n" .
				$exc->getMessage(),
				$exc->getCode(),
				$exc
			);
		}
		return $this->statement;
	}

	/**
	 * returns number of rows affected by last query executed
	 *
	 * @return int
	 */
	public function rowsAffected()
	{
		if ($this->statement instanceof \PDOStatement)
			return $this->statement->rowCount();
		return 0;
	}
}