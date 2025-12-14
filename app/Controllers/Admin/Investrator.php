<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InvestratorModel;

class Investrator extends BaseController
{
    protected $investratorModel;
    protected $investorName;
    public function __construct()
    {
        $this->investratorModel = new InvestratorModel();
    }
    public function index()
    {
        $invest['invest_data']=$this->investratorModel->getInvestmentsWithInvestors(10);
        $invest['pager']=$this->investratorModel->pager;
        return $this->template->admin_panel('investrator', [
            'title' => 'Invesment',
            'page_title' => 'Invesment Management',
            'page_description' => 'View and manage all recorded Invesment.',
            'invesments'=>$invest,
            'inv_names'=>$this->investratorModel->getInvsNames()        ]);
    }
    public function addInvesmentData()
    {
        $rules = [
            'investor_name' => 'required|numeric',
            'amount'        => 'required|numeric',
            'invest_date'   => 'required|valid_date',
            'note'          => 'permit_empty|string|max_length[500]'
        ];
        if (!$this->validate($rules)) {
            return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'error' => 'Please fill all required fields correctly.',
            ]);
        }
        $data = $this->request->getPost();
        $invesmentData = [
            'investor_id' => $data['investor_name'],
            'amount'      => $data['amount'],
            'invest_date' => $data['invest_date'],
            'note'        => $data['note']
        ];
        $this->investratorModel->insert($invesmentData);
        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)
                              ->setJSON(['message' => 'Invesment added successfully']);
    }
}
