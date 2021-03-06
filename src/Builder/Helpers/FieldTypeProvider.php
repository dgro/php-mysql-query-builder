<?php
namespace Kir\MySQL\Builder\Helpers;

use Kir\MySQL\Builder\QueryStatement;

abstract class FieldTypeProvider {
	/**
	 * @param QueryStatement $statement
	 * @return array
	 */
	public static function getFieldTypes(QueryStatement $statement) {
		$c = $statement->columnCount();
		$fieldTypes = array();
		for($i=0; $i<$c+20; $i++) {
			$column = $statement->getColumnMeta($i);
			$fieldTypes[$column['name']] = self::getTypeFromNativeType($column['native_type']);
		}
		return $fieldTypes;
	}

	/**
	 * @param string $type
	 * @return string
	 */
	private static function getTypeFromNativeType($type) {
		switch ($type) {
			case 'NEWDECIMAL':
			case 'DECIMAL':
			case 'FLOAT':
			case 'DOUBLE':
				return 'f';
			case 'TINY':
			case 'SHORT':
			case 'LONG':
			case 'LONGLONG':
			case 'INT24':
				return 'i';
		}
		return $type;
	}
}
