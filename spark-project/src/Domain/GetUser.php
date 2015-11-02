<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class GetUser implements DomainInterface
{
	protected $fpdo;

	public function __construct(\FluentPDO $fluentpdo)
	{
		$this->fpdo = $fluentpdo;
	}

	public function __invoke(array $input)
	{
		if(empty($input['name'])){
			return (new Payload)
				->withStatus(Payload::ERROR)
				->withOutput([
					'error' => 'Missing name argument',
				]);
		}

		$name = $input['name'];
		$users = $this->fpdo->from('user')
				->where('name', $name);

		$output = [];
		foreach($users as $user){
			$output[] = $user;
		}
		return(new Payload)
			->withStatus(Payload::OK)
			->withOutput($output);
	}
}