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
	 * set query string property
	 *
	 * @param $sql
	 */
	public function setQueryString($sql);

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
}