<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:15
 */

namespace asql\Db;

/**
 * Interface ICommand
 *
 * main purpose of Command object is to represent data needed
 * to construct the Query object
 *
 * @package asql\Db
 */
interface ICommand
{
	/**
	 * if $query is not null it is treated as string and assigned using setQueryString()
	 *
	 * @param IConnection $connection
	 * @param null        $query
	 */
	public function __construct(IConnection $connection, $query = null);

	/**
	 * set query string property
	 *
	 * @param $query
	 */
	public function setQueryString($query);

	/**
	 * set query parameters to be bound
	 *
	 * @param $params
	 */
	public function setQueryParams($params);

	/**
	 * returns ready to use query string with param placeholders
	 *
	 * @return string
	 */
	public function getQueryString();

	/**
	 * returns query parameters ready to be bound
	 *
	 * @return array
	 */
	public function getQueryParams();

	/**
	 * returns array presentation of command containing information
	 * to fully recreate it
	 *
	 * @return array
	 */
	public function getQueryMeta();

	/**
	 * prepare a query for multiple execution
	 *
	 * @return IQuery
	 */
	public function prepare();

	/**
	 * prepare and execute a result-less query (such as insert or update)
	 *
	 * @param array|null $params parameters to apply, replaces ones
	 *                           which was configured by Command or CommandBuilder if any
	 * @param bool       $rowCount return row count if query succeeds
	 *
	 * @return bool|int
	 */
	public function execute($params = null, $rowCount = false);

	/**
	 * prepare and execute a result query (select)
	 *
	 * @param array|null $params parameters to apply, replaces ones
	 *                           which was configured by Command or CommandBuilder if any
	 *
	 * @return IQueryResult|false
	 */
	public function query($params = null);

	/**
	 * string representation of a command
	 *
	 * @return string
	 */
	public function __toString();
}