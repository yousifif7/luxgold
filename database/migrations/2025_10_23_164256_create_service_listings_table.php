<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('categories_id')->constrained()->onDelete('cascade');
            $table->string('business_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('role_title')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('plans_id')->nullable();
            $table->string('email')->nullable();
            $table->text('physical_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable()->default('TX');
            $table->string('zip_code')->nullable();
            
            // Services
            $table->json('sub_categories')->nullable(); // Store as JSON array
            $table->json('services_offerd')->nullable();
            $table->text('service_description')->nullable();
            
            // Pricing & Schedule
            $table->decimal('price_amount', 10, 2)->nullable();
            $table->text('pricing_description')->nullable();
            $table->json('available_days')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('availability_notes')->nullable();
            
            // Credentials
            $table->string('license_number')->nullable();
            $table->string('years_operation')->nullable();
            $table->text('insurance_coverage')->nullable();
            $table->json('diversity_badges')->nullable();
            $table->json('special_features')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            
            // Media
            $table->string('logo_path')->nullable();
            $table->json('facility_photos_paths')->nullable();
            $table->json('license_docs_paths')->nullable();
            
            // Status and ownership
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_featured')->default(0)->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->timestamps();
                    });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_listings');
    }
};