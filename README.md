# Image Manager
[![Latest Version on Packagist](https://img.shields.io/packagist/v/fomvasss/image-manager.svg)](https://packagist.org/packages/fomvasss/image-manager)
[![GitHub issues](https://img.shields.io/github/issues/fomvasss/image-manager.svg)](https://github.com/fomvasss/image-manager/issues)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/fomvasss/image-manager/master/LICENSE)
[![GitHub stars](https://img.shields.io/github/stars/fomvasss/image-manager.svg)](https://github.com/fomvasss/image-manager/stargazers)
[![Total Downloads](https://img.shields.io/packagist/dt/fomvasss/image-manager.svg)](https://packagist.org/packages/fomvasss/image-manager)

Package for storing and processing the images based on Intervention Image

## Install
```bash
composer require "fomvasss/image-manager"
```
register the service provider and aliases in config/app.php:
```php
  Fomvasss\ImageManager\ServiceProvider::class,
  //...
  'ImageManager' => Fomvasss\ImageManager\Facades\ImageManager::class,
```
Then publish assets with 
```bash
php artisan vendor:publish --provider="Fomvasss\ImageManager\ServiceProvider"
```
This will add the file config/image_manager.php
## Config  
Edit file `config/image_manager.php`, set:
  
## Using
### Using facades ImageManager
```php
use Fomvasss\ImageManager\Facades\ImageManager;
```
Now, you can use next: 
```php
ImageManager::store($request->file('images'), $request->get('image_titles'), $request->get('image_alts')); //returt array[[img,title,alt],...,[img,title,alt]]
//...
ImageManager::destroy($filename); //returt bool
```
```php
ImageManager::regeneration(); // TODO
```

## Other method and API are back here:
- http://image.intervention.io
- http://image.intervention.io/use/url

