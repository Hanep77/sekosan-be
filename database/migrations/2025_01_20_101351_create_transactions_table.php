<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignid("room_id")->constrained();
            $table->foreignid("boarding_house_id")->constrained();
            $table->string("name");
            $table->string("email");
            $table->string("phone_number");
            $table->enum("payment_method", ["down_payment", "full_payment"]);
            $table->enum("payment_status", ["accepted", "pending", "rejected"]);
            $table->date("start_date");
            $table->unsignedInteger("duration");
            $table->unsignedInteger("total_amount");
            $table->date("transaction_date");
            $table->string("snap_token");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
