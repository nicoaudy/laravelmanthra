<?php

namespace NicoAudy\LaravelManthra\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class ManthraController extends Controller
{
     public function index()
     {
          return view('manthra::manthra-index');
     }

     public function store()
     {
          $modelName = request('model');
          $fields = request('fields');

          dd();

          // $implode = implode('#', $fields);

          Artisan::call("manthra:all $modelName", [
               '--fields' => ''
          ]);
     }
}
