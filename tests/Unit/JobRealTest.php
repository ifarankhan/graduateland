<?php

namespace Tests\Unit;

use App\Jobs\ScrapJob;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class JobRealTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if Scraper Job inserts correct values to database.
     *
     * @return void
     */
    public function testRealJob()
    {
        $testInput = [
            "id" => "senior-data-scientist-design-platform",
            "text" => "Senior Data Scientist, Design Platform"
        ];

        // Using Bus to prevent jobs from being dispatched to the queue
        ScrapJob::dispatchSync($testInput);
        $this->assertDatabaseCount('vacancies', 1);
        Log::info(Vacancy::all()->toArray());
    }
}
