**Laravel Generators - Repositories and Services Providers**
--

This command line package help you create repositories and service providers, so you don't have to create files and folders by hand.

So, if you wanted to create a repository, you would call:

    php artisan makzumi:repo

  or

    php artisan makzumi:service

And just answer the few questions the command asks.

*repo* Will generate an interface file and an implementation with proper namespacing and folder structure.

*service* Will generate the service class, the facade and the service provider with proper namespacing and folder structure.

After creation, read the generated **README.MD** to finish configuration in a couple steps.

**Installation**

		composer require makzumi/generators dev-master
		

After that is done, add the following to the *providers* array in **config/app.php**