<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;
use Illuminate\Support\Str;

class PopulateCampaignSlugs extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaign::all()->each(function ($campaign) {
            $campaign->update(['slug' => Str::slug($campaign->title)]);
        });
    }
}
