<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($campaign) {
            if (empty($campaign->slug)) {
                $slug = Str::slug($campaign->title);
                $originalSlug = $slug;
                $counter = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $campaign->slug = $slug;
            }
        });

        static::updating(function ($campaign) {
            if ($campaign->isDirty('title') && empty($campaign->slug)) {
                $slug = Str::slug($campaign->title);
                $originalSlug = $slug;
                $counter = 1;
                while (self::where('slug', $slug)->where('id', '!=', $campaign->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $campaign->slug = $slug;
            }
        });
    }

    protected $fillable = [
        'user_id',
        'title',
        'slug',
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
        'goods_description',
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
