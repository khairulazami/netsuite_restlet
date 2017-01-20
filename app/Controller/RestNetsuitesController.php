<?php
/**
 * Netsuite restlets api sample
 * Based on @link http://miftyisbored.com/complete-restful-service-client-cakephp-tutorial/
 */

App::uses('AppController', 'Controller');

class RestNetsuitesController extends AppController
{

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = [];
    public $helpers = ['Html', 'Form'];
    public $components = [
        'Netsuite', 
        'RequestHandler'
    ];

    public function index()
    {
        $data = [
            0 => [
                'id' => 1,
                'test' => 'abc'
            ],
            1 => [
                'id' => 2,
                'test' => 'def'
            ],
            2 => [
                'id' => 3,
                'test' => 'ghi'
            ],
        ];

        $this->set([
            'data' => json_encode($data),
            '_serialize' => json_encode(['data'])
        ]);
    }
}
