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
            if (empty($campaign->slug)) {
                $slug = Str::slug($campaign->title);
                $originalSlug = $slug;
                $counter = 1;
                while (Campaign::where('slug', $slug)->where('id', '!=', $campaign->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $campaign->update(['slug' => $slug]);
            }
        });
    }
}
