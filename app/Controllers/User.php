<?php

namespace App\Controllers;



use App\Libraries\Settings;
use App\Models\AuthModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\UserDataModel;
use Config\Services;

class User extends BaseController
{
    protected $setting;
    protected $authModel;
    protected $userData;
    protected $transaksiModel;
    protected $detailModel;
    protected $uri;

    public function __construct()
    {
        $this->setting = new Settings();
        $this->authModel = new AuthModel();
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel = new DetailTransaksiModel();
    }

    public function index()
    {
        $id_user = session('id');
        $akun = $this->authModel->where(['id' => $id_user])->first();
        $nama = $akun['username'];
        $showLimit = 3;
        $transaksi = $this->transaksiModel->getTransaksiUser('', $id_user, $showLimit);

        $data = [
            'title' => 'Profil saya',
            'validation' => \Config\Services::validation(),
            'user' => $this->authModel->getakun($nama),
            'transaksi' => $transaksi,
            'jmlTrMasuk' => $this->transaksiModel->where(['jenis_transaksi' => 'masuk', 'id_user' => $id_user])->countAllResults(),
            'jmlTrKeluar' => $this->transaksiModel->where(['jenis_transaksi' => 'keluar', 'id_user' => $id_user])->countAllResults(),
        ];
        return view('user/index', $data);
    }

    public function loadMore()
    {
        if ($this->request->getVar('id')) {
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $id_user = session('id');
            $showLimit = 2;
            $id = $this->request->getVar('id');
            $totalRowCount = $this->transaksiModel->countTransaksiUser($id, $id_user);

            $transaksi = $this->transaksiModel->getTransaksiUser($id, $id_user, $showLimit);

            $data = [
                'total' => $totalRowCount,
                'limit' => $showLimit,
                'transaksi' => $transaksi,
            ];
            $data[$csrfName] = $csrfHash;
            return view('user/load_more', $data);
        }
    }

    public function akun()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Daftar Akun',
        ];
        return view('akun/akun', $data);
    }

    public function detail($nama)
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $akun = $this->authModel->where(['username' => $nama])->first();
        $id_user = $akun['id'];
        $showLimit = 3;
        $transaksi = $this->transaksiModel->getTransaksiUser('', $id_user, $showLimit);

        $data = [
            'title' => 'Detail Akun',
            'auth' => $this->authModel->getakun($nama),
            'transaksi' => $transaksi,
        ];

        //jika data tidak ada ditabel
        if (empty($data['auth'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan.');
        }

        return view('akun/detail_akun', $data);
    }

    public function detailLoadMore()
    {
        if ($this->request->getVar('id')) {
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $id_user = $this->request->getVar('id_user');
            $showLimit = 2;
            $id = $this->request->getVar('id');
            $totalRowCount = $this->transaksiModel->countTransaksiUser($id, $id_user);

            $transaksi = $this->transaksiModel->getTransaksiUser($id, $id_user, $showLimit);

            $data = [
                'total' => $totalRowCount,
                'limit' => $showLimit,
                'transaksi' => $transaksi,
            ];
            $data[$csrfName] = $csrfHash;
            return view('akun/load_more', $data);
        }
    }

    public function register()
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Register Akun',
            'validation' => \Config\Services::validation()
        ];
        return view('akun/register', $data);
    }

    public function save_register()
    {
        // validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[users.nama]',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                    'is_unique' => 'Field {field} sudah terdaftar.'
                ]
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]|max_length[50]',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                ]
            ],
            'rt' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                ]
            ],
            'rw' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/svg]', //'uploaded[foto]| taruh dpn kalau mau ada error dan tdk pakai if(apakah tidak ada foto) 
                'errors' => [
                    //'uploaded' => 'pilih foto dahulu',
                    'max_size' => 'ukuran foto terlalu besar',
                    'is_image' => 'File yg anda pilih bukan foto',
                    'mime_in' => 'File yg anda pilih bukan foto'
                ]
            ]
        ])) {
            return redirect()->to('/akun/register')->withInput();
        }

        $fileFoto = $this->request->getFile('foto');
        //apakah tidak ada gambar yg diupload
        if ($fileFoto->getError() == 4) {
            $namaFoto = 'profile.png';
        } else {
            //generate nama foto random
            $foto = $fileFoto->getRandomName();
            $namaFoto = 'images/photos/' . $foto;
            //pindahkan file ke folder images
            $fileFoto->move('images/photos/', $foto);
        }

        $nama = $this->request->getVar('nama');
        $this->authModel->save([
            'nama' => $nama,
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'alamat' => $this->request->getVar('alamat'),
            'rt' => $this->request->getVar('rt'),
            'rw' => $this->request->getVar('rw'),
            'foto' => $namaFoto,
            'level' => 'user',
            'saldo' => '0',
            'active' => 1
        ]);

        session()->setFlashdata('pesan', 'Pendaftaran Akun berhasil.');

        return redirect()->to('/akun');
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $auth = $this->authModel->find($id);

        //cek jika gambar default
        if ($auth['foto'] != 'profile.png') {
            //hapus gambar
            unlink($auth['foto']);
        }

        $this->authModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/akun');
    }

    public function edit_akun($nama)
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Form Ubah Data Akun',
            'validation' => \Config\Services::validation(),
            'auth' => $this->authModel->getakun($nama)
        ];

        return view('akun/edit_akun', $data);
    }

    public function update_akun($id)
    {
        //cek nama
        $nama = $this->request->getVar('nama');

        if ($nama) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[users.nama]';
        }

        if (!$this->validate([
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'required' => '{field} Nama harus diisi!',
                    'is_unique' => '{field} Nama sudah terdaftar.'
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/svg]', //'uploaded[foto]| taruh dpn kalau mau ada error dan tdk pakai if(apakah tidak ada gambar) 
                'errors' => [
                    //'uploaded' => 'pilih gambar dahulu',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yg anda pilih bukan gambar',
                    'mime_in' => 'yg anda pilih bukan gambar'
                ]
            ],
        ])) {

            return redirect()->to('/akun/edit/' . $this->request->getVar('username'))->withInput();
        }

        $fileFoto = $this->request->getFile('foto');
        $def = $this->request->getVar('fotoLama');
        if ($fileFoto->getError() == 4) {
            $namaFoto = $this->request->getVar('fotoLama');
        } else if ($def == 'profile.png') {
            //$namaFoto = $this->request->getVar('fotoLama');
            $foto = $fileFoto->getRandomName();
            $namaFoto = 'images/photos/' . $foto;
            //pindahkan gambar
            $fileFoto->move('images/photos/', $foto);
        } else {
            //generate nama file random
            $foto = $fileFoto->getRandomName();
            $namaFoto = 'images/photos/' . $foto;
            //pindahkan gambar
            $fileFoto->move('images/photos/', $foto);
            //hapus file lama
            unlink($def);
        }

        $nama = $this->request->getVar('nama');
        $this->authModel->save([
            'id' => $id,
            'nama' => $nama,
            'username' => $this->request->getVar('username'),
            'alamat' => $this->request->getVar('alamat'),
            'rt' => $this->request->getVar('rt'),
            'rw' => $this->request->getVar('rw'),
            'saldo' => $this->request->getVar('saldo'),
            'foto' => $namaFoto,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diperbarui.');
        return redirect()->to('/akun');
    }

    public function edit_user($nama)
    {
        $data = [
            'title' => 'Ubah Profil saya',
            'validation' => \Config\Services::validation(),
            'auth' => $this->authModel->getakun($nama)
        ];

        return view('user/edit_user', $data);
    }

    public function update_user($id)
    {
        //cek nama
        $nama = $this->request->getVar('nama');
        if ($nama) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[users.nama]';
        }

        if (!$this->validate([
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'required' => '{field} Nama harus diisi!',
                    'is_unique' => '{field} Nama sudah terdaftar.'
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/svg]', //'uploaded[foto]| taruh dpn kalau mau ada error dan tdk pakai if(apakah tidak ada gambar) 
                'errors' => [
                    //'uploaded' => 'pilih gambar dahulu',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yg anda pilih bukan gambar',
                    'mime_in' => 'yg anda pilih bukan gambar'
                ]
            ],
        ])) {

            return redirect()->to('/user/edit/' . $this->request->getVar('username'))->withInput();
        }

        $fileFoto = $this->request->getFile('foto');
        $def = $this->request->getVar('fotoLama');
        if ($fileFoto->getError() == 4) {
            $namaFoto = $this->request->getVar('fotoLama');
        } else if ($def == 'profile.png') {
            $foto = $fileFoto->getRandomName();
            $namaFoto = 'images/photos/' . $foto;
            //pindahkan gambar
            $fileFoto->move('images/photos/', $foto);
        } else {
            //generate nama file random
            $foto = $fileFoto->getRandomName();
            $namaFoto = 'images/photos/' . $foto;
            //pindahkan gambar
            $fileFoto->move('images/photos/', $foto);
            //hapus file lama
            unlink($def);
        }

        $nama = $this->request->getVar('nama');
        $this->authModel->save([
            'id' => $id,
            'nama' => $nama,
            'username' => $this->request->getVar('username'),
            'alamat' => $this->request->getVar('alamat'),
            'rt' => $this->request->getVar('rt'),
            'rw' => $this->request->getVar('rw'),
            'saldo' => $this->request->getVar('saldo'),
            'foto' => $namaFoto,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diperbarui, Silahkan Login ulang.');
        return redirect()->to('/logout');
    }


    public function reset($username)
    {
        if (allow('admin')) {
        } else {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Ubah Password',
            'validation' => \Config\Services::validation(),
            'auth' => $this->authModel->getakun($username)
        ];

        return view('akun/edit_pass', $data);
    }

    public function reset_pass($id)
    {
        if (!$this->validate([
            'password' => [
                'rules' => 'required|min_length[6]|max_length[50]',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                    // 'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
        ])) {

            return redirect()->back()->withInput();
        }
        $this->authModel->update($id, ['password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)]);

        session()->setFlashdata('pesan', 'Data berhasil diperbarui.');

        return redirect()->to('/akun');
    }

    public function resetpw($username)
    {
        $data = [
            'title' => 'Ubah Password saya',
            'validation' => \Config\Services::validation(),
            'auth' => $this->authModel->getakun($username)
        ];

        return view('user/reset_pass', $data);
    }

    public function reset_password($id)
    {
        if (!$this->validate([
            'password' => [
                'rules' => 'required|min_length[6]|max_length[50]',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                    // 'is_unique' => '{field} sudah terdaftar.'
                ]
            ],
        ])) {

            return redirect()->back()->withInput();
        }
        $this->authModel->update($id, ['password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)]);

        session()->setFlashdata('pesan', 'Data berhasil diperbarui.');

        return redirect()->to('/user');
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new UserDataModel($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $csrfName = csrf_token();
            $csrfHash = csrf_hash();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $btnDetail = "<a href='" . base_url() . "/akun/detail/$list->username' class=\"btn bg-primary btn-sm text-white me-2\" data-bs-toggle=\"tooltip\" title=\"Lihat Detail\"><i class=\"mdi mdi-eye\"></i></a>";
                $btnTransaksi = "<a href=\"#\" onclick=\"pilihTransaksi(this)\" data-id=\"$list->id\" class=\"btn btn-primary btn-sm me-2\"><i class=\"mdi mdi-swap-horizontal-bold\"></i></a>";
                $btnDelete = "<form action='" . base_url() . "/akun/delete/$list->id' method=\"POST\" class=\"d-inline-block\">
                " . csrf_field() . "
                <input type=\"hidden\" name=\"_method\" value=\"DELETE\">
                <button type=\"submit\" class=\"btn btn-danger text-white btn-sm\" onclick=\"return confirm('Apakah anda yakin menghapus data ini?')\"><i class=\"mdi mdi-delete\"></i></button>
                </form>";
                $btnActive = "<a href=\"#\" value=\"$list->id\" data-bs-toggle=\"tooltip\" onclick=\"active($list->id)\" title=\"Non-Aktifkan\"><i class=\"fa fa-fw fa-power-off text-success fa-lg\"></i></a>";
                $btnNonActive = "<a href=\"#\" onclick=\"nonActive($list->id)\" data-bs-toggle=\"tooltip\" title=\"Aktifkan\"><i class=\"fa fa-fw fa-power-off text-danger fa-lg\"></i></a>";

                $row[] = $no;
                $row[] = ucwords($list->nama);
                $row[] = $list->username;
                $row[] = $list->saldo;
                $row[] = $list->active ? $btnActive : $btnNonActive;
                $row[] = $btnDetail . $btnTransaksi . $btnDelete;
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

    public function toggle()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getPost('id');
            $status = $this->authModel->find($id)['active'];
            $toggle = $status ? 0 : 1;

            $update = $this->authModel->update(['id' => $id], ['active' => $toggle]);

            if ($update)
                echo 'sukses';
            else echo 'gagal';
        } else {
            return redirect()->back();
        }
    }
}
