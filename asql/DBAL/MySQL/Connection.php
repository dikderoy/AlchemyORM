<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 07.01.14
 * Time: 19:39
 */

namespace asql\DBAL\MySQL;

use asql\DBAL\PDO\Connection as PDOConnection;
use asql\DBAL\IConnection;

/**
 * Class Connection
 *
 * MySQL connection Supervisor Object
 *
 * @package asql\DBAL\MySQL
 */
class Connection extends PDOConnection implements IConnection
{
	/**
	 * server address
	 * @var string
	 */
	protected $server;
	/**
	 * server port
	 * @var int
	 */
	protected $port;
	/**
	 * database name to connect to
	 * @var string
	 */
	protected $database;
	/**
	 * database charset
	 * @var string
	 */
	protected $charset;

	/**
	 * sets parameters for connection to a server
	 *
	 * typical configuration consists of:
	 *
	 *  username;
	 *  password;
	 *  server;
	 *  port (optional);
	 *  charset (optional);
	 *
	 * you can also provide a valid DSN (use `dsn` config array key)
	 * according to specifics of PDO MySQL dsn key to use extra connection
	 * options which PDO provide (uri to dsn file or unix socket path to local server)
	 *
	 * @see \PDO
	 * @see http://php.net/manual/en/ref.pdo-mysql.connection.php
	 *
	 * @param array $config
	 * @param array $options
	 *
	 * @return bool|void
	 */
	public function setup(array $config, array $options = array())
	{
		parent::setup($config, $options);
		$this->commandClass = '\asql\DBAL\MySQL\Command';

		$params = array(
			'dsn',
			'username',
			'password',
			'server',
			'port',
			'database',
			'charset',
		);
		foreach ($params as $property)
			if (isset($this->config[$property]) && !empty($this->config[$property]))
				$this->$property = $this->config[$property];

		//setup DSN if it is empty (not provided by user)
		if (!$this->dsn) {
			$dsn = "mysql:host={$this->server};";
			if ($this->port)
				$dsn .= "port={$this->port};";
			$dsn .= "dbname={$this->database};";
			if ($this->charset) {
				$dsn .= "charset={$this->charset};";
				$this->options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES {$this->charset}";
			}
			if ($dsn)
				$this->dsn = $dsn;
		}
		$this->options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
	}
}