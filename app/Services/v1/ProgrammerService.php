<?php

namespace App\Services\v1;

use App\Programmer;


class ProgrammerService {
	public function getProgrammers(){
		return $this->filterProgrammers(Programmer::all());
	}

	protected function filterProgrammers($programmers) {
		$data = [];

		foreach ($programmers as $programmer) {
			$entry = [
				'programmerId' => $programmer->id,
				'full name' => $programmer->name,
				'email' => $programmer->email,
				'skills' => $programmer->skills,
				'location' => $programmer->location,
				'expert' => $programmer->expert
			];

			$data[] = $entry;

		}

		return $data;
		}
	}
