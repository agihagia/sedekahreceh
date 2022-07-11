<?php

namespace App\Controllers;



use App\Models\FaqModel;
use App\Models\FaqDataModel;
use Config\Services;

class Faq extends BaseController
{
    protected $faqModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
    }
    public function index()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }
        
        $data = [
            'title' => 'Daftar FAQ',
        ];
        return view('faq/view', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new FaqDataModel($request);
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
                $btnDelete = "<form action='" . base_url() . "/faq/delete/$list->id' method=\"POST\" class=\"d-inline-block\">
                " . csrf_field() . "
                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                <button type=\"submit\" class=\"btn btn-danger btn-sm text-light\" onclick=\"return confirm('Apakah anda yakin menghapus data ini?')\"><i class=\"mdi mdi-delete\"></i></button>
                </form>";

                $row[] = $no;
                $row[] = ucwords($list->pertanyaan);
                $row[] = $list->jawaban;
                $row[] = $btnEdit . $btnDelete;
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

    public function create()
    {
        if ($this->request->isAjax()) {

            $data = [
                'title' => 'Tambah Data FAQ',
                'validation' => \Config\Services::validation(),
            ];

            $msg = [
                'data' => view('App\Views\faq/add', $data)
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }

    public function save()
    {
        if ($this->request->isAjax()) {
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $input = $this->request->getVar();

            $valid = $this->validate([
                'pertanyaan' => [
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => 'Field {field} belum diisi'
                    ]
                ],
                'jawaban' => [
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => 'Field {field} belum diisi'
                    ]
                ]
            ]);

            if ($valid) {

                $data = [
                    'pertanyaan' => $input['pertanyaan'],
                    'jawaban' => $input['jawaban'],
                ];

                $this->faqModel->save($data);

                $msg = [
                    'data' => view('App\Views\faq/data', ['title' => 'Daftar FAQ', 'csrf_token' => $csrfHash])
                ];
            } else {
                $msg = [
                    'error' => [
                        'pertanyaan' => $this->validation->getError('pertanyaan'),
                        'jawaban' => $this->validation->getError('jawaban'),
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

    public function edit()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('id');

            $data = [
                'title' => 'Edit Data FAQ',
                'faq' => $this->faqModel->find($id)
            ];

            $msg = [
                'data' => view('App\Views\faq/edit', $data)
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
                'pertanyaan' => [
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => 'Field {field} belum diisi'
                    ]
                ],
                'jawaban' => [
                    'rules' => 'trim|required',
                    'errors' => [
                        'required' => 'Field {field} belum diisi'
                    ]
                ]
            ]);

            if ($valid) {

                $data = [
                    'pertanyaan' => $input['pertanyaan'],
                    'jawaban' => $input['jawaban'],
                ];

                $this->faqModel->update(['id' => $id], $data);

                $msg = [
                    'data' => view('App\Views\faq/data', ['title' => 'Data FAQ', 'csrf_token' => $csrfHash])
                ];
            } else {
                $msg = [
                    'error' => [
                        'pertanyaan' => $this->validation->getError('pertanyaan'),
                        'jawaban' => $this->validation->getError('jawaban'),
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
        $this->faqModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/faq');
    }

    public function refresh()
    {
        if ($this->request->isAjax()) {
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
        
            $msg = [
                'data' => view('App\Views\faq/data', ['title' => 'Daftar FAQ', 'csrf_token' => $csrfHash])
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }
}
