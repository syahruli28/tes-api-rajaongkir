<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rajaongkir extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('Toko_model');
    }

    private $apiKey = '9640fd39cf7b28a4cc330ee48657c388';

    public  function provinsi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: $this->apiKey"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            $array_response = json_decode($response, true);
            // echo '<pre>';
            // print_r($array_response['rajaongkir']['results']);
            // echo '</pre>';

            $data_provinsi = $array_response['rajaongkir']['results'];
            echo "<option value=''>-- Pilih Provinsi --</option>";
            foreach($data_provinsi as $dp)
            {
                echo "<option value='".$dp['province_id']."' id_provinsi='". $dp['province_id'] ."'>". $dp['province'] ."</option>";
            }
        }
    }

    public function kota()
    {
        $id_provinsi_terpilih = $this->input->post('id_provinsi');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=". $id_provinsi_terpilih,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->apiKey"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            $array_response = json_decode($response, true);

            $data_kota = $array_response['rajaongkir']['results'];
            echo "<option value=''>-- Pilih Kota --</option>";
            foreach($data_kota as $dk)
            {
                echo "<option value='".$dk['city_id']."' id_kota='".$dk['city_id']."' >". $dk['city_name'] ."</option>";
            }
        }

    }

    public function ekspedisi()
    {
        echo '<option value="">--Pilih Ekspedisi--</option>';
        echo '<option value="jne">JNE</option>';
        echo '<option value="tiki">TIKI</option>';
        echo '<option value="pos">POS Indonesia</option>';
    }

    public function paket()
    {
        $id_lok = $this->Toko_model->lokasiId()->lokasi;
        // ambil data yang dikirim dari form pemesanan
        $nama_ekspedisi = $this->input->post('dataekspedisi');
        $id_kota_tujuan = $this->input->post('datakota');
        $toberat = $this->input->post('databerat');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=". $id_lok ."&destination=". $id_kota_tujuan ."&weight=". $toberat ."&courier=". $nama_ekspedisi,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $this->apiKey"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
             // echo $response;
            $array_response = json_decode($response, true);
            // echo '<pre>';
            // print_r($array_response['rajaongkir']['results'][0]['costs']);
            // echo '</pre>';
            $data_paket = $array_response['rajaongkir']['results'][0]['costs'];
            echo "<option value=''>--Pilih Paket--</option>";
            foreach ( $data_paket as $key => $value) {
                echo "<option value='". $value['service'] ."' ongkir='". $value['cost'][0]['value'] ."' >";
                echo $value['service'] .' | Rp. '. number_format($value['cost'][0]['value'],0,',','.') .' | Estimasi pengiriman '. $value['cost'][0]['etd'] .' hari ';
                echo "</option>";
            }
        }
    }

}