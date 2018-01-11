# Laravel Response Hjson

## Installation

Execute the following command to get the latest version of the package:
```
composer require cyrnicolase/laravel-response-hjson
```


In your `config/app.php` add `HjsonResponse\HjsonResponseProvider::class` to the end of the `providers` array:
```
'providers' => [
    ...
    HjsonResponse\HjsonResponseProvider::class,
]
```
