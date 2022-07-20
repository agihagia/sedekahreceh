<?php

namespace App\Controllers;

use App\Libraries\Settings;
use App\Models\SedekahModel;
use App\Models\FaqModel;

class Home extends BaseController
{
	public function __construct()
	{
		$this->sedekahModel = new SedekahModel();
		$this->setting = new Settings();
		$this->faqModel = new FaqModel();
	}

	public function index()
	{
		$showLimit = 4;

		$data = [
			'appname' => $this->setting->info['app_name'],
			'sitetitle' => 'Home | ' . $this->setting->info['site_title'],
			'brand' => $this->setting->info['site_title'] . " v" . $this->setting->info['app_version'],
			'instansi' => $this->setting->info['nama_instansi'],
			'alamat' => $this->setting->info['alamat_instansi'],
			'telpon' => $this->setting->info['telp_instansi'],
			'email' => $this->setting->info['email_instansi'],
			'maps' => $this->setting->info['maps_instansi'],
			'instagram' => $this->setting->info['instagram'],
			'instagram2' => $this->setting->info['instagram2'],
			'jenissedekah' => $this->sedekahModel->loadmoresedekah('', $showLimit),
			'faqs' => $this->faqModel->asObject()->findAll(),
		];
		return view('home', $data);
	}

	public function loadmore()
	{
		if ($this->request->getVar('id')) {
			$csrfName = csrf_token();
			$csrfHash = csrf_hash();

			$showLimit = 4;
			$id = $this->request->getVar('id');

			$totalRowCount = $this->sedekahModel->countLoadmoresedekah($id);
			$sedekah = $this->sedekahModel->loadmoresedekah($id, $showLimit);

			$data = [
				'total' => $totalRowCount,
				'limit' => $showLimit,
				'jenissedekah' => $sedekah
			];
			$data[$csrfName] = $csrfHash;
			return view('load_more', $data);
		}
	}
}
