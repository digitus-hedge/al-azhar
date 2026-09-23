<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Facilities: Labs, Library, Sports, Transport, Other.
 * Each facility has a cover image, a photo gallery and CMS descriptions.
 *
 * If you ALREADY migrated the earlier `facilities` table, this migration
 * is skipped automatically and the next one only adds the missing columns.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('facilities')) {
            return;
        }

        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['lab', 'library', 'sports', 'transport', 'other'])->default('other');
            $table->string('title', 191);
            $table->string('slug', 191)->unique();
            $table->string('short_description', 255)->nullable();   // listing / card text
            $table->longText('description')->nullable();            // full CMS content
            $table->string('image')->nullable();                    // cover image path
            $table->json('gallery')->nullable();                    // ["facilities/gallery/a.jpg", ...]
            $table->string('icon', 50)->nullable();                 // e.g. bi-bus-front
            $table->json('features')->nullable();                   // highlights: ["40 computers", "AC"]
            $table->unsignedInteger('capacity')->nullable();        // seats / books / vehicles
            $table->string('location', 150)->nullable();            // "Block A, 2nd floor"
            $table->string('timings', 100)->nullable();             // "8:30 AM – 4:00 PM"
            $table->string('contact_person', 100)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->boolean('show_on_home')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
