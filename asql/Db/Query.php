<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:17
 */

namespace asql\Db;

/**
 * Class Query
 *
 * implements main driver-independent Query logic
 *
 * @package asql\Db
 */
abstract class Query implements IQuery
{
	/**
	 * Connection supervisor instance
	 *
	 * @var IConnection
	 */
	protected $connection;
	/**
	 * @var string Pure SQL query string
	 */
	protected $queryString;
	/**
	 * @var array query parameters to be bound
	 */
	protected $queryParams = array();
	/**
	 * @var resource|mixed statement object
	 */
	protected $statement;

	/**
	 * if $query is not null it is treated as string and assigned using setQueryString()
	 *
	 * @param IConnection          $connection
	 * @param null|string|ICommand $query
	 */
	public function __construct(IConnection $connection, $query = null)
	{
		$this->connection = $connection;
		if ($query) {
			if ($query instanceof ICommand) {
				$this->setQueryString($query->getQueryString());
				$this->setQueryParams($query->getQueryParams());
			} else
				$this->setQueryString($query);
		}
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
	 * @param null $params
	 *
	 * @return string
	 */
	public function getQueryString($params = null)
	{
		//TODO: add support of parameter replacement (for non prepared queries)

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
	 * returns statement object or sql result handle if available, otherwise returns:
	 *
	 * null  - if handle not yet created (i.e. query statement not executed yet)
	 *
	 * false - if handle not available for configured driver
	 *
	 * @return mixed|null|false
	 */
	public function getStatement()
	{
		return $this->statement;
	}
}