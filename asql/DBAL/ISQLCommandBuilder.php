<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:14
 */

namespace asql\DBAL;

interface ISQLCommandBuilder
{
	public function select($cols);

	public function from($table);

	public function join($table, $on);

	public function andJoin($table, $on);

	public function where($condition);

	public function andWhere($condition);

	public function orWhere($condition);

	public function orderBy($cols);

	public function groupBy($cols);

	public function having($condition);

	public function andHaving($condition);

	public function orHaving($condition);

	public function limit($count, $offset);

	public function insertInto($table);

	public function values($values);

	public function update($table);

	public function set($values);

	public function deleteFrom($table);
}