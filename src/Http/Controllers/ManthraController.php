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
          $fields = $this->merge_fields(request('fields'));

          Artisan::call("manthra:all", [
               'name' => request('model'),
               '--fields' => $fields,
               '--validations' => '',
               '--controller-namespace' => request('controller_namespace'),
               '--model-namespace' => request('model_namespace'),
               '--view-path' => request('view_path'),
               '--route-group' => request('group_group')
          ]);
     }

     private function merge_fields(array $fields): string
     {
          $merge = '';
          foreach ($fields as $field) {
               $merge .= $field['name'] . '#' . $field['type'] . ';';
          }

          return $merge;
     }
}
