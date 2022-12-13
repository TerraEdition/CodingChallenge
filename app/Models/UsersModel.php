<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = "users";
    protected $allowedFields = ['name', 'username', 'password', 'role', 'slug', 'created_by', 'updated_by', 'status'];

    public function getData($s = [])
    {
        if (!empty($s['status'])) {
            $this->where('status', $s['status']);
        }
        if (!empty($s['role'])) {
            $this->where('role', $s['role']);
        }
        if (!empty($s['updated_at'])) {
            $this->where("date(from_unixtime(updated_at))", $s['updated_at']);
        }
        if (!empty($s['username'])) {
            $this->like('username', $s['username']);
        }
        if (!empty($s['name'])) {
            $this->like('name', $s['name']);
        }
        if (!empty($s['orderBy']) && !empty($s['orderSort'])) {
            $this->orderBy($s['orderBy'], $s['orderSort']);
        } else {
            $this->orderBy('id', 'desc');
        }
        return $this;
    }
}