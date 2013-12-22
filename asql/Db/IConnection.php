<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:13
 */

namespace asql\Db;

interface IConnection
{
	/**
	 * sets parameters for connection to a server
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
	 * @return ICommandBuilder
	 */
	public function createCommand($query = null);
}