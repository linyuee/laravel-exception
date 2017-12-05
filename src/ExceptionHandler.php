<?php
namespace Linyuee;
/**
 *
 */
class ExceptionHandler
{

    static $httpVersion = "HTTP/1.1";
    static $contentType = 'application/json';
    public function __construct()
    {
    }
    public static function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return isset($httpStatus[$statusCode])?$httpStatus[$statusCode]:$httpStatus[500];

    }

    public static function exception_handler(\Exception $exception){
        header("Content-Type:". self::$contentType);
        $statusCode = method_exists($exception,'getStatusCode')?$exception->getStatusCode():$exception->getCode();
        header(self::$httpVersion. " ". ($statusCode = $statusCode == 0? 500 : $statusCode) ." " . self::getHttpStatusMessage($statusCode));
        $response = array(
            'data'=>[],
            'status_code'=>$statusCode == 0?500:$statusCode,
            'error_msg'=>$exception->getMessage(),
            'error_code'=>method_exists($exception,'getErrorId')?$exception->getErrorId():self::getHttpStatusMessage($statusCode),
        );
        if (env('APP_DEBUG')){
            $response = array_merge($response,array('debug'=>array(
                'file'=>$exception->getFile(),
                'line'=>$exception->getLine(),
                'trace'=>$exception->getTrace(),
                'type'=>get_class($exception)
            )));
        }
        echo json_encode($response);die();

    }
}
