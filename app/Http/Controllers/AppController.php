<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use App\Jobs\AddUserRecordsJob;
use Illuminate\Support\Facades\Bus;

class AppController extends Controller
{
    public function addUsers()
    {
      // Process Job in 10k per transaction to avoid failure
      $totalItems = 100000;
      $chunkSize = 10000;
      // Looping through the items to categorize them in batches
      for ($arrayCount = 1; $arrayCount <= intval(round($totalItems / $chunkSize)); $arrayCount++) {
        $arrayItems[] = new AddUserRecordsJob($chunkSize);
      }
      $modulusDivision = $totalItems % $chunkSize;
      // Checking to see if there is a remainder from the predefine batch e.g 100001
      $modulusDivision > 0 ? $arrayItems[] = new AddUserRecordsJob($modulusDivision) : null;
      $batch = Bus::batch($arrayItems)->then(function (Batch $batch) {
          // All jobs completed successfully...
      })
      ->allowFailures()
      ->name('Process User Records')->dispatch();
      return response(true, 201);
    }
}
