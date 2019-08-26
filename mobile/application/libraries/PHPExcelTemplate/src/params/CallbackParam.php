<?php

namespace alhimik1986\PhpExcelTemplator\params;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CallbackParam
{
	/**
	 * @var PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Текущий лист таблицы
	 */
	public $sheet;

	/**
	 * @var string Координата ячейки таблицы
	 */
	public $coordinate;

	/**
	 * @var mixed Значение параметра, передаваемого в сеттер (для текущей шаблонной переменной)
	 */
	public $param;

	/**
	 * @var string Имя шаблонной переменной в файле шаблона
	 */
	public $tpl_var_name;

	/**
	 * @var string Индекс массива значения параметра. Схема: ICellSetter->value[$row_index][$col_index]
	 */
	public $row_index;

	/**
	 * @var string Индекс подмассива значения параметра. Схема: ICellSetter->value[$row_index][$col_index]
	 */
	public $col_index;


	/**
	 * @param array $params
	 */
	public function __construct($params)
	{
		$fields = ['sheet', 'coordinate', 'param', 'tpl_var_name', 'row_index', 'col_index'];
		foreach($fields as $field) {
			if ( ! array_key_exists($field, $params)) {
				throw new \Exception('В конструкторе класса '.__CLASS__.' не был указан параметр '.$field.'.');
			}
			$this->$field = $params[$field];
		}
	}
}
