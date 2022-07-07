<?php

namespace App\Imports;

use App\Models\CampaignFinance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CampaignFinanceImport implements ToModel, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CampaignFinance([
            'CMTE_ID'     => $row[0],
            'AMNDT_IND'     => $row[1],
            'RPT_TP'     => $row[2],
            'TRANSACTION_PGI'     => $row[3],
            'IMAGE_NUM'     => $row[4],
            'TRANSACTION_TP'     => $row[5],
            'ENTITY_TP'     => $row[6],
            'NAME'     => $row[7],
            'CITY'     => $row[8],
            'STATE'     => $row[9],
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
