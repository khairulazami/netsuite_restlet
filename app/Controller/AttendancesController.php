<?php
/**
 * Netsuite restlets api sample
 * Based on:
 * @link http://miftyisbored.com/complete-restful-service-client-cakephp-tutorial/
 * @link http://blogs.mulesoft.com/dev/anypoint-platform-dev/using-restlet-with-netsuite-connector-guide/
 * 
 */

App::uses('HttpSocket', 'Network/Http');

class AttendancesController extends AppController
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
    public function get_record()
    {
        $data = [
            //'ids' => '1'
        ];
        $scripts = Configure::read('NS_SANBOX_SCRIPT');
        // testing_khairul_script_rst.js
        //$response = $this->Netsuite->restletv1($scripts['testing'], $data);
        $response = $this->Netsuite->restletv1($scripts['attendance'], $data);
        
        $this->set('response_code', $response['code']);
        $this->set('response_method', $response['method']);
        $this->set('response_header', $response['header']);
        $this->set('response_body', $response['body']);

        $this->render('/Elements/request_response');
    }

    public function create_record()
    {
        if (!empty($this->request->data)) {
            $data = [
                'custrecordtest_attendance_employee_id' => $this->request->data['Attendance']['employee_id'],
                'custrecordtest_attendance_employee_name' => $this->request->data['Attendance']['employee_name'],
                'custrecordtest_attendance_check_in' => $this->request->data['Attendance']['check_in'],
                'custrecordtest_attendance_check_out' => $this->request->data['Attendance']['check_out']
            ];

            $scripts = Configure::read('NS_SANBOX_SCRIPT');
            $response = $this->Netsuite->restletv1($scripts['attendance'], $data, 'create');

            $this->set('response_code', $response['code']);
            $this->set('response_method', $response['method']);
            $this->set('response_header', $response['header']);
            $this->set('response_body', $response['body']);

            $this->render('/Elements/request_response');
        }
    }

    public function delete_record()
    {
        $data = [
            'ids' => '3'
        ];
        $scripts = Configure::read('NS_SANBOX_SCRIPT');
        $response = $this->Netsuite->restletv1($scripts['attendance'], $data, 'delete');

        $this->set('response_code', $response['code']);
        $this->set('response_method', $response['method']);
        $this->set('response_header', $response['header']);
        $this->set('response_body', $response['body']);

        $this->render('/Elements/request_response');
    }
}
