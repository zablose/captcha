# Captcha for Laravel ~5.5 and PHP ~7.1

> Originally based on [mewebstudio/captcha](https://github.com/mewebstudio/captcha)

## Usage

Install package: `composer require zablose/captcha`.

Check that new route is working, by visiting '://localhost/captcha'

You have to see a captcha image like one of these:

![](readme/images/captcha-sample-01.png)
![](readme/images/captcha-sample-02.png)
![](readme/images/captcha-sample-03.png)
![](readme/images/captcha-sample-04.png)
![](readme/images/captcha-sample-05.png)

Add captcha to your form, like in the code sample below:

> If standard auth in use, add code sample to `./resources/views/auth/login.blade.php`.

```blade
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <label>
                <img src="{!! captcha_url() !!}" alt="captcha">
            </label>
        </div>
    </div>
    
    <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Captcha</label>
    
        <div class="col-md-6">
            <input type="text" class="form-control" name="captcha" autocomplete="off">
    
            @if ($errors->has('captcha'))
                <span class="help-block">
            <strong>{{ $errors->first('captcha') }}</strong>
        </span>
            @endif
        </div>
    </div>
```

Add validation rule to your controller, like in the code sample below:

> If standard auth in use, overwrite method `validateLogin` in `./app/Http/Controllers/Auth/LoginController.php`.

```php
    /**
     * Validate the user login request.
     *
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
            'password'        => 'required',
            'captcha'         => 'required|captcha',
        ]);
    }
```

Feel the joy and happiness!

## License

This package is free software distributed under the terms of the MIT license.
