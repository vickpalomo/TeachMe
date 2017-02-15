<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->truncateTables(array(
			'users',
			'tickets',
			'ticket_votes'
			));
		$this->call('UserTableSeeder');
		$this->call('TicketTableSeeder');
		$this->call('TicketVoteTableSeeder');
		$this->call('TicketCommentTableSeeder');
	}

	public function truncateTables(array $tables)
	{
		$this->checkForeignKeys(false);
		foreach ($tables as $table) {
			DB::table($table)->truncate();
		}
		$this->checkForeignKeys(true);
	}

	public function checkForeignKeys($check)
	{
		$check = $check ? '1' : '0';
		DB::statement('SET FOREIGN_KEY_CHECKS = '.$check);
	}
}
