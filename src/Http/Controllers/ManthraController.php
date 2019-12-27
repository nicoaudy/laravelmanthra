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
        $validations = $this->merge_validations(request('fields'));

        if (in_array('web', request('generate_type')) && in_array('api', request('generate_type'))) {
            Artisan::call("manthra:complete", [
                    'name' => request('model'),
                    '--fields' => $fields,
                    '--validations' => $validations,
                    '--controller-namespace' => request('controller_namespace'),
                    '--model-namespace' => request('model_namespace'),
                    '--view-path' => request('view_path'),
                    '--route-group' => request('group_group')
               ]);
        } elseif (in_array('web', request('generate_type'))) {
            Artisan::call("manthra:web", [
                    'name' => request('model'),
                    '--fields' => $fields,
                    '--validations' => $validations,
                    '--controller-namespace' => request('controller_namespace'),
                    '--model-namespace' => request('model_namespace'),
                    '--view-path' => request('view_path'),
                    '--route-group' => request('group_group')
               ]);
        } elseif (in_array('api', request('generate_type'))) {
            Artisan::call("manthra:api", [
                    'name' => request('model'),
                    '--fields' => $fields,
                    '--validations' => $validations,
                    '--controller-namespace' => request('controller_namespace'),
                    '--model-namespace' => request('model_namespace'),
                    '--route-group' => request('group_group')
               ]);
        } else {
            return;
        }
    }

    private function merge_fields(array $fields): string
    {
        $merge = '';
        foreach ($fields as $field) {
            $merge .= $field['name'] . '#' . $field['type'] . ($field['nullable'] ? '#nullable' : null) . ';';
        }

        return $merge;
    }

    private function merge_validations(array $validations): string
    {
        $merge = '';
        foreach ($validations as $field) {
            if ($field['validation']) {
                $merge .= $field['name'] . '#' . $field['validation'] .';';
            }
        }

        return $merge;
    }
}
