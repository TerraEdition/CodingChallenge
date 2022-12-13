<?php

namespace App\Models;

use CodeIgniter\Model;

class BonusesModel extends Model
{
    protected $table = "bonuses";
    protected $allowedFields = ['id_worker', 'slug', 'result', 'percent', 'created_by', 'updated_by'];

    public function getData($s = [])
    {
        $this->select('updated_at,slug,count(id) as total');
        if (!empty($s['updated_at'])) {
            $this->where("date(from_unixtime(updated_at))", $s['updated_at']);
        }
        if (!empty($s['orderBy']) && !empty($s['orderSort'])) {
            $this->orderBy($s['orderBy'], $s['orderSort']);
        } else {
            $this->orderBy('id', 'desc');
        }
        $this->groupBy('slug');
        if (!empty($s['total'])) {
            $this->having("count(id)", $s['total']);
        }
        return $this;
    }
}