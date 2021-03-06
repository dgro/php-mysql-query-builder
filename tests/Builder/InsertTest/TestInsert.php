<?php
namespace Kir\MySQL\Builder\InsertTest;

use Kir\MySQL\Builder\Insert;
use Kir\MySQL\Databases\TestDB;

class TestInsert extends Insert {
	/**
	 * @return static
	 */
	public static function create() {
		$functions = array(
			'getTableFields' => function ($tableName) {
				return array(
					'id',
					'name',
					'last_update'
				);
			}
		);
		$db = new TestDB($functions);
		return new static($db);
	}

	/**
	 * @return string
	 */
	public function asString() {
		return $this->__toString();
	}
}