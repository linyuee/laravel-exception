###基于laravel框架的自定义异常模块
laravel框架是近两年兴起的一个框架，但是有一个很蛋疼的问题，laravel的异常和错误都会被渲染成一个html网页输出，这样前端
很难解析，因此我封装了一个自定义异常模块，可以让laravel框架的异常很报错全部以统一的json格式输出。
#####使用教程
1、使用composer下载这个包
```angular2html
composer require linyuee/laravel-exception
```
2、在laravel框架的app\Exceptions\Handler.php文件中引入

修改app\Exceptions\Handler.php的report方法
```angular2html
public function report(Exception $exception)
    {
        //parent::report($exception);
        \Linyuee\ExceptionHandler::exception_handler($exception);

    }
```