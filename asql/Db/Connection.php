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
	private $queryClass = 'Query';
	private $commandClass = 'Command';
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