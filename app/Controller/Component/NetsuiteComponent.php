<?php

class NetsuiteComponent extends Component
{
    function callNetsuiteRestlet($scriptId, $vars)
    {
        if (Configure::read('CURRENT_ENV') == 'sandbox') {
            $nsRestHost = 'https://rest.sandbox.netsuite.com';
        } elseif (Configure::read('CURRENT_ENV') == 'production') {
            $nsRestHost = 'https://rest.netsuite.com';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, ($nsRestHost . "/app/site/hosting/restlet.nl?script=$scriptId&deploy=1"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $headers = array();
        if (Configure::read('CURRENT_ENV') == 'sandbox') {
            $headers[] = 'Authorization: NLAuth nlauth_account='.Configure::read('NS_SANDBOX_ACCOUNT').',nlauth_email='.Configure::read('NS_SANDBOX_EMAIL').',nlauth_signature='.Configure::read('NS_SANDBOX_SIGNATURE').',nlauth_role='.Configure::read('NS_SANDBOX_AUTHROLE');
        } elseif (Configure::read('CURRENT_ENV') == 'production') {
            $headers[] = 'Authorization: NLAuth nlauth_account='.Configure::read('NS_PRODUCTION_ACCOUNT').',nlauth_email='.Configure::read('NS_PRODUCTION_EMAIL').',nlauth_signature='.Configure::read('NS_PRODUCTION_SIGNATURE').',nlauth_role='.Configure::read('NS_PRODUCTION_AUTHROLE');
        }

        $headers[] = 'Content-Type: application/json;';
        $headers[] = 'User-Agent-x: SuiteScript-Call';

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $retry_limit = 10;
        $status = FALSE;

        for ($i = 0 ; $i < $retry_limit ; $i++) {
            try {
                $server_output = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpcode != 400) {
                    $status = TRUE;
                    break;
                }
            } catch (Exception $ex) {
                $code = $ex->getCode();
                $errmessage = $ex->getMessage();
                if ($code == 'SSS_REQUEST_LIMIT_EXCEEDED' || $errmessage == 'SSS_REQUEST_LIMIT_EXCEEDED') {
                    // retry until reach the limit
                }
            }
        }

        curl_close($ch);

        if ($status == TRUE) {
            if ($server_output !== FALSE) {
                $server_output = json_decode($server_output, TRUE);
                if ($server_output['status'] == 'success' || $server_output['status'] == 'error') {
                    return $server_output;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}
