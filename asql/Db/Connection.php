<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:17
 */

namespace asql\Db;

abstract class Connection implements IConnection
{
	/**
	 * configurable class used for Queries,
	 * must implement IQuery interface
	 * and|or be extended from \asq\Db\Query or its descendants
	 *
	 * @var string
	 */
	protected $queryClass = '\asql\Db\Query';
	/**
	 * configurable class used for Commands,
	 * must implement ICommand interface
	 * and|or be extended from \asq\Db\Command or its descendants
	 *
	 * @var string
	 */
	protected $commandClass = '\asql\Db\Command';
	/**
	 * configurable class used for Statements|QueryResults,
	 * must implement IQueryResult interface
	 * and|or be extended from \asq\Db\QueryResult or its descendants
	 *
	 * @var string
	 */
	protected $resultClass = '\asql\Db\QueryResult';
	/**
	 * configuration parameters as is
	 *
	 * @var array
	 */
	protected $config = array();
	/**
	 * additional options for PDO object
	 *
	 * @param array $options
	 */
	protected $options = array();
	/**
	 * connection resource
	 *
	 * @var mixed|resource|null
	 */
	protected $connection;

	/**
	 * sets parameters for connection to a server
	 *
	 * actually runs IConnection::setup() within if arguments provided
	 *
	 * typical configuration consists of:
	 *
	 *  username;
	 *  password;
	 *  server address;
	 *  port (optional)
	 *
	 * options may consist of additional configuration which affects default driver behavior,
	 * e.g. look at PDO connection setup
	 *
	 * @param array $config - required configuration data
	 * @param array $options - additional options for PDO object
	 */
	public function __construct(array $config = array(), array $options = array())
	{
		if ($config)
			$this->setup($config, $options);
	}

	/**
	 * returns active connection object or resource
	 * @return mixed
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * sets parameters for connection to a server
	 *
	 * @param array $config - required configuration data
	 * @param array $options - additional options for PDO object
	 *
	 * @return boolean
	 */
	public function setup(array $config, array $options = array())
	{
		$this->config  = $config;
		$this->options = $options;
	}

	/**
	 * create new ICommand using ICommandBuilder
	 *
	 * @param string $query
	 *
	 * @return ICommand
	 */
	public function createCommand($query = null)
	{
		if ($query)
			return new $this->commandClass($this, $query);
		return new $this->commandClass($this);
	}

	/**
	 * create new IQuery
	 *
	 * @param string|ICommand $query
	 *
	 * @return IQuery
	 */
	public function createQuery($query)
	{
		return new $this->queryClass($this, $query);
	}
}