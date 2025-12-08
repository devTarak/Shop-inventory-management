<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table            = 'expenses';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id', 'expencePurpose', 'expenser_name', 'amount', 'expense_date'];
}
