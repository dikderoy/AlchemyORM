<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:13
 */

namespace asql\DBAL;

interface IConnection
{
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
	public function __construct(array $config = array(), array $options = array());

	/**
	 * sets parameters for connection to a server
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
	 *
	 * @return boolean
	 */
	public function setup(array $config, array $options = array());

	/**
	 * check if all required Db parameters are available
	 * @return bool
	 */
	public function check();

	/**
	 * initiate a connection to server
	 *
	 * @param array $options - additional options
	 *
	 * @throws Exception
	 */
	public function connect(array $options = array());

	/**
	 * returns Id of last inserted entry
	 * @return string
	 */
	public function getLastInsertId();

	/**
	 * returns active connection object or resource
	 * @return mixed
	 */
	public function getConnection();

	/**
	 * create new ICommand using ICommandBuilder
	 *
	 * @param string $query
	 *
	 * @return ICommand
	 */
	public function createCommand($query = null);

	/**
	 * create new IQuery
	 *
	 * @param string|ICommand $query
	 *
	 * @return IQuery
	 */
	public function createQuery($query);

	/**
	 * initiates a transaction
	 *
	 * @return ITransaction
	 */
	public function beginTransaction();
}