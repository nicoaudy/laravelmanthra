<?php

namespace NicoAudy\LaravelManthra\Commands;

use File;
use Illuminate\Console\Command;

class GenerateApiCommand extends Command
{
    protected $signature = 'manthra:api
                            {name : The name of the Crud.}
                            {--fields= : Fields name for the form & migration.}
                            {--validations= : Validation details for the fields.}
                            {--controller-namespace= : Namespace of the controller.}
                            {--model-namespace= : Namespace of the model inside "app" dir.}
                            {--pk=id : The name of the primary key.}
                            {--pagination=25 : The amount of models per page for index pages.}
                            {--indexes= : The fields to add an index to.}
                            {--foreign-keys= : The foreign keys for the table.}
                            {--relationships= : The relationships for the model.}
                            {--route=yes : Include Crud route to routes.php? yes|no.}
                            {--route-group= : Prefix of the route group.}
                            {--localize=no : Allow to localize? yes|no.}
                            {--locales=en : Locales language type.}';

    protected $description = 'Generate Crud API including controller, model & migrations.';
    protected $routeName = '';
    protected $controller = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $modelName = str_singular($name);
        $migrationName = str_plural(snake_case($name));
        $tableName = $migrationName;

        $routeGroup = $this->option('route-group');
        $this->routeName = ($routeGroup) ? $routeGroup . '/' . snake_case($name, '-') : snake_case($name, '-');
        $perPage = intval($this->option('pagination'));
        $controllerNamespace = ($this->option('controller-namespace')) ? $this->option('controller-namespace') . '\\' : '';

        $modelNamespace = ($this->option('model-namespace')) ? trim($this->option('model-namespace')) . '\\' : '';
        $fields = rtrim($this->option('fields'), ';');
        $primaryKey = $this->option('pk');
        $foreignKeys = $this->option('foreign-keys');
        $fieldsArray = explode(';', $fields);
        $fillableArray = [];
        foreach ($fieldsArray as $item) {
            $spareParts = explode('#', trim($item));
            $fillableArray[] = $spareParts[0];
        }
        $commaSeparetedString = implode("', '", $fillableArray);
        $fillable = "['" . $commaSeparetedString . "']";
        $localize = $this->option('localize');
        $locales = $this->option('locales');
        $indexes = $this->option('indexes');
        $relationships = $this->option('relationships');

        $validations = trim($this->option('validations'));

        $this->call('manthra:api-controller', [
            'name' => $controllerNamespace . $name . 'Controller',
            '--crud-name' => $name,
            '--model-name' => $modelName,
            '--model-namespace' => $modelNamespace,
            '--route-group' => $routeGroup,
            '--pagination' => $perPage,
            '--fields' => $fields,
            '--validations' => $validations
        ]);

        $this->call('manthra:model', [
            'name' => $modelNamespace . $modelName,
            '--fillable' => $fillable,
            '--table' => $tableName,
            '--pk' => $primaryKey,
            '--relationships' => $relationships
        ]);

        $this->call('manthra:migration', [
            'name' => $migrationName,
            '--schema' => $fields,
            '--pk' => $primaryKey,
            '--indexes' => $indexes,
            '--foreign-keys' => $foreignKeys
        ]);

        if ($localize == 'yes') {
            $this->call('manthra:lang', ['name' => $name, '--fields' => $fields, '--locales' => $locales]);
        }

        $routeFile = base_path('routes/api.php');

        if (file_exists($routeFile) && (strtolower($this->option('route')) === 'yes')) {
            $this->controller = ($controllerNamespace != '') ? $controllerNamespace . '\\' . $name . 'Controller' : $name . 'Controller';
            $isAdded = File::append($routeFile, "\n" . implode("\n", $this->addRoutes()));
            if ($isAdded) {
                $this->info('Manthra working... Route added to ' . $routeFile);
            } else {
                $this->info('Ups.. Your Manthra is wrong, Unable to add the route to ' . $routeFile);
            }
        }
    }

    protected function addRoutes()
    {
        $path = "Api\\";
        return ["Route::resource('" . $this->routeName . "', '" . $path . $this->controller . "');"];
    }
}
