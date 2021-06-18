<?php


namespace App\Http\Services;


use App\Jobs\ScrapJob;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ScrapperService
{
    const SPOTIFY = "https://api-dot-new-spotifyjobs-com.nw.r.appspot.com/wp-json/animal/v1/job/search?q=&l=";

    /**
     * Get the data from spotify.
     *
     * @param string $country
     * @return \Illuminate\View\View
     */
    public function scraper(string $country)
    {
        $client = new Client();
        // Fetch Spotify list of jobs for the country
        $url = self::SPOTIFY . $country;
        $crawler = $client->get($url);
        if ($crawler->getStatusCode() == '200') {
            $dataScraped = json_decode($crawler->getBody(), true);
            if (!empty($dataScraped['result'])) {
                $i = 0;
                foreach ($dataScraped['result'] as $urlData) {
                    ScrapJob::dispatch($urlData);
                    $i++;
                    if ($i === 20) break;
                }
            }
            return true;
        }
        return false;
    }
}
