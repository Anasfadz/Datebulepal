<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController as RestServerRestController;
use Restserver\Libraries\RestController;

class Api extends RestServerRestController {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    // Handle GET requests

    public function index_get() {

        $data = 
        ['data' =>
            ['token' => 'HHGGGGDJDJDJIDJDHDH']
        ];
        $this->response($data, RestServerRestController::HTTP_OK);
    }

    public function index_post() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->response([
                'status' => false,
                'message' => 'Name and email are required'
            ], RestServerRestController::HTTP_BAD_REQUEST);
            return;
        }

        // Retrieve POST data
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate input
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('email', 'Email','required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Process the data (e.g., save to database)
        $email = $data['email'];
        $password = $data['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->response([
                'status' => false,
                'message' => 'Invalid email format'
            ], RestServerRestController::HTTP_BAD_REQUEST);
            return;
        }

        //validate email
        if ($this->form_validation->run() == FALSE) {

            $this->response([
                'status' => false,
                'message' => 'email and password are required'
            ], RestServerRestController::HTTP_BAD_REQUEST);
            return;
        }

        if($email != "anas@gmail.com" || $password != "123")
        {
            $this->response([
                'status' => false,
                'message' => 'Username or password is false'
            ], RestServerRestController::HTTP_BAD_REQUEST);
            return;

        }

        // Respond with success
        $this->response(
            ['data' => [
                'status' => true,
                'token' => 'anasloginqwerty',
                'message' => 'Data received successfully'],
                'details' =>  compact('name', 'email'),
            ], 
            RestServerRestController::HTTP_OK);
        return;
    }
}
