<?php

namespace App\Controllers;



use App\Libraries\Settings;
use App\Models\DashboardModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
    protected $setting;
    protected $dashboardModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->setting = new Settings();
        $this->dashboardModel = new DashboardModel();
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $id_user = session('id');
        $data = [
            'title' => 'Dashboard',
            'jmlTrMasuk' => $this->transaksiModel->where(['jenis_transaksi' => 'masuk', 'id_user' => $id_user])->countAllResults(),
            'jmlTrKeluar' => $this->transaksiModel->where(['jenis_transaksi' => 'keluar', 'id_user' => $id_user])->countAllResults(),
        ];
        $data['total_transaction']  = $this->dashboardModel->getCountTrx();
        $data['total_product']      = $this->dashboardModel->getCountProduct();
        $data['total_category']     = $this->dashboardModel->getCountCategory();
        $data['total_user']         = $this->dashboardModel->getCountUser();

        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['transaksi'] = [];
        foreach ($bln as $b) {
            $date = date('Y-') . $b;
            $data['transaksi'][] = $this->dashboardModel->chartTransaksi($date);
        }

        $jam = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '00'];
        $data['jam'] = [];
        foreach ($jam as $j) {
            $date = date('Y-m-d') . ' ' . $j;
            $data['harian'][] = $this->dashboardModel->chartHarian($date);
        }

        $tgl = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $data['tgl'] = [];
        foreach ($tgl as $t) {
            $date = date('Y-m-') . $t;
            $data['pemasukan'][] = $this->dashboardModel->chartPemasukan($date);
        }

        return view('dashboard/dashboard', $data);
    }
}
