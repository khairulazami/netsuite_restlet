<?php

class NetsuiteComponent extends Component
{
    function restletv1($scriptId, $vars, $action = 'get')
    {
        if (Configure::read('CURRENT_ENV') == 'sandbox') {
            $nsRestHost = 'https://rest.sandbox.netsuite.com';
        } elseif (Configure::read('CURRENT_ENV') == 'production') {
            $nsRestHost = 'https://rest.netsuite.com';
        }

        $ch = curl_init();
        $params = NULL;
        $method = NULL;
        
        switch ($action) {
            case 'create':
                $method = 'POST';
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars));  //Post Fields
                break;
            case 'delete':
                $method = 'DELETE';
                break;
            case 'update':
                $method = 'PUT';
                break;
            default:
                $method = 'GET';
                if (!empty($vars)) {
                    $params = '&'.http_build_query($vars);
                }
        }

        curl_setopt($ch, CURLOPT_URL, ($nsRestHost . "/app/site/hosting/restlet.nl?script=$scriptId&deploy=1".$params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $headers = [];
        if (Configure::read('CURRENT_ENV') == 'sandbox') {
            $headers[] = 'Authorization: NLAuth nlauth_account='.Configure::read('NS_SANDBOX_ACCOUNT').',nlauth_email='.Configure::read('NS_SANDBOX_EMAIL').',nlauth_signature='.Configure::read('NS_SANDBOX_SIGNATURE').',nlauth_role='.Configure::read('NS_SANDBOX_AUTHROLE');
        } elseif (Configure::read('CURRENT_ENV') == 'production') {
            $headers[] = 'Authorization: NLAuth nlauth_account='.Configure::read('NS_PRODUCTION_ACCOUNT').',nlauth_email='.Configure::read('NS_PRODUCTION_EMAIL').',nlauth_signature='.Configure::read('NS_PRODUCTION_SIGNATURE').',nlauth_role='.Configure::read('NS_PRODUCTION_AUTHROLE');
        }

        $headers[] = 'Content-Type: application/json;';
        $headers[] = 'User-Agent-x: SuiteScript-Call';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $retry_limit = 10;
        $response = [];

        for ($i = 0 ; $i < $retry_limit ; $i++) {
            try {
                $server_output = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($server_output, 0, $header_size);
                $body = substr($server_output, $header_size);
                $response['code'] = $httpcode;
                $response['method'] = $method;
                $response['header'] = $header;
                $response['body'] = $body;
                if ($httpcode != 400) {
                    break;
                }
            } catch (Exception $ex) {
                $code = $ex->getCode();
                $errmessage = $ex->getMessage();
                $response['code'] = $code;
                $response['method'] = $method;
                $response['header'] = '-';
                $response['body'] = $errmessage;
            }
        }

        curl_close($ch);
        
        return $response;
    }

    function restletv2($scriptId, $vars)
    {
        // example: https://rest.sandbox.netsuite.com/app/site/hosting/restlet.nl?script=656&deploy=1

        $httpSocket = new HttpSocket(['ssl_verify_host' => false]);

        if (Configure::read('CURRENT_ENV') == 'sandbox') {
            $nsRestHost = 'https://rest.sandbox.netsuite.com';
        } elseif (Configure::read('CURRENT_ENV') == 'production') {
            $nsRestHost = 'https://rest.netsuite.com';
        }

        if (Configure::read('CURRENT_ENV') == 'sandbox') {
            /*$authorization = [
                'NLAuth nlauth_account' => Configure::read('NS_SANDBOX_ACCOUNT'), 
                'nlauth_email' => Configure::read('NS_SANDBOX_EMAIL'),
                'nlauth_signature' => Configure::read('NS_SANDBOX_SIGNATURE'),
                'nlauth_role' => Configure::read('NS_SANDBOX_AUTHROLE')
            ];*/
            $authorization = 'NLAuth nlauth_account='.Configure::read('NS_SANDBOX_ACCOUNT').',nlauth_email='.Configure::read('NS_SANDBOX_EMAIL').',nlauth_signature='.Configure::read('NS_SANDBOX_SIGNATURE').',nlauth_role='.Configure::read('NS_SANDBOX_AUTHROLE');
        } elseif (Configure::read('CURRENT_ENV') == 'production') {
            /*$authorization = [
                'NLAuth nlauth_account' => Configure::read('NS_PRODUCTION_ACCOUNT'),
                'nlauth_email' => Configure::read('NS_PRODUCTION_EMAIL'),
                'nlauth_signature' => Configure::read('NS_PRODUCTION_SIGNATURE'),
                'nlauth_role' => Configure::read('NS_PRODUCTION_AUTHROLE')
            ];*/
            $authorization = 'NLAuth nlauth_account='.Configure::read('NS_PRODUCTION_ACCOUNT').',nlauth_email='.Configure::read('NS_PRODUCTION_EMAIL').',nlauth_signature='.Configure::read('NS_PRODUCTION_SIGNATURE').',nlauth_role='.Configure::read('NS_PRODUCTION_AUTHROLE');
        }

        $request = [
            'header' => [
                'Authorization' => $authorization,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent-x' => 'SuiteScript-Call'
            ]
        ];

        $response = $httpSocket->post($nsRestHost . "/app/site/hosting/restlet.nl?script=$scriptId&deploy=1", $vars, $request);

        return $response;
    }
}
