<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SendFcmNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title;
    public $body;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title,$body)
    {
        $this->title = $title;
        $this->body =$body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('customers')->select(['id','fcm_token','device_type'])
        ->orderBy('id')
        ->chunk(100, function (Collection $customers) { 
            $tokens = $customers->pluck('fcm_token');

            // FcmNotifications::send($this->title,$this->body,$tokens);
            
        });
    }
}
