<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Barang extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Barang_model', 'barang');
    }

    public function index_get()
    {
        $id = $this->get('kode');
        if ($id === null) {
            $barang = $this->barang->getBarang();
        } else {
            $barang = $this->barang->getBarang($id);
        }

        if ($barang) {
            $this->response([
                'status' => true,
                'data' => $barang
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('kode');
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an kode!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->barang->deleteBarang($id) > 0) { //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data barang has been deleted!'
                ], REST_Controller::HTTP_OK);
            } else {
                //id not found
                $this->response([
                    'status' => false,
                    'message' => 'kode not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'kode' => $this->post('kode'), 
            'nama_barang' => $this->post('nama'), 
            'jenis' => $this->post('jenis'),
            'harga' => $this->post('harga'),
            'stok' => $this->post('stok')
        ];
        if ($this->barang->createBarang($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new barang has been created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('kode');
        $data = [
            'kode' => $this->put('kode'), 
            'nama_barang' => $this->put('nama'), 
            'jenis' => $this->put('jenis'),
            'harga' => $this->put('harga'),
            'stok' => $this->put('stok')
        ];
        if ($this->barang->updateBarang($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data barang has been updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to update new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
