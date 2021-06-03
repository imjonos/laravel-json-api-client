# JsonApi Client 0.1a

## Installation

Via Composer

``` bash
$ composer require imjonos/laravel-json-api-client
```

## Usage
```
$resources = JsonApiClient::resources('/api/v1/users');

OR

$client = new Client($apiUrl, $clientId, $clientSecret);
$resources = new Resources($client, '/api/v1/users');

$resources->chunk(100, function($resources, $pageNumber, $total){
  foreach ($resources AS $resource){
                ...
  }
});
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- Eugeny Nosenko

## License

license. Please see the [license file](license.md) for more information.
