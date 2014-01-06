<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:18
 */

namespace asql\Db;

/**
 * Class Command
 *
 * implements main driver-independent Command logic
 *
 * @package asql\Db
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
		$this->queryString = $query;
	}

	/**
	 * prepare a query for multiple execution
	 *
	 * @return IQuery
	 */
	public function prepare()
	{
		/** @var IQuery $query */
		$query = $this->connection->createQuery($this);
		return $query->prepare();
	}

	/**
	 * prepare and execute a result-less query (such as insert or update)
	 *
	 * @param bool $rowCount return row count if query succeeds
	 *
	 * @return bool|int
	 */
	public function execute($rowCount = false)
	{
		return $this->connection->createQuery($this)->execute($rowCount);
	}

	/**
	 * prepare and execute a result query (select)
	 *
	 * @param array|null $params parameters to apply,
	 * replaces ones which was configured by Command or CommandBuilder if any
	 *
	 * @return IQueryResult|false
	 */
	public function query($params = null)
	{
		return $this->connection->createQuery($this)->query($params);
	}
}