<?php
class CreateTableEmployees extends CakeMigration
{

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'create_table_employees';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = [
		'up' => array(
		),
		'down' => array(
		),
	];

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction)
        {
		return TRUE;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction)
        {
		return TRUE;
	}
}
