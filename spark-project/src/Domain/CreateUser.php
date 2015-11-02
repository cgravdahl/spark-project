<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class CreateUser implements DomainInterface
{
	protected $fpdo;

	public function __construct(\FluentPDO $fluentpdo)
	{
		$this->fpdo = $fluentpdo;
	}

	public function __invoke(array $input)
	{
		$user = [
			'name' 		=> $input['name'],
			'role' 		=> $input['role'],
			'email' 	=> $input['email'],
			'phone' 	=> $input['phone'],
			'created_at'=> $input[NOW()],
		]

		$new_user = $this->fpdo->insertInto('user',$user)->execute();

		return(new Payload)
			->withStatus(Payload::OK)
			->withOutput([
				'user'=>$new_user,
			]);
	}
}