<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 08.01.14
 * Time: 21:37
 */

namespace asql\DBAL\PDO;

use asql\DBAL\Exception;
use asql\DBAL\ITransaction;
use asql\DBAL\Transaction as BaseTransaction;

class Transaction extends BaseTransaction implements ITransaction
{
	/**
	 * Connection Supervisor
	 * @var Connection
	 */
	protected $connection;

	public function begin()
	{
		parent::begin();
		try {
			return $this->active = $this->connection->getConnection()->beginTransaction();
		} catch (\PDOException $e) {
			throw new Exception("Transactions not supported by current PDO Driver or one is already in process.\r\n" .
								$e->getMessage(),
								$e->getCode(),
								$e);
		}
	}

	public function commit()
	{
		parent::commit();
		if ($this->isActive()) {
			$this->active = false;
			return $this->connection->getConnection()->commit();
		}
		throw new Exception('Unable to commit inactive transaction');
	}

	public function rollback()
	{
		parent::rollback();
		if ($this->isActive()) {
			$this->active = false;
			return $this->connection->getConnection()->rollBack();
		}
		throw new Exception('Unable to rollback inactive transaction');
	}
}