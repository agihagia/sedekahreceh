<?php

namespace App\Controllers;



use App\Models\BackupModel;
use App\Models\BackupDataModel;
use Config\Services;
use Y0lk\SQLDumper\SQLDumper;

class Backup extends BaseController
{
    protected $backupModel;

    public function __construct()
    {
        $this->backupModel = new BackupModel();
    }
    public function index()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }
        
        $data = [
            'title' => 'Daftar Backup DB',
        ];
        return view('backup/view', $data);
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new BackupDataModel($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnEdit = "<a href='" . base_url() . "/$list->file_path' class=\"btn bg-primary btn-sm text-white me-2\" data-bs-toggle=\"tooltip\" title=\"Download Data\"><i class=\"mdi mdi-download\"></i></a>";
                $btnDelete = "<form action='" . base_url() . "/backup/delete/$list->id' method=\"POST\" class=\"d-inline-block\">
                " . csrf_field() . "
                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                <button type=\"submit\" class=\"btn btn-danger btn-sm text-light\" onclick=\"return confirm('Apakah anda yakin menghapus data ini?')\"><i class=\"mdi mdi-delete\"></i></button>
                </form>";

                $row[] = $no;
                $row[] = ucwords($list->file_name);
                $row[] = "<a href='".base_url()."/$list->file_path' alt=''>$list->file_path</a>";
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

    public function save()
    {
        if ($this->request->isAjax()) {
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();

            //Backup DB
            $tanggal = date('Ymd-His');
            $path = 'files/backups/';
            $namaFile = 'backup-' . $tanggal . '.sql';
            $pathFile = $path;

            $hostName = env('database.default.hostname');
            $databaseName = env('database.default.database');
            $userName = env('database.default.username');
            $password = env('database.default.password');

            //Init the dumper with your DB info
            $dumper = new SQLDumper($hostName, $databaseName, $userName, $password);
            //Set all tables to dump without data and without DROP statement
            $dumper->allTables()
                ->withData(true)
                ->withDrop(true);
            //This will group DROP statements and put them at the beginning of the dump
            //$dumper->groupDrops(true);
            //This will group INSERT statements and put them at the end of the dump
            //$dumper->groupInserts(true);
            $dumper->save($pathFile . $namaFile);

            $data = [
                'file_name' => $namaFile,
                'file_path' => $path . $namaFile
            ];

            $this->backupModel->save($data);

            $msg = [
                'data' => view('App\Views\backup/data', ['title' => 'Daftar FAQ', 'csrf_token' => $csrfHash, $csrfName => $csrfHash])
            ];

            return $this->response->setJSON($msg);
        } else {
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $hapus = $this->backupModel->find($id);
        $filepath = $hapus['file_path'];
        unlink($filepath);
        $this->backupModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/backup');
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
