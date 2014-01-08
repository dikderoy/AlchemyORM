<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 08.01.14
 * Time: 21:07
 */

namespace asql\DBAL;

interface ITransaction
{
	/**
	 * Connection supervisor instance
	 *
	 * @param IConnection $connection
	 */
	public function __construct(IConnection $connection);

	/**
	 * whatever current transaction is active
	 * @return bool
	 */
	public function isActive();

	/**
	 * begin a transaction
	 *
	 * @return bool
	 */
	public function begin();

	/**
	 * commit a transaction
	 *
	 * @return bool
	 */
	public function commit();

	/**
	 * rollback a transaction
	 *
	 * @return bool
	 */
	public function rollback();
}