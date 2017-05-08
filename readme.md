# Laravel Auto-validation
This package will allow you to remove all manual validations from your controllers.

## Installation
Simply go to your project directory where the `composer.json` file is located and type in your terminal:

```sh
composer require bekusc/laravel-auto-validation
```

Add the service provider to your providers array in `config/app.php`:

```php
'providers' => [
    // ...
    Bekusc\Validation\AutoValidationProvider::class,
],
```

Add the trait to your base controller `App\Http\Controllers\Controller`:

```php
use Bekusc\Validation\Traits\AutoValidation;

class Controller extends BaseController
{
    use AutoValidation;
}
```

Publish config:

```
php artisan vendor:publish --provider="Bekusc\Validation\AutoValidationProvider"
```

Update config file with your validation rules in:

```
config/validation.php
```

## Example

`config/validation.php` file:

```php
use Illuminate\Validation\Rule;

$rules = [
    'UserController' => [
        'register' => [
            'name'     => 'required|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->where('status', 1)],
            'password' => 'required|min:6|confirmed',
            'gender'   => 'required|in:male,female',
            'birthday' => 'required|date_format:Y-n-j',
        ],
        'update' => function ($request) {
            return [
                'name'     => 'required|max:255',
                'email'    => 'required|email|max:255|unique:users,email,'.$request->user()->id,
                'gender'   => 'required|in:male,female',
                'birthday' => 'required|date_format:Y-n-j',
            ];
        },
    ],
];

return ['rules' => $rules];
```

`UserController.php` file:

```php
class UserController extends Controller
{
    public function register(Request $request)
    {
        // The request will be validated automatically
        User::create($request->all());
    }

    public function update(Request $request)
    {
        // The request will be validated automatically
        $request->user()->update($request->all());
    }
}
```
