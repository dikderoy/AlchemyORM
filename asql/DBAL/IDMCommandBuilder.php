<?php
/**
 * Created by PhpStorm.
 * User: Deroy
 * Date: 22.12.13
 * Time: 7:14
 */

namespace asql\DBAL;

/**
 * Interface IDMCommandBuilder
 *
 * defines Data Manipulation Command Builder interface
 *
 * @package asql\DBAL
 */
interface IDMCommandBuilder extends ICommand
{
	/**
	 * $cols can be either a string or an array, if former - it is used as is
	 * otherwise - on latter checks and escapements are performed
	 *
	 * if latter you can specify column aliases as array keys: array('alias'=>'column')
	 *
	 * @param array|string $cols columns or expressions to fill SELECT CLAUSE
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function select($cols);

	/**
	 * @param array|string $table table(s) and|or expressions to fill FROM CLAUSE
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function from($table);

	/**
	 * table can be either a table name or an expression (sub-query) or even an ICommand instance
	 *
	 * @param string          $type join type such as `LEFT JOIN`
	 * @param string|ICommand $table table name, expression or ICommand instance to be joined with
	 * @param string          $on join condition
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function join($type, $table, $on);

	/**
	 * wrapper for join() with predefined `INNER JOIN` as $type
	 *
	 * table can be either a table name or an expression (sub-query) or even an ICommand instance
	 *
	 * @param string|ICommand $table table name, expression or ICommand instance to be joined with
	 * @param string          $on join condition
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function innerJoin($table, $on);

	/**
	 * wrapper for join() with predefined `LEFT JOIN` as $type
	 *
	 * table can be either a table name or an expression (sub-query) or even an ICommand instance
	 *
	 * @param string|ICommand $table table name, expression or ICommand instance to be joined with
	 * @param string          $on join condition
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function leftJoin($table, $on);

	/**
	 * wrapper for join() with predefined `RIGHT JOIN` as $type
	 *
	 * table can be either a table name or an expression (sub-query) or even an ICommand instance
	 *
	 * @param string|ICommand $table table name, expression or ICommand instance to be joined with
	 * @param string          $on join condition
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function rightJoin($table, $on);

	/**
	 * sets contents of WHERE CLAUSE
	 *
	 * you can define whole WHERE part here,
	 * if you decide to do so DO NOT use any other
	 * method which is intend to change contents of WHERE CLAUSE
	 * (e.g. orderBy, groupBy, limit, having, etc.)
	 *
	 * The method requires a $condition parameter, and optionally a $params parameter
	 * specifying the values to be bound to the query.
	 *
	 * The $condition parameter should be either a string (e.g. 'id=1') or an array.
	 * If the latter, it must be in one of the following two formats:
	 *
	 * - hash format: `['column1' => value1, 'column2' => value2, ...]`
	 * - operator format: `[operator, operand1, operand2, ...]`
	 *
	 * A condition in hash format represents the following SQL expression in general:
	 * `column1=value1 AND column2=value2 AND ...`. In case when a value is an array,
	 * an `IN` expression will be generated. And if a value is null, `IS NULL` will be used
	 * in the generated expression. Below are some examples:
	 *
	 * - `['type' => 1, 'status' => 2]` generates `(type = 1) AND (status = 2)`.
	 * - `['id' => [1, 2, 3], 'status' => 2]` generates `(id IN (1, 2, 3)) AND (status = 2)`.
	 * - `['status' => null] generates `status IS NULL`.
	 *
	 * A condition in operator format generates the SQL expression according to the specified operator, which
	 * can be one of the followings:
	 *
	 * - `and`: the operands should be concatenated together using `AND`. For example,
	 * `['and', 'id=1', 'id=2']` will generate `id=1 AND id=2`. If an operand is an array,
	 * it will be converted into a string using the rules described here. For example,
	 * `['and', 'type=1', ['or', 'id=1', 'id=2']]` will generate `type=1 AND (id=1 OR id=2)`.
	 * The method will NOT do any quoting or escaping.
	 *
	 * - `or`: similar to the `and` operator except that the operands are concatenated using `OR`.
	 *
	 * - `between`: operand 1 should be the column name, and operand 2 and 3 should be the
	 * starting and ending values of the range that the column is in.
	 * For example, `['between', 'id', 1, 10]` will generate `id BETWEEN 1 AND 10`.
	 *
	 * - `not between`: similar to `between` except the `BETWEEN` is replaced with `NOT BETWEEN`
	 * in the generated condition.
	 *
	 * - `in`: operand 1 should be a column or DB expression, and operand 2 be an array representing
	 * the range of the values that the column or DB expression should be in. For example,
	 * `['in', 'id', [1, 2, 3]]` will generate `id IN (1, 2, 3)`.
	 * The method will properly quote the column name and escape values in the range.
	 *
	 * - `not in`: similar to the `in` operator except that `IN` is replaced with `NOT IN` in the generated condition.
	 *
	 * - `like`: operand 1 should be a column or DB expression, and operand 2 be a string or an array representing
	 * the values that the column or DB expression should be like.
	 * For example, `['like', 'name', 'tester']` will generate `name LIKE '%tester%'`.
	 * When the value range is given as an array, multiple `LIKE` predicates will be generated and concatenated
	 * using `AND`. For example, `['like', 'name', ['test', 'sample']]` will generate
	 * `name LIKE '%test%' AND name LIKE '%sample%'`.
	 * The method will properly quote the column name and escape special characters in the values.
	 * Sometimes, you may want to add the percentage characters to the matching value by yourself, you may supply
	 * a third operand `false` to do so. For example, `['like', 'name', '%tester', false]` will generate `name LIKE '%tester'`.
	 *
	 * - `or like`: similar to the `like` operator except that `OR` is used to concatenate the `LIKE`
	 * predicates when operand 2 is an array.
	 *
	 * - `not like`: similar to the `like` operator except that `LIKE` is replaced with `NOT LIKE`
	 * in the generated condition.
	 *
	 * - `or not like`: similar to the `not like` operator except that `OR` is used to concatenate
	 * the `NOT LIKE` predicates.
	 *
	 * @param string|array $condition condition or array of condition definitions
	 * @param array        $params parameters to be bound to condition :placeholders
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function where($condition, $params);

	/**
	 * appends where condition using `AND` to the existing one
	 *
	 * @see where()
	 *
	 * @param string|array $condition condition or array of condition definitions
	 * @param array        $params parameters to be bound to condition :placeholders
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function andWhere($condition, $params);

	/**
	 * appends where condition using `OR` to the existing one
	 *
	 * @see where()
	 *
	 * @param string|array $condition condition or array of condition definitions
	 * @param array        $params parameters to be bound to condition :placeholders
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function orWhere($condition, $params);

	/**
	 * sets ORDER BY CLAUSE
	 *
	 * @param string|array $cols columns to order by
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function orderBy($cols);

	/**
	 * sets GROUP BY CLAUSE
	 *
	 * @param string|array $cols columns to group by
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function groupBy($cols);

	/**
	 * sets HAVING CLAUSE
	 *
	 * @param string $condition having condition
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function having($condition);

	/**
	 * appends $condition to existing one in HAVING CLAUSE using AND operator
	 *
	 * @param string $condition having condition
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function andHaving($condition);

	/**
	 * appends $condition to existing one in HAVING CLAUSE using OR operator
	 *
	 * @param string $condition having condition
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function orHaving($condition);

	/**
	 * sets LIMIT CLAUSE
	 *
	 * @param int $count how much to select
	 * @param int $offset how much to skip from beginning of result set
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function limit($count, $offset);

	/**
	 * forms an INSERT command
	 *
	 * @param string $table table to insert into
	 * @param array  $values values to insert,
	 * can be (1)1-level key-paired array for single row insert
	 * or 2-level array with equal row definitions(1) for multi-row insert
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function insertInto($table, $values);

	/**
	 * forms an UPDATE command
	 *
	 * @param string $table table to update values in
	 * @param array  $values values to update (1-level key-paired array column=>value)
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function update($table, $values);

	/**
	 * forms a DELETE command
	 *
	 * @param string $table table to delete from
	 *
	 * @return static CB object itself (chaining method)
	 */
	public function deleteFrom($table);
}