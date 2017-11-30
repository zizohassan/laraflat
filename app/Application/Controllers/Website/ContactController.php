<?php

namespace App\Application\Controllers\Website;

use Alert;
use App\Application\Controllers\AbstractController;
use App\Application\Model\Contact;
use App\Application\Requests\Website\Contact\AddRequestContact;

class ContactController extends AbstractController
{

    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return view('website.contact');
    }

    public function storeContact(AddRequestContact $addRequestContact){
        if(auth()->check()){
            $addRequestContact->request->add(['user_id' => auth()->user()->id]);
        }
        $this->storeOrUpdate($addRequestContact , null);
        alert()->success(trans('website.Your message has Been sent') , trans('website.Success'));
        return redirect()->back();
    }

}
