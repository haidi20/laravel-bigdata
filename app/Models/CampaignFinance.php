<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        "CMTE_ID", "AMNDT_IND", "RPT_TP", "TRANSACTION_PGI",
        "IMAGE_NUM", "TRANSACTION_TP", "ENTITY_TP", "NAME",
        "CITY", "STATE",
    ];
}
