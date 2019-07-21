<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract Class BaseRepository {

	protected $model;

	public function getAll($columns = array('*')) {
		return $this->model->get($columns);
	}

	public function create($data) {
		return $this->model->create($data);
	}

	public function update($id, $data) {
		return $this->model->where('id', '=', $id)->update($data);
	}

	public function delete($id) {
		return $this->model->destroy($id);
	}

	public function find($id) {
		return $this->model->find($id);
	}
}