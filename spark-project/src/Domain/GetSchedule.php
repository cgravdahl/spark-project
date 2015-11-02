<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class GetSchedule implements DomainInterface
{
	protected $fpdo; 

	public function __construct(\FluentPDO $fluentpdo)
	{
		$this->fpdo = $fluentpdo;
	}

	public function __invoke(array $input)
	{
		if(empty($input['id'])){
			return (new Payload)
				->withStatus(Payload::ERROR)
				->withOutput([
						'error' => 'Missing id argument',
					]);
		}

		$id = $input['id'];
		$shifts = $this->fpdo->from('shift')
					->where('employee_id', $id);

		$output = [];
		foreach($shifts as $shift){
			$output[] = $shift;
		}
		return(new Payload)
			->withStatus(Payload::OK)
			->withOutput($output); 
	}
}