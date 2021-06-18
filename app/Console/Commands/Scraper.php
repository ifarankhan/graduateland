<?php

namespace App\Console\Commands;

use App\Http\Services\ScrapperService;
use Illuminate\Console\Command;

class Scraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scraper:jobs {country}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape data from spotifyjobs.com with passing country as an argument.';

    /** @var ScrapperService */
    private $scrapperService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->scrapperService = new ScrapperService($this);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $country = $this->argument('country');
        $response = $this->scrapperService->scraper($country);
        if ($response){
            $this->info("We started scraping the data related to $country. Your data will be available shortly!");
        }else{
            $this->info("We started scraping the data related to $country. But we have not received any response from Spotify jobs!");
        }
    }
}
