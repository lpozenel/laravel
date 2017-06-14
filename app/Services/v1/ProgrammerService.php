<?php

namespace App\Services\v1;

use App\Programmer;


class ProgrammerService {
	protected $supportedIncludes = [
		'user' => 'programmer',
	];

	protected $clauseProperties = [
		'user'
	];

	public function getProgrammers($parameters){
		if (empty($parameters)){

		return $this->filterProgrammers(Programmer::all());
	}


	$withKeys = $this->getWithKeys($parameters);
	$whereClauses = $this->getWhereClause($parameters);

	$programmers = Programmer::with($withKeys)->where($whereClauses)->get();

	return $this->filterProgrammers($programmers, $withKeys);
}

	public function addProgrammers($req) {
		$programmer = new Programmer();
		$programmer->name = $req->input('name');
		$programmer->email = $req->input('email');
		$programmer->skills = $req->input('skills');
		$programmer->location = $req->input('location');
		$programmer->expert = $req->input('expert');

		$programmer->save();

		return $this->filterProgrammers ([programmer]);


	}

	protected function filterProgrammers($programmers, $keys = []) {
		$data = [];

		foreach ($programmers as $programmer) {
			$entry = [
				'programmerId' => $programmer->id,
				'name' => $programmer->name,
				'email' => $programmer->email,
				'skills' => $programmer->skills,
				'location' => $programmer->location,
				'expert' => $programmer->expert
			];

			if(in_array('user', $keys)){
				$entry['arrival'] = [
				'name' => $programmer->name,
				'email' => $programmer->email,
				'skills' => $programmer->skills,
				'location' => $programmer->location,
				'expert' => $programmer->expert,

				];
			}

			$data[] = $entry;

		}

		return $data;
		}

		protected function getWithKeys($parameters) {
			$withKeys = [];

			if(isset($parameters['include'])){
				$includeParms = explode(',', $parameters['include']);
				$includes = array_intersect($this->supportedIncludes, $includeParms);
				$withKeys = array_keys($includes);
			}

			return $withKeys;
		}

		protected function getWhereClause($parametres) {
			$clause = [];

			foreach($this->clauseProperties as $prop){
				if(in_array($prop, array_keys($parametres))){
					$clause[$prop] = $parameters [$prop];
				}
			}

			return $clause;
		}
	}
