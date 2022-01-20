### Search for chromosome by position

- clone the repo to your local
- run `composer install` (this has been tested on php 7.4)
- using your terminal in the project root you can search using the command below: 

````
php bin/console search
````

or by passing the two options:

````
php bin/console search chr1 15820
````

### What are the limitation/problems with this solution?
this solution is only suitable for the provided file and may not work properly with other files.

### How would it scale?
for large file you may run into memory limit issue, so using [generator](https://www.php.net/manual/en/language.generators.overview.php) might be better solution.

### How would you test it efficiently?  
by creating multiple scenarios in my unit test.
