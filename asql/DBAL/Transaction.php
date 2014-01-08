<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 08.01.14
 * Time: 21:32
 */

namespace asql\DBAL;

class Transaction implements ITransaction
{
	/**
	 * indicates whatever transaction is currently active
	 * @var bool
	 */
	protected $active = false;
	/**
	 * Connection supervisor instance
	 *
	 * @var IConnection
	 */
	protected $connection;

	/**
	 * constructor does not begins transaction
	 * you should call ITransaction::begin() explicitly
	 *
	 * @param IConnection $connection
	 */
	public function __construct(IConnection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * whatever current transaction is active
	 * @return bool
	 */
	public function isActive()
	{
		return $this->active;
	}

	/**
	 * begin a transaction
	 *
	 * @return bool
	 */
	public function begin()
	{
	}

	/**
	 * commit a transaction
	 *
	 * @return bool
	 */
	public function commit()
	{
	}

	/**
	 * rollback a transaction
	 *
	 * @return bool
	 */
	public function rollback()
	{
	}
}