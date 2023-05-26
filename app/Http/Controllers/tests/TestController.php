<?php

namespace App\Http\Controllers\tests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TestController extends Controller
{
    public function testPage(){
        //we can return a view using a controller --therefore we need to create our view....
        //we can do some logic of data and pass it to the fron view--what we cant user to see
        $date = Carbon::now(); //sorry i did not import Carbon package...
        
        //we have a variable date we can make it available to the front side by passing it
        //Yes and that's how you create the page from route->controller->view
        //route calls method in controller, contoller call a view, thus the browser renders the view when you visit a certain route/url
        return view('tests.test-page-render',[
          'leo' => $date //this view will be rendered with the varaible available //you can always use any alias name, so long as you call it exactly the same in view
        ]); //path of your view //you notice here we use dot '.' instead of slash(/) to indicate path
    }
}
