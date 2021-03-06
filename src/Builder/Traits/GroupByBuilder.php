<?php
namespace Kir\MySQL\Builder\Traits;

trait GroupByBuilder {
	use AbstractDB;

	/**
	 * @var array
	 */
	private $groupBy = array();

	/**
	 * @return $this
	 */
	public function groupBy() {
		foreach(func_get_args() as $expression) {
			if(is_array($expression)) {
				if(!count($expression)) {
					continue;
				}
				$arguments = array(
					$expression[0],
					array_slice($expression, 1)
				);
				$expression = $this->quoteExpr($arguments);
			}
			$this->groupBy[] = $expression;
		}
		return $this;
	}

	/**
	 * @param string $query
	 * @return string
	 */
	protected function buildGroups($query) {
		if(!count($this->groupBy)) {
			return $query;
		}
		$query .= "GROUP BY\n";
		$arr = array();
		foreach($this->groupBy as $expression) {
			$arr[] = "\t{$expression}";
		}
		return $query.join(",\n", $arr)."\n";
	}

	/**
	 * @param array $arguments
	 * @return mixed
	 */
	protected function quoteExpr(array $arguments) {
		return call_user_func_array(array($this->db(), 'quoteExpression'), $arguments);
	}
}
