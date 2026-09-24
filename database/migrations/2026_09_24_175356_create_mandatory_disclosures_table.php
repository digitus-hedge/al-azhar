<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mandatory_disclosures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file');                            // PDF path on the public disk
            $table->string('original_name')->nullable();       // file name as uploaded
            $table->unsignedInteger('file_size')->nullable();  // bytes
            $table->string('issued_by')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('valid_until')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mandatory_disclosures');
    }
};
