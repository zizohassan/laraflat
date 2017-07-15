<?php

namespace App\Application\Controllers\Traits;

use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Alert;

trait ExceptionTrait {

    public function catchExceptions($exception){
        if($exception instanceof UnauthorizedException) {
            $this->errorMessage('Unauthorized Error Occurred !');
            return redirect()->route('Dashboard');
        }
        elseif($exception instanceof InternalErrorException){
            $this->errorMessage('Internal Error Occurred !');
            return redirect()->back();
        }
        $this->errorMessage('An Error Occurred !');
        return redirect()->back();
    }

    protected function doneMessage( $message = "This process done success ." , $title = ""){
        return Alert::success($message , $title);
    }

    protected function errorMessage($message = "This process not complete ." ,  $title = ""){
        return Alert::error($message , $title );
    }

}