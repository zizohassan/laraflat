<?php

namespace  App\Application\Controllers\Traits;

trait HelpersTrait{

    protected function checkIfArray($request){
        return is_array($request) ? $request : [$request];
    }

    protected function createLog($action , $status , $messages = ''){
        $data = [
            'action' => $action,
            'model' => $this->model->getTable(),
            'status' => $status,
            'user_id' => auth()->check() ? auth()->user()->id : 0,
            'messages' => $messages
        ];
        $this->log->create($data);
    }

}