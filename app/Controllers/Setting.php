<?php

namespace App\Controllers;



use App\Models\SettingModel;
use App\Models\SettingDataModel;
use Config\Services;

class Setting extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }
    public function index()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }
        
        $data = [
            'title' => 'Daftar Pengaturan',
        ];
        return view('setting/view', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new SettingDataModel($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<a href='javascript:void(0);' class=\"btn bg-primary btn-sm text-white me-2\" data-bs-toggle=\"tooltip\" title=\"Edit Data\" onclick=\"edit($list->id)\"><i class=\"mdi mdi-pencil\"></i></a>";

                $row[] = $no;
                $row[] = $btnEdit;
                $row[] = $list->variable_setting;
                $row[] = $list->value_setting;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            $output[$csrfName] = $csrfHash;
            echo json_encode($output);
        }
    }

    public function edit()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('id');

            $data = [
                'title' => 'Edit Data Pengaturan',
                'setting' => $this->settingModel->find($id)
            ];

            $msg = [
                'data' => view('App\Views\setting/edit', $data)
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }

    public function update()
    {
        if ($this->request->isAjax()) {
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $id = $this->request->getVar('id');
            $input = $this->request->getVar();

            $valid = $this->validate([
                'value' => [
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => 'Field {field} belum diisi'
                    ]
                ]
            ]);

            if ($valid) {

                $data = [
                    'value_setting' => $input['value'],
                ];

                $this->settingModel->update(['id' => $id], $data);

                $msg = [
                    'data' => view('App\Views\setting/data', ['title' => 'Data Pengaturan', 'csrf_token' => $csrfHash])
                ];
            } else {
                $msg = [
                    'error' => [
                        'value_setting' => $this->validation->getError('value'),
                    ],
                    'csrf_token' => $csrfHash,
                    $csrfName => $csrfHash,
                ];
            }

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $this->settingModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/setting');
    }

    public function refresh()
    {
        if ($this->request->isAjax()) {
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
        
            $msg = [
                'data' => view('App\Views\setting/data', ['title' => 'Daftar Pengaturan', 'csrf_token' => $csrfHash])
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }
}
