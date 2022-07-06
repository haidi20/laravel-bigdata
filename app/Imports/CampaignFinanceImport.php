<?php

namespace App\Imports;

use App\Models\CampaignFinance;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CampaignFinanceImport implements ToModel, WithChunkReading, ShouldQueue
{
    // use RemembersChunkOffset;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CampaignFinance([
            'CMTE_ID'     => $row[0],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
