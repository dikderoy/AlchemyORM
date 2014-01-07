<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:13
 */

namespace asql\Db;

/**
 * Interface IQuery
 *
 * purpose of Query objects is simple
 * - they present the API to control generated Statement object
 * and properly evaluate it
 *
 * @package asql\Db
 */
interface IQuery extends ICommand
{
	/**
	 * receives connection and command to bootstrap from
	 *
	 * @param IConnection          $connection
	 * @param null|string|ICommand $query
	 */
	public function __construct(IConnection $connection, $query = null);

	/**
	 * returns statement object or sql result handle if available, otherwise returns:
	 *
	 * null  - if handle not yet created (i.e. query statement not executed yet)
	 *
	 * false - if handle not available for configured driver
	 *
	 * @return mixed|null|false
	 */
	public function getStatement();

	/**
	 * return a query string
	 *
	 * if params passed - perform param replacement in query string
	 *
	 * @param array|null $params
	 *
	 * @return string
	 */
	public function getQueryString($params = null);

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
	 * returns number of rows affected by last query executed
	 *
	 * @return int
	 */
	public function rowsAffected();
}