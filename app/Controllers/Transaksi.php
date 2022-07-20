<?php

namespace App\Controllers;



use App\Models\AuthModel;
use App\Models\SedekahModel; 
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\TransaksiDataModel;
use App\Libraries\Settings;
use Config\Services;
use TCPDF;

class Transaksi extends BaseController
{
    protected $authModel;
    protected $sedekahModel;
    protected $transaksiModel;
    protected $detailModel;
    protected $setting;

    public function __construct()
    {
        $this->authModel = new AuthModel();
        $this->sedekahModel = new sedekahModel();
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel = new DetailTransaksiModel();
        $this->setting = new Settings();
    }

    function _generateId()
    {
        $query = $this->transaksiModel->select("max(id) as last");
        $hasil = $query->get()->getRowArray();
        $last = $hasil['last'] + 1;
        $noUrut = sprintf('%05s', $last);

        $unique = date('Ymd') . $noUrut;
        return $unique;
    }

    public function index()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Transaksi',
            'transaksi' => $this->transaksiModel->getTransaksi(),

            'user' => $this->authModel->find(session('id'))
        ];
        return view('transaksi/index', $data);
    }

    public function setor($id)
    {
        if (allow('admin')) {
        } else {
            if (session('id') != $id) {
                return redirect()->to('/dashboard');
            }
        }

        $data = [
            'title' => 'Transaksi Setor',
            'nasabah' => $this->authModel->getById($id),
            'sedekah' => $this->sedekahModel->findAll(),
            'user' => $this->authModel->find(session('id'))
        ];
        return view('transaksi/setor', $data);
    }
    
    public function tarik($id)
    {
        if (allow('admin')) {
        } else {
            if (session('id') != $id) {
                return redirect()->to('/dashboard');
            }
        }

        $data = [
            'title' => 'Tarik Saldo',
            'validation' => \Config\Services::validation(),
            'user' => $this->authModel->getById($id)
        ];
        return view('transaksi/tarik', $data);
    }

    public function setorsedekah()
    {
        $var = $this->request->getPost();
        $detail = [];
        foreach ($var['jenis'] as $key => $value) {
            $detailTr = [
                'id_realisasi' => $value,
                'qty' => $var['qty'][$key],
                'rupiah' => $var['rupiahSatuan'][$key],
                'rupiah_total' => $var['qty'][$key] * $var['rupiahSatuan'][$key]
            ];
            array_push($detail, $detailTr);
        }

        // dapatkan user yang saat ini login, untuk isi kolom admin pada tabel transaksi
        $admin = (object)$this->authModel->find(session()->id);
        $data = [
            'no_transaksi' => $this->_generateId(),
            'id_admin' => $admin->id,
            'id_user' => $this->request->getPost('id'),
            'jenis_transaksi' => 'masuk',
            'status_transaksi' => '1',
            'total_rupiah' => $this->request->getPost('total'),
            'detail_transaksi' => $detail
        ];
        $result = $this->transaksiModel->setorsedekah($data);
        
        if (allow('admin')) {
            return redirect()->to('/transaksi')->with('pesan', 'Transaksi Setor sedekah Berhasil dengan ID Transaksi = ' . $result);
        } else {
            return redirect()->to('/user')->with('pesan', 'Transaksi Setor sedekah Berhasil');
        }
    }

    public function tarikSaldo()
    {
        if (!$this->validate([
            'tarik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukkan jumlah penarikan saldo!',
                ]
            ]
        ])) {

            return redirect()->back()->withInput();
        }

        // dapatkan user yang saat ini login, untuk isi kolom admin pada tabel transaksi
        $admin = (object)$this->authModel->find(session()->id);
        $data = [
            'no_transaksi' => $this->_generateId(),
            'id_admin' => $admin->id,
            'id_user' => $this->request->getPost('id'),
            'jenis_transaksi' => 'keluar',
            'status_transaksi' => '0',
            'total_rupiah' => $this->request->getPost('tarik')
        ];
        $result = $this->transaksiModel->tarikSaldo($data);

        if (allow('admin')) {
            return redirect()->to('/transaksi')->with('pesan', 'Transaksi Penarikan Saldo Berhasil diajukan dengan ID Transaksi = ' . $result);
        } else {
            return redirect()->to('/user')->with('pesan', 'Transaksi Penarikan Saldo Berhasil diajukan');
        }
    }

    public function getDetail()
    {
        $id_transaksi = $this->request->getGet('id_transaksi');
        $data = $this->detailModel->getDetail($id_transaksi);
        // $data = $this->detailModel->where(['id_transaksi' => $id_transaksi])->findAll();
        echo json_encode($data);
    }

    public function cetakTransaksi($id)
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'instansi' => $this->setting->info['nama_instansi'],
            'alamat' => $this->setting->info['alamat_instansi'],
            'telpon' => $this->setting->info['telp_instansi'],
            'email' => $this->setting->info['email_instansi'],
            'transaksi' => $this->transaksiModel->kwitansi($id),
            'detail' => $this->detailModel->getDetail($id)
        ];

        $html = view('transaksi/kwitansi', $data);
        $pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);

        $pdf->SetCreator('TCPDF');
        $pdf->SetAuthor('TCPDF');
        $pdf->SetTitle('Kwitansi ' . $data['transaksi']['jenis_transaksi']);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, 'L');
        //line ini penting
        $this->response->setContentType('application/pdf');
        //Close and output PDF document
        $pdf->Output('Kwitansi.pdf', 'I');
        // Output I untuk display saja, D untuk download pilih sendiri
        // $pdf->Output('Kwitansi.pdf', 'D');
    }

    public function rekap()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $dari = $this->request->getVar('dari');
        $sampai = $this->request->getVar('sampai');
        $data = [
            'instansi' => $this->setting->info['nama_instansi'],
            'alamat' => $this->setting->info['alamat_instansi'],
            'telpon' => $this->setting->info['telp_instansi'],
            'email' => $this->setting->info['email_instansi'],
            'transaksi' => $this->transaksiModel->rekapTransaksi($dari, $sampai),
            'dari' => $dari,
            'sampai' => $sampai
        ];

        $html = view('transaksi/rekap', $data);
        
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('TCPDF');
        $pdf->SetTitle('Rekap Transaksi');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->addPage();
        // dd($pdf);
        $pdf->writeHTML($html, true, false, true, false, '');
        // $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('Rekap-Transaksi.pdf', 'I');
    }

    public function hapus()
    {
        $id = $this->request->getPost('id');
        $hapus = $this->transaksiModel->delete($id, true);
        if ($hapus)
            echo 'sukses';
        else echo 'gagal';
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new TransaksiDataModel($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                if ($list->jenis_transaksi == 'masuk') {
                    $jenis = "<div class=\"badge badge-success\">Masuk</div>";
                } else {
                    $jenis = "<div class=\"badge badge-danger\">Keluar</div>";
                }

                if ($list->jenis_transaksi == 'keluar') {
                    $btnDetail = "<button data-bs-toggle=\"modal\" data-bs-target=\"#tarikModal\" data-jenis=\"$list->jenis_transaksi\" data-total=\"$list->total_rupiah\" data-nama=\"$list->nama\" data-tanggal=\"$list->created_at\" data-id=\"$list->id\" class=\"btn bg-primary btn-sm text-light me-2\"><i class=\"mdi mdi-eye\"></i></button>";
                } else {
                    $btnDetail = "<button data-bs-toggle=\"modal\" data-bs-target=\"#detailModal\" data-jenis=\"$list->jenis_transaksi\" data-total=\"$list->total_rupiah\" data-nama=\"$list->nama\" data-tanggal=\"$list->created_at\" data-id=\"$list->id\" class=\"btn bg-primary btn-sm text-light me-2\"><i class=\"mdi mdi-eye\"></i></button>";
                }

                if ($list->status_transaksi == '1') {
                    $status = "<div class=\"badge badge-success\"><i class=\"fas fa-check-circle\"></i> Selesai</div>";
                } else {
                    $status = "<a href=\"javascript:void(0);\" onclick=\"proses($list->id)\" data-bs-toggle=\"tooltip\" title=\"Proses Transaksi\"><div class=\"badge badge-danger\"><i class=\"fas fa-minus-circle\"></i> Tertunda</div></a>";
                }

                $btnDelete = "<button type=\"submit\" class=\"btn btn-danger btn-sm text-light\" data-id=\"$list->id\" onclick=\"hapus(this)\"><i class=\"mdi mdi-delete\"></i></button>
                </form>";

                $row[] = $no;
                $row[] = $list->no_transaksi;
                $row[] = ucwords($list->nama);
                $row[] = $list->total_rupiah;
                $row[] = $jenis;
                $row[] = $status;
                $row[] = $list->created_at;
                $row[] = $btnDetail . $btnDelete;
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

    public function prosesPenarikan()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getPost('id');
            $status = $this->transaksiModel->find($id)['status_transaksi'];
            $toggle = $status ? 1 : 1;

            $update = $this->transaksiModel->update(['id' => $id], ['status_transaksi' => $toggle]);

            if ($update)
                echo 'sukses';
            else echo 'gagal';
        } else {
            return redirect()->back();
        }
    }
}
