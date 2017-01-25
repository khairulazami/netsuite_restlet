<?php
/**
 * Netsuite restlets api sample
 * Based on:
 * @link http://miftyisbored.com/complete-restful-service-client-cakephp-tutorial/
 * @link http://blogs.mulesoft.com/dev/anypoint-platform-dev/using-restlet-with-netsuite-connector-guide/
 * 
 */

App::uses('HttpSocket', 'Network/Http');

class GetTrxFromLineItemsController extends AppController
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
    
    public function get_record()
    {
        $data = [
            'internalId' => '626899'
        ];
        $scripts = Configure::read('NS_SANBOX_SCRIPT');
        $response = $this->Netsuite->restletv1($scripts['get_trx_from_line_item'], $data);
        
        $this->set('response_code', $response['code']);
        $this->set('response_method', $response['method']);
        $this->set('response_header', $response['header']);
        $this->set('response_body', $response['body']);

        $this->render('/Elements/request_response');
    }
}
