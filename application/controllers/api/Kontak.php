<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Kontak extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Kontak_model', 'contacts');
    }

    // Simpan parameternya di params
    public function index_get()
    {
        $id = $this->get('id');

        if ($id === NULL) {
            $contacts = $this->contacts->getKontak();
        }else {
            $contacts = $this->contacts->getKontak($id);
        }

        if ($contacts) {
            $this->response([
                'status' => true,
                'data' => $contacts
            ], REST_Controller::HTTP_OK); 
        }else {
            $this->response([
                'status' => false,
                'message' => 'Id not found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    // Simpan parameternya di body www-form-url
    public function index_delete()
    {
        $id = $this->delete('id');

        if($id === NULL) {
            $this->response([
                'status' => false,
                'message' => 'Provide non id'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }else {
            if($this->contacts->deleteKontak($id) > 0) {
                $this->response([
                    'status' => true,
                    'data' => $id,
                    'message' => 'Deleted!'
                ], REST_Controller::HTTP_NO_CONTENT); 
            }else {
                $this->response([
                    'status' => false,
                    'message' => 'Id not found'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }
    }

    // Simpan parameternya di body www-form-url
    public function index_post()
    {
        $data = [
            'nama_kontak' => $this->post('namaKontak'),
            'nomor' => $this->post('nomor')
        ];

        if ($this->contacts->createNewKontak($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'New data has been created'
            ], REST_Controller::HTTP_CREATED); 
        }else {
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    // Simpan parameternya di body www-form-url beserta idnya apa
    public function index_put() 
    {
        $id = $this->put('id');

        $data = [
            'nama_kontak' => $this->put('namaKontak'),
            'nomor' => $this->put('nomor')
        ];

        if ($this->contacts->updateKontak($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data has been updated'
            ], REST_Controller::HTTP_NO_CONTENT); 
        }else {
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

}
