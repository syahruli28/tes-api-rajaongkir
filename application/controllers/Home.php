<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('Toko_model');
		$this->load->model('Barang_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

    public function index()
	{
        $data['judul'] = 'Halaman Home';

		$this->load->view('templates/header', $data);
		$this->load->view('home/v_home');
		$this->load->view('templates/footer');
    }
    
    public function settingLokasi()
    {
        $data['judul'] = 'Halaman Setting Lokasi';
        $data['toko'] = $this->Toko_model->getDataToko();

        // form validation
		$this->form_validation->set_rules('lokasitoko', 'Lokasi Toko', 'required|numeric');

        if ($this->form_validation->run() == FALSE ) {
            $this->load->view('templates/header', $data);
            $this->load->view('home/v_slokasi', $data);
            $this->load->view('templates/footer');
        }else{
            $this->Toko_model->ubahDataToko();
			// // flashdata
			// $this->session->set_flashdata('msg-success', 'Diubah');
			redirect('home/settingLokasi');
        }
    }

    public function tampilkanBarang()
    {
        $data['judul'] = 'Halaman Barang';
        $data['barang'] = $this->Barang_model->getDataBarang();

        $this->load->view('templates/header', $data);
		$this->load->view('home/v_barang', $data);
		$this->load->view('templates/footer');

    }

    public function halamanKeranjang()
	{
		// $this->load->model('Admin_model');
        $data['judul'] = 'Keranjang Belanja';
		$data['barang'] = $this->Barang_model->getDataBarang();
		$this->load->view('templates/header', $data);
		$this->load->view('home/v_keranjang-belanja', $data);
		$this->load->view('templates/footer');
    }

    public function tambah_ke_keranjang($id)
	{
		$barang = $this->Barang_model->find($id);
		$data = array(
			'id'		=>	$barang->id_barang,
			'qty'		=>	1,
			'price'		=>	$barang->harga_barang,
			'name'		=>	$barang->nama_barang
			// 'options'	=>	array( 'berat' => $barang->berat_barang )
		);
		$this->cart->insert($data);
		redirect('Home/tampilkanBarang');
	}

    public function hapusKeranjang()
	{
		$this->cart->destroy();
		redirect('Home/tampilkanBarang');
	}

	public function hapussb($rowid)
	{
		$this->cart->remove($rowid);
		redirect('home/halamanKeranjang');
	}

	public function updatecart()
	{
		$i = 1;
		foreach($this->cart->contents() as $item ) {
			$data = array(
				'rowid' => $item['rowid'],
				'qty' => $this->input->post($i . '[qty]'),
			);
			$this->cart->update($data);
			$i++;
		}
		redirect('Home/halamanKeranjang');

	}

	public function formPemesanan()
	{
		$data['judul'] = 'Halaman pemesanan';
		$data['barang'] = $this->Barang_model->getDataBarang();
		$this->load->view('templates/header', $data);
		$this->load->view('home/v_formpemesanan', $data);
		$this->load->view('templates/footer');
	}

}