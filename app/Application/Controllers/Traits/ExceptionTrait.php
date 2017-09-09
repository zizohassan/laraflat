<?php

namespace App\Application\Controllers\Traits;

use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Alert;

trait ExceptionTrait {

    public function catchExceptions($exception){
        $message = env('APP_ENV') == 'local' ? $exception->getMessage()  : '';
        if($exception instanceof UnauthorizedException) {
            $this->errorMessage( $message, 'Unauthorized Error Occurred !');
            return redirect()->route('Dashboard');
        }
        elseif($exception instanceof InternalErrorException){
            $this->errorMessage($message , 'Internal Error Occurred !');
            return redirect()->back()->withInput();
        }
        $this->errorMessage($message , 'An Error Occurred !');
        return redirect()->back()->withInput();
    }

    protected function doneMessage( $message = "This process done success ." , $title = ""){
        return Alert::success($message , $title);
    }

    protected function errorMessage($message = "This process not complete ." ,  $title = ""){
        return Alert::error($message , $title );
    }

}
