<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// class MoneyDonation extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'user_id',
//         'campaign_id',
//         'amount',
//         'message',
//         'is_anonymous',
//     ];

//     protected $casts = [
//         'amount' => 'decimal:2',
//         'is_anonymous' => 'boolean',
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function campaign()
//     {
//         return $this->belongsTo(Campaign::class);
//     }
// }

// class GoodsDonation extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'user_id',
//         'campaign_id',
//         'item_name',
//         'quantity',
//         'description',
//         'status',
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function campaign()
//     {
//         return $this->belongsTo(Campaign::class);
//     }
// }

// class VolunteerDonation extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'user_id',
//         'campaign_id',
//         'position',
//         'message',
//         'status',
//     ];

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }

//     public function campaign()
//     {
//         return $this->belongsTo(Campaign::class);
//     }
// }

// class CampaignGoodsNeed extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'campaign_id',
//         'item_name',
//         'quantity_needed',
//         'quantity_received',
//     ];

//     public function campaign()
//     {
//         return $this->belongsTo(Campaign::class);
//     }
// }

// class CampaignVolunteerNeed extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'campaign_id',
//         'position',
//         'slots_needed',
//         'slots_filled',
//         'description',
//     ];

//     public function campaign()
//     {
//         return $this->belongsTo(Campaign::class);
//     }
// }

// class CampaignUpdate extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'campaign_id',
//         'title',
//         'content',
//         'image',
//     ];

//     public function campaign()
//     {
//         return $this->belongsTo(Campaign::class);
//     }
// }
