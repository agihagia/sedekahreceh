<?php

namespace App\Controllers;



use App\Models\AuthModel;
use App\Models\sedekahModel;
use App\Models\sedekahDataModel;
use Config\Services;

class sedekah extends BaseController
{
    protected $sedekahModel;

    public function __construct()
    {
        $this->sedekahModel = new sedekahModel();
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Realisasi sedekah',
        ];

        return view('sedekah/sedekah', $data);
    }

    public function detail($slug)
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Detail sedekah',
            'sedekah' => $this->sedekahModel->getsedekah($slug)
        ];

        //jika data tidak ada ditabel
        if (empty($data['sedekah'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan.');
        }

        return view('sedekah/detail_sedekah', $data);
    }

    public function create()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Tambah Data sedekah',
            'validation' => \Config\Services::validation(),
        ];

        return view('sedekah/create_sedekah', $data);
    }

    public function save()
    {
        // validasi input
        if (!$this->validate([
            'jenis' => [
                'rules' => 'required|is_unique[realisasi.jenis]',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                    'is_unique' => 'Field {field} sudah terdaftar.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]', //'uploaded[sampul]| taruh dpn kalau mau ada error dan tdk pakai if(apakah tidak ada gambar) 
                'errors' => [
                    //'uploaded' => 'pilih gambar dahulu',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yg anda pilih bukan gambar',
                    'mime_in' => 'yg anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/sedekah/create')->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        //apakah tidak ada gambar yg diupload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'sedekah.jpg';
        } else {
            //generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();

            //pindahkan file ke folder images
            $fileSampul->move('images/sedekah/', $namaSampul);
        }

        $slug = url_title($this->request->getVar('jenis'), '-', true);
        $this->sedekahModel->save([
            'jenis' => $this->request->getVar('jenis'),
            'slug' => $slug,
            'rupiah' => $this->request->getVar('rupiah'),
            'des' => $this->request->getVar('des'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/datasedekah');
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $sedekah = $this->sedekahModel->find($id);

        //cek jika gambar default
        if ($sedekah['sampul'] != 'sedekah.jpg') {
            //hapus gambar
            unlink('images/sedekah/' . $sedekah['sampul']);
        }

        $this->sedekahModel->delete($id);
        session()->setFlashdata('del', 'Data berhasil dihapus');
        return redirect()->to('/datasedekah');
    }

    public function edit($id)
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Ubah Data sedekah',
            'validation' => \Config\Services::validation(),
            'sedekah' => $this->sedekahModel->find($id),
        ];

        return view('sedekah/edit_sedekah', $data);
    }

    public function update($id)
    {
        //cek jenis
        $sedekahlama = $this->sedekahModel->getsedekah($this->request->getVar('slug'));
        if ($sedekahlama['jenis'] == $this->request->getVar('jenis')) {
            $rule_jenis = 'required';
        } else {
            $rule_jenis = 'required|is_unique[realisasi.jenis]';
        }

        if (!$this->validate([
            'jenis' => [
                'rules' => $rule_jenis,
                'errors' => [
                    'required' => '{field} sedekah harus diisi!',
                    'is_unique' => '{field} sedekah sudah terdaftar.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]', //'uploaded[sampul]| taruh dpn kalau mau ada error dan tdk pakai if(apakah tidak ada gambar) 
                'errors' => [
                    //'uploaded' => 'pilih gambar dahulu',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yg anda pilih bukan gambar',
                    'mime_in' => 'yg anda pilih bukan gambar'
                ]
            ]
        ])) {

            return redirect()->to('/sedekah/edit_sedekah/' . $this->request->getVar('slug'))->withInput();
        }


        $fileSampul = $this->request->getFile('sampul');
        $def = $this->request->getVar('sampulLama');
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else if ($def == 'sedekah.jpg') {
            $namaSampul = $this->request->getVar('sampulLama');
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan gambar
            $fileSampul->move('images/sedekah/', $namaSampul);
        } else {
            //generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan gambar
            $fileSampul->move('images/sedekah/', $namaSampul);
            //hapus file lama
            unlink('images/sedekah/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('jenis'), '-', true);
        $this->sedekahModel->save([
            'id' => $id,
            'jenis' => $this->request->getVar('jenis'),
            'slug' => $slug,
            'rupiah' => $this->request->getVar('rupiah'),
            'des' => $this->request->getVar('des'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diupdate.');

        return redirect()->to('/datasedekah');
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new sedekahDataModel($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $foto = "<img src='".base_url()."/images/sedekah/".$list->sampul."' alt=\"Sampul\" class=\"\">";
                $btnEdit = "<a href='" . base_url() . "/sedekah/edit/$list->id' class=\"btn bg-primary btn-sm text-white me-2\" data-bs-toggle=\"tooltip\" title=\"Edit Data\"><i class=\"mdi mdi-pencil\"></i></a>";
                $btnDelete = "<form action='" . base_url() . "/sedekah/delete/$list->id' method=\"POST\" class=\"d-inline-block\">
                " . csrf_field() . "
                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                <button type=\"submit\" class=\"btn btn-danger btn-sm text-light\" onclick=\"return confirm('Apakah anda yakin menghapus data ini?')\"><i class=\"mdi mdi-delete\"></i></button>
                </form>";

                $row[] = $no;
                $row[] = $foto;
                $row[] = ucwords($list->jenis);
                $row[] = $list->rupiah;
                $row[] = $list->des;
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
}
