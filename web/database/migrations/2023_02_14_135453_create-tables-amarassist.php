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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document', 14);
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pf', 'pj'])->default('pf');
            $table->unsignedSmallInteger('cicle');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ticket', 'card', 'pix'])->default('ticket');
            $table->decimal('value', 10, 2);
            $table->decimal('fine_value', 10, 2)->nullable();
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->unsignedBigInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('charges_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charge_id');
            $table->foreign('charge_id')->references('id')->on('charges')->onDelete('cascade');
            $table->text('ticket')->nullable();
            $table->text('card')->nullable();
            $table->text('pix')->nullable();
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
        Schema::dropIfExists('charges_types');
        Schema::dropIfExists('charges');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('customers');
    }
};
