<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // If cleaners table doesn't exist, create it with full schema.
        if (! Schema::hasTable('cleaners')) {
            Schema::create('cleaners', function (Blueprint $table) {
                $table->id();

                // Basic Info
                $table->string('name')->nullable();
                $table->string('phone')->nullable();
                $table->unsignedBigInteger('categories_id')->nullable();
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
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('avatar')->nullable();
                $table->timestamps();
            });
        } else {
            // Table exists: add missing columns only.
            $cols = [
                'name','phone','categories_id','business_name','contact_person','role_title','phone_number','plans_id','email','physical_address','city','state','zip_code','sub_categories','services_offerd','service_description','price_amount','pricing_description','available_days','start_time','end_time','availability_notes','license_number','years_operation','insurance_coverage','diversity_badges','special_features','website','facebook','instagram','logo_path','facility_photos_paths','license_docs_paths','status','is_featured','user_id','avatar','created_at','updated_at'
            ];

            foreach ($cols as $col) {
                if (! Schema::hasColumn('cleaners', $col)) {
                    Schema::table('cleaners', function (Blueprint $table) use ($col) {
                        switch ($col) {
                            case 'name':
                            case 'phone':
                            case 'business_name':
                            case 'contact_person':
                            case 'role_title':
                            case 'phone_number':
                            case 'plans_id':
                            case 'email':
                            case 'city':
                            case 'state':
                            case 'zip_code':
                            case 'license_number':
                            case 'years_operation':
                            case 'website':
                            case 'facebook':
                            case 'instagram':
                            case 'logo_path':
                            case 'avatar':
                                $table->string($col)->nullable();
                                break;
                            case 'categories_id':
                            case 'user_id':
                                $table->unsignedBigInteger($col)->nullable();
                                break;
                            case 'physical_address':
                            case 'service_description':
                            case 'pricing_description':
                            case 'insurance_coverage':
                                $table->text($col)->nullable();
                                break;
                            case 'sub_categories':
                            case 'services_offerd':
                            case 'available_days':
                            case 'diversity_badges':
                            case 'special_features':
                            case 'facility_photos_paths':
                            case 'license_docs_paths':
                                $table->json($col)->nullable();
                                break;
                            case 'price_amount':
                                $table->decimal('price_amount', 10, 2)->nullable();
                                break;
                            case 'start_time':
                            case 'end_time':
                                $table->time($col)->nullable();
                                break;
                            case 'availability_notes':
                                $table->text($col)->nullable();
                                break;
                            case 'status':
                                $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('pending');
                                break;
                            case 'is_featured':
                                $table->boolean('is_featured')->default(0)->nullable();
                                break;
                            case 'created_at':
                            case 'updated_at':
                                $table->timestamps();
                                break;
                        }
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleaners');
    }
};