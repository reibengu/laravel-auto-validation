<?php

namespace Bekusc\Validation\Traits;

use Closure;
use Illuminate\Http\Request;

trait AutoValidation
{
    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $this->validateRequest(get_class($this), $method);

        return $this->$method(...array_values($parameters));
    }

    /**
     * Validate the request with specified rules in validation config.
     *
     * @param  string  $class
     * @param  string  $method
     * @return void
     */
    protected function validateRequest(string $class, string $method)
    {
        $rules = $this->getValidationRules($class, $method);

        if ($rules) {
            $request = request();

            if ($rules instanceof Closure) {
                $rules = $rules($request);
            }

            $this->validate($request, $rules);
        }
    }

    /**
     * Get the rules to be used for request validation.
     *
     * @param  string  $class
     * @param  string  $method
     * @return array
     */
    protected function getValidationRules(string $class, string $method)
    {
        $namespace = config("validation.namespace");

        if (is_null($namespace)) {
            $namespace = 'App\Http\Controllers';
        }

        $class_name = substr($class, strlen($namespace) + 1);

        return config("validation.rules.{$class_name}.{$method}");
    }
}
