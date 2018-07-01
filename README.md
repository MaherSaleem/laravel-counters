# Counters Management for laravel project.


* [Installation](#installation)
* [Usage](#usage)
  * [1) Using Counters Associated with model](#1-using-counters-with-no-models)
  * [2) Using Counters with no models](#2-using-counters-with-no-models)
  * [3) Using artisan commands](#3-using-artisan-commands)
* [Unit Testing[To be added later]](#unit-testing)
* [Database Seeding](#database-seeding)
* [Cache[To be added later]](#cache)
* [Credits](#credits)
* [license](#license)

This package allows you to manage manage counters in the system.

Once installed you can do stuff like this:

```php

//increment/decrement system counter
Counters::increment('number_of_visitors'); 

// increment/decrement model objects counters
$post->increment('number_of_views');
$feature->decrement('number_of_bugs');

```


## Installation

- [Laravel](#laravel)

### Laravel

This package can be used in Laravel 5.4 or higher. If you are using an older version of Laravel You can install the package via composer:

``` bash
composer require maher/counters
```

In Laravel 5.5 and higher versions, the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

```php
'providers' => [
    // ...
    Maher\Counters\CounterssServiceProvider::class,
    //...
];
```

You must publish [the migration](https://github.com/MaherSaleem/Counters/tree/master/database/migrations) with:

```bash
php artisan vendor:publish --provider="Maher\Counters\CountersServiceProvider" --tag="migrations"
```

After the migration has been published you can create the tables by running the migrations:

```bash
php artisan migrate
```

You can publish the [config](https://github.com/MaherSaleem/Counters/tree/master/config) file with:

```bash
php artisan vendor:publish --provider="Maher\Counters\CountersServiceProvider" --tag="config"
```


## Usage
### 1) Using Counters with no models
First, add the `Maher\Counters\Traits\HasCounter` trait to your `Post` model(s):

```php
use Maher\Counters\Traits\HasCounter;

class Post extends Model
{
    use HasCounter;

    // ...
}
```

This package allows the posts to be associated with counters. Every post can associated with multiple counters.


We can create a counter like this, for example, lets create a counter for the number of views for the Post Model.
```php
use Maher\Counters\Models\Counter;

$counter = Counter([
            'key' => 'number_of_views',
            'name' => 'Views',
            'initial_value' => 0 //(could be left empty, default value is 0)
            'step' => 1 // (could be left empty, default value is 1)
        ]);
```


After that, for exmple, in the show function of post controller, you can add this line:
```php
class PostsController extends Controller
{
    public function show(Post $post)
    {
        //...
        $post->incrementCounter('number_of_views');
        //...
    }
}
```
By doing this, the counter of number_of_views for every post will be incremented [by the step size] as we show the post.

This package has another functions.
```php
// will return the counter object
$post->getCounter($key); 

// will return the counter value
$post->getCounterValue($key);

//will add record in countrable table for this post object
$post->addCounter($key);

//will remove the record from countrable table for this post object.
$post->removeCounter($key);

//increment the counter with the given $key
$post->incrementCounter($key);

//decrement the counter with the given $key
$post->decrementCounter($key);

 // will reset the counter value (to initial_value) for the post object.
$post->resetCounter($key);
```


### 2) Using Counters with no models.
Sometimes, you have general counters that are not associated with any models, for example the number visitor for your website.

Therefore, this package will allow you to deat with Counter with these types.

```php

use Maher\Counters\Facades\Counters; 
class Test 
{
    public function f(Post $post)
    {
        Counters::increment('number_of_visitors');
    }
}
```

This Facade has many other functions:

```php
// will return the counter object
Counters::get($key); 

// will return the counter value
Counters::getValue($key, $default = null); 

// set the value of the counter
Counters::setValue($key, $value);

//set the step of the counter
Counters::setStep($key, $step);

//increment the counter with the given $key
Counters::increment($key);

//decrement the counter with the given $key
Counters::decrement($key);

 // will reset the counter for the inital_value
Counters::reset($key);
```

In some cases, you want to increment the counter once for every person, for example no need to increment the number_of_visitors counter everytime the same user refreshes the page.

So you can use these functions:

```php
Counters::incrementIfNotHasCookies($key);
Counters::decrementIfNotHasCookies($key);
```


## 3)Using artisan commands

You can create a Counter from a console with artisan commands.
The following command creates the counter number_of_visitors with initial value 0 and step 1
```bash
php artisan make:counter number_of_visitors Visitors 0 1
```


## Database Seeding

Here's a sample seede.

```php
    use Illuminate\Database\Seeder;
    use Maher\Counters\Facades\Counters;

    class CounterTableSeeder extends Seeder
    {
        public function run()
        {

            // create Counters
            //This will create a counter with inital value as 3, and every increment 5 will be added.
            Counter::create([
                'key' => 'number_of_visitors',
                'name' => 'Visitors',
                'initial_value' => 3,
                'step' => 5
            ]);
            //This counter will has 0 as inital_value and 1 as step
            Counter::create([
                'key' => 'number_of_visitors2',
                'name' => 'Visitors2'
            ]);

            $viewCounter = Counter::create([
                'key' => 'number_of_views',
                'name' => 'Views'
            ]);
            
            $post = Post::find(1);
            $post->addCounter('number_of_views');// to add the record to countrable table
            
            
        }
    }
```

## Credits

Special Thanks to [Spatie](https://github.com/spatie) , since I learned and followed there structure of building laravel packages.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
