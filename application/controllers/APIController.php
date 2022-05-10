<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class APIController extends CI_Controller {

    public function __construct(){
		
        parent::__construct();

        $this->load->model("BatchFiles");
        $this->load->model("BatchRecords");
    }
    
    public function refGenerate() {
        echo refGenerate();
    }

    public function payUpdate() {
        if(isset($_POST['BatchNumber'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'BatchNumber empty'
            ));

            return;
        }

        if(isset($_POST['BatchStatus'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'BatchStatus empty'
            ));

            return;
        }

        if(isset($_POST['statusCode'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'statusCode empty'
            ));

            return;
        }

        if(isset($_POST['txnReferences'])) {
            echo json_encode(array(
                'success' => false,
                'message' => 'txnReferences empty'
            ));

            return;
        }

        $this->BatchFiles->updateApiResult(array(
            'batch_number' => $_POST['BatchNumber'],
            'status' => $_POST['statusCode'] == '77' ? 2 : 1,
        ));

        $txnReferences = $_POST['txnReferences'];
        foreach($txnReferences as $txnReference) {
            // $this->BatchRecords->updateApiResult(array(
            //     'batch_number' => $_POST['BatchNumber'],
            //     'status' => $_POST['statusCode'] == '77' ? 2 : 1,
            // ));
        }
    }
}