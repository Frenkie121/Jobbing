<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('sub_category_id')->constrained();
            $table->string('title', 75);
            $table->string('slug');
            $table->integer('type');
            $table->string('location')->nullable();
            $table->string('image')->default('job-default.png');
            $table->text('description');
            $table->float('salary');
            $table->date('deadline');
            $table->integer('duration');
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_url')->nullable();
            $table->string('company_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
