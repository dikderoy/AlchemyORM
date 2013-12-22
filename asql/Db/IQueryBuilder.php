<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 10:15
 */

namespace asql\Db;

/**
 * Interface IQueryBuilder
 *
 * a set of methods needed for QB
 *
 * main purpose of QB is to receive collected command meta
 * and make Query object with generated SQL from it
 *
 * @package asql\Db
 */
interface IQueryBuilder
{
	/**
	 * @param ICommand $meta
	 *
	 * @return string created select command statement
	 */
	public function buildSelectQuery(ICommand $meta);

	/**
	 * @param ICommand $meta
	 *
	 * @return mixed created insert command statement
	 */
	public function buildInsertQuery(ICommand $meta);

	/**
	 * @param ICommand $meta
	 *
	 * @return mixed created update command statement
	 */
	public function buildUpdateQuery(ICommand $meta);

	/**
	 * @param ICommand $meta
	 *
	 * @return string created delete command statement
	 */
	public function buildDeleteQuery(ICommand $meta);
}