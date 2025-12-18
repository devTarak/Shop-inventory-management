<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ExpenseController extends BaseController
{
    protected $expenseModel;
    public function __construct()
    {
        // Load Expense Model
        $this->expenseModel = model('ExpenseModel');
    }
    public function index()
    {
        $expenses['expence_data'] = $this->expenseModel->orderBy('expense_date', 'DESC')->paginate(20);
        $expenses['pager'] = $this->expenseModel->pager;
        return $this->template->admin_panel('expenseview', [
            'title' => 'Expenses',
            'page_title' => 'Expense Management',
            'page_description' => 'View and manage all recorded expenses.',
            'expenses' => $expenses
        ]);
    }
    public function addExpense()
    {
        $rules = [
            'expense_purpose' => 'required|string|max_length[255]',
            'expenser_name'   => 'required|string|max_length[255]',
            'amount'          => 'required|numeric',
            'expense_date'    => 'required|valid_date'
        ];
        if (!$this->validate($rules)) {
            return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'error' => 'Please fill all required fields correctly.',
            ]);
        }
        $data = $this->request->getPost();
        $expenseData = [
            'expencePurpose' => $data['expense_purpose'],
            'expenser_name' => $data['expenser_name'],
            'amount' => $data['amount'],
            'expense_date' => $data['expense_date']
        ];
        $this->expenseModel->insert($expenseData);
        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)
                              ->setJSON(['message' => 'Expense added successfully']);
    }
    public function searchExpenses()
    {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        if (!$startDate || !$endDate) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['error' => 'Please provide both start and end dates.']);
        }

        $expenses = $this->expenseModel
            ->where('expense_date >=', $startDate)
            ->where('expense_date <=', $endDate)
            ->orderBy('expense_date', 'DESC')
            ->findAll();

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_OK)
            ->setJSON($expenses);
    }
}