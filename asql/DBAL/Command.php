<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:18
 */

namespace asql\DBAL;

/**
 * Class Command
 *
 * implements main driver-independent Command logic
 *
 * @package asql\DBAL
 */
abstract class Command implements ICommand
{
	/**
	 * @var string Pure SQL query string
	 */
	protected $queryString;
	/**
	 * @var array query parameters to be bound
	 */
	protected $queryParams = array();

	/**
	 * if $query is not null it is treated as string and assigned using setQueryString()
	 *
	 * @param IConnection $connection
	 * @param null        $query
	 */
	public function __construct(IConnection $connection, $query = null)
	{
		$this->connection = $connection;
		if ($query)
			$this->setQueryString($query);
	}

	/**
	 * string representation of a command
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->getQueryString();
	}

	/**
	 * returns query parameters ready to be bound
	 *
	 * @return array
	 */
	public function getQueryParams()
	{
		return $this->queryParams;
	}

	/**
	 * set query parameters to be bound
	 *
	 * @param $params
	 */
	public function setQueryParams($params)
	{
		$this->queryParams = $params;
	}

	/**
	 * returns ready to use query string with param placeholders
	 *
	 * @return string
	 */
	public function getQueryString()
	{
		return $this->queryString;
	}

	/**
	 * set query string property
	 *
	 * @param $query
	 */
	public function setQueryString($query)
	{
		if ($query !== null && is_string($query))
			$this->queryString = $query;
	}

	/**
	 * prepare a query for multiple execution
	 *
	 * @throws Exception
	 * @return IQuery
	 */
	public function prepare()
	{
		if ($this->queryString == null)
			throw new Exception('no query to prepare');
		return $this->connection->createQuery($this)->prepare();
	}

	/**
	 * prepare and execute a result-less query (such as insert or update)
	 *
	 * @param array|null $params parameters to apply, replaces ones
	 *                           which was configured by Command or CommandBuilder if any
	 * @param bool       $rowCount return row count if query succeeds
	 *
	 * @throws Exception
	 * @return bool|int
	 */
	public function execute($params = null, $rowCount = false)
	{
		if ($this->queryString == null)
			throw new Exception('no query to execute');
		return $this->connection->createQuery($this)->execute($params, $rowCount);
	}

	/**
	 * prepare and execute a result query (select)
	 *
	 * @param array|null $params parameters to apply, replaces ones
	 *                           which was configured by Command or CommandBuilder if any
	 *
	 * @throws Exception
	 * @return IQueryResult|false
	 */
	public function query($params = null)
	{
		if ($this->queryString == null)
			throw new Exception('no query to stream results from');
		return $this->connection->createQuery($this)->query($params);
	}
}