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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('referred_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('code');
            $table->boolean('is_registered')->default(0);
            $table->index(['email']);
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
        //Dropping the foreign key
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referred_by');
            $table->dropColumn('referred_by');
        });
        Schema::dropIfExists('referrals');
    }
};
