<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CampaignGoodsNeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'item_name',
        'quantity_needed',
        'quantity_received',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
