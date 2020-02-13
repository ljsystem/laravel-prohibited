# Prohibit fields in Laravel FormRequest validations

This package adds seven new form request validations to your Laravel application that allows you to prohibit fields the same way as you usually require them.

## Installation

You can install this package via composer using this command:

```bash
composer require ljsystem/laravel-prohibited
```

The package will automatically register itself.

## Usage

After installing the package you can use the new rules the same way you would use [Laravels official validation](https://laravel.com/docs/validation) rules.

```php
$request->validate([
    'vehicle' => 'required|string|in:car,van,truck,bus,motorcycle',
    'speeding' => 'prohibited',
    'convertible' => 'prohibited_if:vehicle,motorcycle|integer',
    'helmet' => 'prohibited_unless:vehicle,motorcycle|bool',
    'hat' => 'prohibited_with:helmet,convertible|bool',
    'sunglasses' => 'prohibited_with_all:helmet,helmet_has_visor|bool',
    'helmet_has_visor' => 'prohibited_without:helmet|bool',
    'helmet_visor_color' => 'prohibited_without_all:helmet,helmet_has_visor|string|in:clear,tinted',
]);
```

## Available Validation Rules

- [Prohibited](#prohibited)
- [Prohibited If](#prohibited_ifanotherfieldvalue)
- [Prohibited Unless](#prohibited_unlessanotherfieldvalue)
- [Prohibited With](#prohibited_withfoobar)
- [Prohibited With All](#prohibited_with_allfoobar)
- [Prohibited Without](#prohibited_withoutfoobar)
- [Prohibited Without All](#prohibited_without_allfoobar)

###### **prohibited**

The field under validation must **not** be present in the input data, regardless of it's value. 

###### **prohibited_if:*anotherfield*,*value*...**

The field under validation must **not** be present if the *anotherfield* field is equal to any *value*.

###### **prohibited_unless:*anotherfield*,*value*,...**

The field under validation must **note** be present unless the *anotherfield* field is equal to any *value*.

###### **prohibited_with:*foo*,*bar*,...**

The field under validation must **not** be present *only if* any of the other specified fields are present.

###### **prohibited_with_all:*foo*,*bar*,...**

The field under validation must **not** be present *only if* all of the other specified fields are present.

###### **prohibited_without:*foo*,*bar*,...**

The field under validation must **not** be present *only when* any of the other specified fields are not present.

###### **prohibited_without_all:*foo*,*bar*,...**

The field under validation must **not** be present *only when* all of the other specified fields are not present.

## Localization

The package comes with English and Swedish translations out of the box. If you wish to add translations for your own language you publish the translations to your applications resource directory by running the following command:

```bash
php artisan vendor:publish --provider="Ljsystem\Prohibited\ProhibitedServiceProvider"
```

This will result in the following file structure:

```text
.
└── resources
    └── lang
        └── vendor
            └── prohibited
                ├── en
                │   └── validation.php
                └── sv
                    └── validation.php
```
You can now copy either the English or Swedish `validation.php` and translate it into your prefered language. Feel free to create a Pull Request if you would like to get your translations included in the package.

## Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
