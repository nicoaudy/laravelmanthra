<?php

namespace NicoAudy\LaravelManthra\Commands;

use File;
use Illuminate\Console\Command;

class GenerateCrudCommand extends Command
{
    protected $signature = 'manthra:complete
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
                            {--view-path= : The name of the view path.}
                            {--localize=no : Allow to localize? yes|no.}
                            {--locales=en : Locales language type.}';

    protected $description = 'Generate Crud complete including web and api controller, model, views & migrations.';
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
        $viewPath = $this->option('view-path');
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

        $this->call('manthra:controller', [
            'name' => $controllerNamespace . $name . 'Controller',
            '--crud-name' => $name,
            '--model-name' => $modelName,
            '--model-namespace' => $modelNamespace,
            '--view-path' => $viewPath,
            '--route-group' => $routeGroup,
            '--pagination' => $perPage,
            '--fields' => $fields,
            '--validations' => $validations
        ]);

        $this->call('manthra:view', [
            'name' => $name,
            '--fields' => $fields,
            '--validations' => $validations,
            '--view-path' => $viewPath,
            '--route-group' => $routeGroup,
            '--localize' => $localize,
            '--pk' => $primaryKey
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

        $webRoute = base_path('routes/web.php');
        $apiRoute = base_path('routes/api.php');

        if (file_exists($webRoute) && file_exists($apiRoute) && (strtolower($this->option('route')) === 'yes')) {
            $this->controller = ($controllerNamespace != '') ? $controllerNamespace . '\\' . $name . 'Controller' : $name . 'Controller';

            $isAddedToWeb = File::append($webRoute, "\n" . implode("\n", $this->addRoutes()));
            $isAddedToApi = File::append($apiRoute, "\n" . implode("\n", $this->addRoutes()));

            if ($isAddedToWeb && $isAddedToApi) {
                $this->info('Manthra working... Route added to ' . $webRoute);
                $this->info('Manthra working... Route added to ' . $apiRoute);
            } else {
                $this->info('Ups.. Your Manthra is wrong, Unable to add the route to ' . $apiRoute);
            }
        }
    }

    protected function addRoutes()
    {
        return ["Route::resource('" . $this->routeName . "', '" . $this->controller . "');"];
    }
}
