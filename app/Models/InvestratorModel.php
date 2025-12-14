<?php

namespace App\Models;

use CodeIgniter\Model;

class InvestratorModel extends Model
{
    protected $table            = 'investrators';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['investor_id', 'amount', 'invest_date', 'note'];

    public function getInvestmentsWithInvestors($perPage = 10)
    {
        return $this->select([
                    'investrators.id',
                    'investrators.amount',
                    'investrators.invest_date',
                    'investrators.note',
                    'investators_persons.investor_name'
                ])
                ->join(
                    'investators_persons',
                    'investators_persons.id = investrators.investor_id',
                    'left'
                )
                ->orderBy('invest_date', 'DESC')
                ->paginate($perPage);
    }
    public function getInvsNames()
    {
        $builder = $this->db->table('investators_persons');
        $query = $builder->select('id, investor_name')->get();
        return $query->getResultArray();
    }
}

