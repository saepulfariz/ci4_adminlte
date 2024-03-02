<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
  public $logName = false;
  public $logId = false;
  protected $returnType       = 'array';
  public $logged = false;

  public function __construct()
  {
    parent::__construct();
    if ($this->logId == true || $this->logName == true) {
      $this->logged = logged('id');
    }
  }

  public function beforeInsert(array $data)
  {
    if ($this->logId == true) {
      $data['data']['cid'] = logged('id');
    }
    if ($this->logName == true) {
      if (logged('id')) {
        $data['data']['cname'] = $this->getUsername();
      }
    }
    return $data;
  }

  public function beforeUpdate(array $data)
  {
    if ($this->logId == true) {
      $data['data']['uid'] = logged('id');
    }
    if ($this->logName == true) {
      $data['data']['uname'] = $this->getUsername();
    }
    return $data;
  }

  public function beforeDelete(array $data)
  {
    if ($this->useSoftDeletes == true) {
      if ($this->logId == true) {
        $dataUpdate['did'] = logged('id');
      }
      if ($this->logName == true) {
        $dataUpdate['dname'] = $this->getUsername();
      }
      $this->db->table($this->table)->where($this->primaryKey, $data['id'][0])->update($dataUpdate);
    }
    return true;
  }

  public function getUsername()
  {
    $builder = $this->db->table('users');
    return $builder->where('id', logged('id'))->get()->getRowArray()['username'];
  }
}
