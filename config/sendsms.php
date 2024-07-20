<?php
class SMS {
    public function sendSMS($to, $message) {
    require_once 'HTTP/Request2.php';
    $request = new HTTP_Request2();
    $request->setUrl('https://y3zq8j.api.infobip.com/sms/2/text/advanced');
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setConfig(array(
        'follow_redirects' => true
    ));
    $request->setHeader(array(
        'Authorization' => 'App 2f06cf3eb14d2aa6c59288765bd7da16-2552b2f4-146d-4e3c-b50f-b45b2d3d3573',
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ));
    $request->setBody('{"messages":[{"destinations":[{"to":"'.$to.'"}],"from":"ServiceSMS","text":"'.$message.'"}]}');
    try {
        $response = $request->send();
        if ($response->getStatus() == 200) {
            return true;
        }
        else {
            return false;
        }
    }
    catch(HTTP_Request2_Exception $e) {
        return false;
    }
}
}