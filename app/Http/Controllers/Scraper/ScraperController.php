<?php

namespace App\Http\Controllers\Scraper;

use App\Http\Controllers\Controller;
use App\Http\Services\ScrapperService;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    /** @var ScrapperService */
    private $scrapperService;

    public function __construct()
    {
        $this->scrapperService = new ScrapperService($this);
    }

    /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('scraper.index');
    }

    /**
     * Get the data from spotify.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function scraper(Request $request)
    {
        $country = $request->get("country");
        if (!empty($country)){
            $response = $this->scrapperService->scraper($country);
            if ($response){
                \Session::flash('message', "We started scraping the data related to $country. Your data will be available shortly!");
                \Session::flash('alert-class', 'alert-success');
            }else{
                \Session::flash('message', "We started scraping the data related to $country. But we have not received any response from Spotify jobs!");
            }
        }else{
            \Session::flash('message', "Please add a country for which you want to scrape the data.");
        }


        return \Redirect::back();
    }
}
