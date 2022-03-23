<?php 

class Toko_model extends CI_Model {

    private $idToko = 1;

    public function getDataToko()
    {
	    return $this->db->get('tb_setting_lokasi')->result_array();
    }

	public function lokasiId()
	{
		$this->db->select('*');
		$this->db->from('tb_setting_lokasi');
		$this->db->where('id_lokasi', 1);
		return $this->db->get()->row();
	}

    public function ubahDataToko()
	{

		$namaToko = htmlspecialchars($this->input->post('namatoko'));
		$lokasiToko = htmlspecialchars($this->input->post('lokasitoko'));
		$alamatToko = htmlspecialchars($this->input->post('alamattoko'));
		$noTelp	= $this->input->post('notelp');
		
		$data = array(
			'nama_toko'			=> $namaToko,
			'lokasi'			=> $lokasiToko,
			'alamat_toko'		=> $alamatToko,
			'no_telpon'			=> $noTelp,
		);

		// print_r($data);die;
		$this->db->where('id_lokasi', $this->idToko);
		$this->db->update('tb_setting_lokasi', $data);
	}

}