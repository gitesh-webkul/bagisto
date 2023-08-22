# laravel-store-locator

# Store Locator

### 1. Introduction:

* This module allows the admin to add multiple pickup stores along with there location and timing. The customers can use the integrated google maps of bagisto Store Locator to view the nearest pickup store to their location.


### 2. Requirements:

* **Bagisto**: v1.3.3
* ** Marketplace -V1.3.3**




### 3. Installation:

* Unzip the respective extension zip and then merge "packages"  into project root directory.
* Goto config/app.php file and add following line under 'providers'

~~~
Webkul\MpStoreLocator\Providers\MpStoreLocatorServiceProvider::class,
~~~

* Goto composer.json file and add following line under 'psr-4'

~~~
 "Webkul\\MpStoreLocator\\": "packages/Webkul/MpStoreLocator/src"
~~~

* Run these commands below to complete the setup

~~~
composer dump-autoload
~~~
~~~
php artisan optimize
~~~

~~~
php artisan migrate
~~~
~~~
php artisan route:cache
~~~
~~~
php artisan optimize
~~~

~~~
php artisan vendor:publish --force

-> Press the number before "Webkul\MpStoreLocator\Providers\MpStoreLocatorServiceProvider" and then press enter to publish all assets and configurations.
~~~


~~~
Reference Link: https://store.webkul.com/magento2-store-locator.html
~~~


> That's it, now just execute the project on your specified domain.



