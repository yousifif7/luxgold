<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hire_requests', function (Blueprint $table) {
            $table->text('provider_message')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('hire_requests', function (Blueprint $table) {
            $table->dropColumn('provider_message');
        });
    }
};
