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
          dd(Artisan::call('manthra:all ' . request('model_name'), []));
          return 'Store controller';
     }
}
