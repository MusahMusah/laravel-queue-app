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
      $batch = Bus::batch([
          new AddUserRecordsJob,
          new AddUserRecordsJob,
          new AddUserRecordsJob,
          new AddUserRecordsJob,
          new AddUserRecordsJob,

          new AddUserRecordsJob,
          new AddUserRecordsJob,
          new AddUserRecordsJob,
          new AddUserRecordsJob,
          new AddUserRecordsJob,
      ])->then(function (Batch $batch) {
          // All jobs completed successfully...
      })
      ->allowFailures()
      ->name('Process User Records')->dispatch();
      return response(true, 201);
    }
}
