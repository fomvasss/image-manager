# Image Manager v.2.0
Package for storing and processing the images based on Intervention Image in Laravel 5.3

# Install
```
composer require "fomvasss/image-manager":dev-master
```
register the service provider and aliases in config/app.php:
```
  Fomvasss\ImageManager\ServiceProvider::class,
  ...
  'ImageManager' => Fomvasss\ImageManager\Facades\ImageManager::class,
```
Then publish assets with 
```
php artisan vendor:publish --provider="Fomvasss\ImageManager\ServiceProvider"
```
This will add the file config/image_manager.php
# Config  
Edit file `config/image_manager.php`, set:
  
# Using
##Using facades ImageManager
```
use Fomvasss\ImageManager\Facades\ImageManager;
```
Now, you can use next: 
```
ImageManager::store($request->file('images'), $request->get('image_titles'), $request->get('image_alts')); //returt array[[img,title,alt],...,[img,title,alt]]
```
```
ImageManager::destray($filename); //returt bool

```
```
ImageManager::regeneration();  //return int count
```


##Other method and API are back here:
- http://image.intervention.io
- http://image.intervention.io/use/url

