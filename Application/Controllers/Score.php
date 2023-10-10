<?php
use MVC\Controller;


class ControllersScore extends Controller
{
	public function detail(){

		$model = $this->model('score');

		// Read All Task
		$response = $model->getScoresByStudentId();

		if (!$response || is_string($response)) {
			$this->response->sendStatus(200);
			$this->response->setContent([
				'code' => '400',
				'error' => $response
			]);
			return;
		}

		// Prepare Data
		$data = [
			'code' => '200',
			'data' => $response
		];

		// Send Response
		$this->response->sendStatus(200);
		$this->response->setContent($data);
	}

	public function update()
	{
		if ($this->request->getMethod() === "POST") {
			$model = $this->model('score');

			// Read All Task
			$response = $model->updateScore($this->request->getPost());

			if (!$response || is_string($response)) {
				$this->response->sendStatus(200);
				$this->response->setContent([
					'code' => '400',
					'error' => $response
				]);
				return;
			}

			// Prepare Data
			$data = [
				'code' => '200',
				'data' => $response
			];

			// Send Response
			$this->response->sendStatus(200);
			$this->response->setContent($data);
		}
	}


}