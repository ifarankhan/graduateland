# Job Scraper
## _Scrape Data from spotifyjobs_
-------
## Getting started
This application has been created in laravel. This will crawl job info from Spotify's website. Can be executed from web or CLI. To clone this directory, you need to execute this command in new folder.


```sh
git clone https://github.com/ifarankhan/graduateland.git .
```
After you have successfully clone laravel application. You need to run the following command for runing the project on root:

```sh
composer update
```

## Project Setup

Once composer updates, You need to copy .env.example to .env

Setup your database name and credentials in .env file.
Make sure QUEUE_CONNECTION set as 'database'. You can migrate the data to database via:

```sh
php artisan migrate
```

You can now start your own server on laravel via:

```sh
php artisan serve
```

## Scraping data 

This project will fetch the data from Spotify webservice and store particular information from each job postings. You can specify the country you want to scrap the job from. It will take country name as a parameter. You can scrap via browser by going to the home page of the application and defining the name. Or you can do it via command line. In any case, you need to start laravel Queues listing, which can be done as:

```sh
php artisan queue:work --daemon
```

This will start to listen to existing jobs in your database. All the job will be queued automatically. 

It takes the country name as a parameter via command line as well. Its a required parameter. for example, pass sweden in place of [country]:

```sh
php artisan scraper:jobs [country]
```

## Testing

If you want to run the test case to deduct if our job is running. You can do it via CLI as:
```sh
php artisan test
```

##  Logging

For now, job data is currently being logged in the same file as error log. To view the logs for job, you can view it at:
```sh
storage/logs/laravel.log
```

## License


**Enjoy Coding!**

