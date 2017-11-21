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
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];

    }

    public static function exception_handler(\Exception $exception){
        //error_reporting(E_ERROR | E_WARNING | E_PARSE);
        header("Content-Type:". self::$contentType);
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
            $statusCode = 404;
            header(self::$httpVersion. " ". $statusCode ." " . self::getHttpStatusMessage($statusCode));
            echo json_encode([
                'statusCode'=>$statusCode,
                'message'=>'api not found',
                'file'=>'',
                'line'=>'',
                'stackTrace'=>'',
                'error_id'=>'NOT_FOUND'
            ]);die();
        }elseif($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            $statusCode = 405;
            header('HTTP/1.1' . " " . $statusCode . " Method Not Allowed");
            echo json_encode([
                'statusCode' => $statusCode,
                'message' => 'Method Not Allowed',
                'file' => '',
                'line' => '',
                'stackTrace' => '',
                'error_id' => ''
            ]);
            die();
        }else{
            $statusCode = $exception->getCode() == 0 ? 500:$exception->getCode();
            header(self::$httpVersion. " ". $statusCode ." " . self::getHttpStatusMessage($statusCode));
            echo json_encode([
                'statusCode'=>$statusCode,
                'message'=>$exception->getMessage(),
                'file'=>$exception->getFile(),
                'line'=>$exception->getLine(),
                'stackTrace'=>$exception->getTrace(),
                'error_id'=>method_exists($exception,'getErrorId')?$exception->getErrorId():'SEVER_ERROR'
            ]);die();
        }


    }
}
