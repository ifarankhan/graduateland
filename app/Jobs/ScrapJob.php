<?php

namespace App\Jobs;

use App\Models\Vacancy;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goutte\Client;

class ScrapJob implements ShouldQueue
{
    const SPOTIFY_DETAILS = "https://www.spotifyjobs.com/jobs/";
    const EXPERIENCED = 1;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $scrapData = [];

    /**
     * Create a new job instance.
     *
     * @param $scrapData
     */
    public function __construct($scrapData)
    {
        $this->scrapData = $scrapData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Check if we already have the value in DB.
        if(!(Vacancy::where('job_id',$this->scrapData['id'])->exists())){
            $client = new Client();
            // url set as https://www.spotifyjobs.com/jobs/
            $url= self::SPOTIFY_DETAILS;
            //Goutte Wrapper used to get Spotify Detail page.
            $crawler = $client->request('GET', $url.$this->scrapData['id']);
            //Getting data from Xpath of Description
            $description = $crawler->filterXpath('//*[@id="__next"]/div/main/div/div[2]/div/div[2]/div/div')->extract(array('_text'));
            //Getting who we are and filtering it to get the Experience
            $experience = $crawler->filterXPath('//*[@id="__next"]/div/main/div/div[2]/div/div[6]')->each(function ($node) {
                $nodeArray =explode(' ', strtolower($node->text()));
                if(count(array_intersect($nodeArray, ['experience','expertise','proven'])) > 0){
                    // at least one of Keywords present in the text
                    preg_match( '/(\d+\b.*?(experience|expertise|proven))/i', strtolower($node->text()), $match);
                    return $match;
                }else{
                    return false;
                }
            });

            //Insert scrapped data to database.
            $vacancyModel = new Vacancy();
            $vacancyModel->job_id = $this->scrapData['id'];
            $vacancyModel->title = $this->scrapData['text'];
            if (is_array($experience[0]) && !empty($experience[0])){
                $vacancyModel->experience = self::EXPERIENCED;
                $vacancyModel->years = $experience[0][0];
            }
            if (!empty($description[0]))
                $vacancyModel->descriptions =$description[0];

            if ($vacancyModel->save()){
                Log::info('Inserted to database. ', ['id' => $this->scrapData['id']]);
                return;
            }

            else
                Log::error('Failed to save data in database for ', ['id' => $this->scrapData['id']]);
        }
        Log::error('This id already exists in database', ['id' => $this->scrapData['id']]);
    }
}
