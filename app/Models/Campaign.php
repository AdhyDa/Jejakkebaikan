<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'category',
        'organization_name',
        'target_amount',
        'collected_amount',
        'end_date',
        'need_money',
        'need_goods',
        'need_volunteer',
        'status',
    ];

    protected $casts = [
        'end_date' => 'date',
        'need_money' => 'boolean',
        'need_goods' => 'boolean',
        'need_volunteer' => 'boolean',
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moneyDonations()
    {
        return $this->hasMany(MoneyDonation::class);
    }

    public function goodsDonations()
    {
        return $this->hasMany(GoodsDonation::class);
    }

    public function volunteerDonations()
    {
        return $this->hasMany(VolunteerDonation::class);
    }

    public function goodsNeeds()
    {
        return $this->hasMany(CampaignGoodsNeed::class);
    }

    public function volunteerNeeds()
    {
        return $this->hasMany(CampaignVolunteerNeed::class);
    }

    public function updates()
    {
        return $this->hasMany(CampaignUpdate::class);
    }

    // Helper methods
    public function getDaysLeft()
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function getProgressPercentage()
    {
        if ($this->target_amount <= 0) return 0;
        return min(($this->collected_amount / $this->target_amount) * 100, 100);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->getDaysLeft() >= 0;
    }
}
