<?php

namespace App\Jobs;

use App\Imports\CampaignFinanceImport;
use App\Models\CampaignFinance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ProcessImportCampaignFinance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Excel::import(new CampaignFinanceImport, public_path('dataset.csv'));

        foreach ($data as $index => $item) {
            CampaignFinance::create([
                "CMTE_ID" => $item["CMTE_ID"],
            ]);
        }

    }
}
