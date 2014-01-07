<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 08.01.14
 * Time: 1:43
 */

namespace asql\Db\PDO;

use asql\Db\Connection as BaseConnection;
use asql\Db\Exception;
use asql\Db\IConnection;

/**
 * Class Connection
 *
 * Generic PDO Connection supervisor
 *
 * @package asql\Db\PDO
 *
 * @method \PDO getConnection()
 */
abstract class Connection extends BaseConnection implements IConnection
{
	/**
	 * PDO connection object
	 * @var \PDO
	 */
	protected $connection;
	/**
	 * ready to use PDO dsn string
	 * @var string
	 */
	protected $dsn;
	/**
	 * server username
	 * @var string
	 */
	protected $username;
	/**
	 * server password
	 * @var string
	 */
	protected $password;

	/**
	 * returns Id of last inserted entry
	 *
	 * @throws \asql\Db\Exception
	 * @return string
	 */
	public function getLastInsertId()
	{
		try {
			return $this->connection->lastInsertId();
		} catch (\PDOException $e) {
			throw new Exception($e->getMessage(), $e->getCode(), $e);
		}
	}

	/**
	 * initiate a connection to server
	 *
	 * @param array $options - additional options
	 *
	 * @throws Exception
	 */
	public function connect(array $options = array())
	{
		try {
			if (!empty($options)) {
				$this->options = array_merge($this->options, $options);
			}
			$this->connection = new \PDO($this->dsn, $this->username, $this->password, $this->options);
			$this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
			$this->connection->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array($this->resultClass, array($this->connection)));
		} catch (\PDOException $e) {
			throw new Exception($e->getMessage(), $e->getCode(), $e);
		}
	}

	public function setup(array $config, array $options = array())
	{
		parent::setup($config, $options);

		$this->queryClass  = '\asql\Db\PDO\Query';
		$this->resultClass = '\asql\Db\PDO\QueryResult';
	}

	/**
	 * check if all required Db parameters are available
	 * @return bool
	 */
	public function check()
	{
		if ($this->username && $this->password && $this->dsn)
			return true;
		return false;
	}
}