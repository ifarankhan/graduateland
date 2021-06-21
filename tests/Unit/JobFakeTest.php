<?php

namespace Tests\Unit;

use App\Jobs\ScrapJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class JobFakeTest extends TestCase
{
    /**
     * This test case only determine if the job has been dispatched
     *
     * @return void
     */
    public function testFakeJob()
    {
        $testInput = [
            "id" => "senior-data-scientist-design-platform",
            "text" => "Senior Data Scientist, Design Platform"
        ];
        // Using Bus to prevent jobs from being dispatched to the queue
        Bus::fake();
        ScrapJob::dispatch($testInput);
        Bus::assertDispatched(ScrapJob::class);

    }
}
