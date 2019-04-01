## Installation

You can install the package via composer:

``` bash
composer require rjvim/car
```

The package will automatically register itself.

You can publish the migration with:
```bash
php artisan vendor:publish --provider="Betalectic\Car\CarServiceProvider" --tag="migrations"
```

```bash
php artisan migrate
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Betalectic\Car\CarServiceProvider" --tag="config"
```

## Documentation

### comments:
 First Initialise the CarComments helper as . 
 ```$carComments = new CarComments()```
 
 **add Comment:   
     def: `addComment($comment, $module, $user)` . </br>
  ```$carComments->addComment($newComment, $module, $user)```
  
  - *module and user should be model instances.
  
 **update Comment:  
      def: `updateComment($data, $commentId)` . </br>
   ```$carComments->updateComment($newComment, $commentId)```
 
 **delete Comment:  
   def: `deleteComment($commentId)` . </br>
   ```$carComments->deleteComment($commentId)```
   
 **get Comments:  
      def: `getComments($module = NULL, $user = NULL)` . </br>
      ```$carComments->getComments($module, $user)```
   

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
