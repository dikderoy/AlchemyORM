<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:19
 */

namespace asql\Db;

class Exception extends \PDOException
{
	public function __construct($message, $code = 0, $previous = null)
	{
		if (!is_int($code)) {
			$message .= " error code: $code.";
			$code = 0;
		}
		parent::__construct($message, $code, $previous);
	}
}