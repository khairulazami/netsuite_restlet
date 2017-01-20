<?php
/**
 * Netsuite restlets api sample
 * Based on @link http://miftyisbored.com/complete-restful-service-client-cakephp-tutorial/
 */

App::uses('HttpSocket', 'Network/Http');

class ClientsController extends AppController
{

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = [];
    public $components = [
        'Netsuite', 
        'Security', 
        'RequestHandler'
    ];

    public function index()
    {
        
    }

    /**
     * Get response from restlet netsuite.
     * 
     * RESTLet Deployments Term:
     * - DEPLOYED       Yes
     * - STATUS         Released
     * - LOG LEVEL      Debug
     * - Deployment ID  1
     * - Remove other deployment ID, if you have more than one deployment script
     */
    public function request_index()
    {
        $data = [
            'ids' => '260'
        ];
        $scripts = Configure::read('NS_SANBOX_SCRIPT');
        // testing_khairul_script_rst.js
        //$response = $this->Netsuite->restletv1($scripts['testing'], $data);
        $response = $this->Netsuite->restletv1($scripts['attendance'], $data);
        
        $this->set('response_code', $response['code']);
        $this->set('response_header', $response['header']);
        $this->set('response_body', $response['body']);

        $this->render('/Clients/request_response');
    }

    public function request_add()
    {
        $data = [
            'ids' => '1'
        ];

        $scripts = Configure::read('NS_SANBOX_SCRIPT');
        $response = $this->Netsuite->restletv1($scripts['attendance'], $data);

        $this->set('response_code', $response['code']);
        $this->set('response_header', $response['header']);
        $this->set('response_body', $response['body']);

        $this->render('/Clients/request_response');
    }
}
