<?php 

class Barang_model extends CI_Model {

    // private $idToko = 1;

    public function getDataBarang()
    {
	    return $this->db->get('tb_barang')->result_array();
    }

    public function find($id)
    {
        $hasil = $this->db->where('id_barang', $id)
                            ->limit(1)
                            ->get('tb_barang');
        if($hasil->num_rows() > 0){
            return $hasil->row();
        }else{
            return array();
        }
    }

    public function getBarangById($id)
	{
	    return $this->db->get_where('tb_barang', ['id_barang' => $id])->row_array();
    }

}