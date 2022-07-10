<?php
class BaseController
{
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
 
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
 
        return $uri;
    }
 
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }
 
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
 
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data;

        exit;
    }

    protected function ok($data)
    {
        header_remove('Set-Cookie');

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');

        echo json_encode($data);

        exit;
    }

    protected function notFound($data)
    {
        header_remove('Set-Cookie');

        header('Content-Type: application/json');
        header('HTTP/1.1 405 Method Not Allowed');

        echo $data;

        exit;
    }

    protected function serverError($data)
    {
        header_remove('Set-Cookie');

        header('Content-Type: application/json');
        header('HTTP/1.1 500 Internal Server Error');

        echo $data;

        exit;
    }

}