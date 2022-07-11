<?php

namespace App\Controllers;



use App\Libraries\Settings;
use App\Models\AuthModel;

class Auth extends BaseController
{
    protected $authModel;
    protected $setting;

    public function __construct()
    {
        $this->authModel = new AuthModel();
        $this->setting = new Settings();
    }

    public function index()
    {
        $data = [
            'appname' => $this->setting->info['app_name'],
			'sitetitle' => 'Login | ' . $this->setting->info['site_title'],
            'brand' => $this->setting->info['site_title']." v".$this->setting->info['app_version'],
            'instansi' => $this->setting->info['nama_instansi'],
            'alamat' => $this->setting->info['alamat_instansi'],
        ];
        return view('auth/login', $data);
    }

    public function login()
    {
        $input = $this->request->getVar();
        $remember = $this->request->getVar('remember');
        $data = $this->authModel->where('username', $input['username'])->first();
 
        if ($data) {
            if (password_verify($input['password'], $data['password'])) {
                if ($data['active'] != 1 || $data['active'] == null ) {
                    session()->setFlashdata('pesan', 'Akun belum aktif atau dinon-aktifkan!');
                    return redirect()->back()->withInput();
                } else {
                    $data_session = [
                        'logged_in' => TRUE,
                        'id' => $data['id'],
                        'nama' => $data['nama'],
                        'username' => $data['username'],
                        'rt' => $data['rt'],
                        'rw' => $data['rw'],
                        'foto' => $data['foto'],
                        'level' => $data['level'],
                        'saldo' => $data['saldo'],
                    ];

                    if ($remember != null) {
                    }

                    session()->set($data_session);
                    set_cookie('login', 'ok', time() + 60);
                    session()->setFlashdata('pesan', 'Anda telah login');
                    return redirect()->to('/dashboard');
                }
            } else {
                session()->setFlashdata('pesan', 'Password salah!');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('pesan', 'Username tidak terdaftar');
            return redirect()->back()->withInput();
        }
    }

    public function register()
    {
        $data = [
            'appname' => $this->setting->info['app_name'],
			'sitetitle' => 'Register | ' . $this->setting->info['site_title'],
            'brand' => $this->setting->info['site_title']." v".$this->setting->info['app_version'],
            'instansi' => $this->setting->info['nama_instansi'],
            'alamat' => $this->setting->info['alamat_instansi'],
            'validation' => \Config\Services::validation()
        ];
        return view('auth/register', $data);
    }

    public function save_register()
    {
        // validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Field {field} harus diisi!',
                    'is_unique' => 'Field {field} sudah terdaftar.'
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
            return redirect()->to('/register')->withInput();
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

        session()->setFlashdata('sukses', 'Pendaftaran Akun berhasil, silahkan Login.');

        return redirect()->to('/login');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
