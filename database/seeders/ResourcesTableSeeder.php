<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            [
                'title' => 'How to Prepare Your Home For A Cleaner',
                'description' => 'A short checklist to make the cleaning process faster and more effective for both you and your cleaner.',
                'category' => 'Guides',
                'image_url' => 'https://images.pexels.com/photos/34992757/pexels-photo-34992757.jpeg',
                'content' => '<p>Preparing your home before a cleaner arrives saves time and ensures they can focus on the tasks that matter most. Tidy away personal items, clear surfaces, and make a note of any specific requirements.</p>',
                'read_time' => '4 min read',
                'slug' => Str::slug('How to Prepare Your Home For A Cleaner'),
                'meta_title' => 'Prepare Your Home For A Cleaner - luxGold',
                'meta_description' => 'Checklist to prepare your home before a cleaner arrives.',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Green Cleaning Tips That Work',
                'description' => 'Practical eco-friendly cleaning tips using everyday products.',
                'category' => 'Tips',
                'image_url' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Switch to simple, non-toxic ingredients like vinegar, baking soda and lemon for many household cleaning tasks. These options are safer for families and pets.</p>',
                'read_time' => '5 min read',
                'slug' => Str::slug('Green Cleaning Tips That Work'),
                'meta_title' => 'Green Cleaning Tips - luxGold',
                'meta_description' => 'Eco-friendly cleaning tips for safer homes.',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Understanding Cleaning Pricing: What To Expect',
                'description' => 'A clear breakdown of common pricing models for home cleaning services.',
                'category' => 'Pricing',
                'image_url' => 'https://images.pexels.com/photos/34975657/pexels-photo-34975657.jpeg',
                'content' => '<p>Cleaning pricing is usually based on property size, frequency and additional services. This guide helps you compare hourly vs fixed-rate quotes.</p>',
                'read_time' => '6 min read',
                'slug' => Str::slug('Understanding Cleaning Pricing: What To Expect'),
                'meta_title' => 'Cleaning Pricing Guide - luxGold',
                'meta_description' => 'Learn how cleaners typically price their services.',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'title' => 'Hiring The Right Cleaner: Questions To Ask',
                'description' => 'Key questions to ask before hiring a cleaner to ensure a good fit and peace of mind.',
                'category' => 'Hiring',
                'image_url' => 'https://images.unsplash.com/photo-1581579185616-9f0e8a7b2f3d?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Ask about experience, insurances, ID checks and supplies. Discuss expectations around pets, access and security.</p>',
                'read_time' => '5 min read',
                'slug' => Str::slug('Hiring The Right Cleaner: Questions To Ask'),
                'meta_title' => 'Hiring A Cleaner - luxGold',
                'meta_description' => 'Top questions to ask when hiring a cleaner.',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'title' => 'Post-Clean Checklist: Keep It Looking Great',
                'description' => 'A simple checklist to keep your home tidy between professional cleans.',
                'category' => 'Guides',
                'image_url' => 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Small daily habits like wiping surfaces, quick declutters and spot vacuuming help extend the benefits of a professional clean.</p>',
                'read_time' => '3 min read',
                'slug' => Str::slug('Post-Clean Checklist: Keep It Looking Great'),
                'meta_title' => 'Post-Clean Checklist - luxGold',
                'meta_description' => 'Tips to maintain cleanliness between professional visits.',
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'title' => 'Seasonal Deep-Clean Guide',
                'description' => 'A room-by-room plan for a thorough seasonal clean.',
                'category' => 'Guides',
                'image_url' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1200&q=80',
                'content' => '<p>Focus on decluttering, deep-cleaning upholstery, washing curtains and tackling neglected areas like ovens and behind appliances.</p>',
                'read_time' => '7 min read',
                'slug' => Str::slug('Seasonal Deep-Clean Guide'),
                'meta_title' => 'Seasonal Deep-Clean - luxGold',
                'meta_description' => 'Complete seasonal deep-clean checklist for homes.',
                'sort_order' => 6,
                'status' => true,
            ],
        ];

        foreach ($resources as $data) {
            Resource::create($data);
        }
    }
}
