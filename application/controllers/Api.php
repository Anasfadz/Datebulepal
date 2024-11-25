<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController as RestServerRestController;
use Restserver\Libraries\RestController;

class Api extends RestServerRestController {
    public function __construct() {
        parent::__construct();
    }

    // Handle GET requests
    public function index_post() {

        $data = 
        ['data' =>
            ['token' => 'HHGGGGDJDJDJIDJDHDH']
        ];
        $this->response($data, RestServerRestController::HTTP_OK);
    }
}
