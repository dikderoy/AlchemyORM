<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:38
 */

namespace asql\Db;

class Helper
{
	/**
	 * returns string $elem enclosed in back-quotes " ` ` "
	 *
	 * @param string $elem
	 *
	 * @return string
	 */
	public static function backQuotesEnclose($elem)
	{
		return "`$elem`";
	}

	/**
	 * returns string $elem enclosed in parentheses "( )"
	 *
	 * @param string $elem
	 *
	 * @return string
	 */
	public static function scopeEnclose($elem)
	{
		return "($elem)";
	}

	/**
	 * accepts array, attaches colon(:) to its key values and returns it
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function arrayAttachKeyColon($array)
	{
		$output = array();
		foreach ($array as $key => $value)
			$output[":{$key}"] = $value;
		return $output;
	}
}