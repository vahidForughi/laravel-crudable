<?php

namespace Generaltools\Crudable\Controllers;


class AdminController extends Controller
{

    function dashboard()
    {
        return view('crudable.views::dashboard');
    }

}
