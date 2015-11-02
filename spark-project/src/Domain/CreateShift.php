<?php

namespace SPark\Project\Domain;

use Spark\Adr\DomainInerface;
use Spark\Payload;

class CreateShift implements DomainInerface
{
	protected $fpdo;

	public function __construct(\FluentPDO $fluentpdo)
	{
		$this->fpdo = $fluentpdo;
	}

	public function __invoke(array $input)
	{
		$shift = [
			'manager_id'		=>$input['manager_id'],
			'employee_id'		=>$input['employee_id'],
			'break'				=>$input['break'],
			'start_time'		=>$input['start_time'],
			'end_time'			=>$input['end_time'],
			'created_at'		=> $input[NOW()],
		]
		$new_shift = $this->fpdo->insertInto('shift',$shift)->execute();

		return(new Payload)
			->withStatus(Payload::OK)
			->withOutput([
					'shift'=>$new_shift,
				]);
	}
}