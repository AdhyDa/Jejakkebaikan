<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CampaignVolunteerNeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'position',
        'slots_needed',
        'slots_filled',
        'description',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
