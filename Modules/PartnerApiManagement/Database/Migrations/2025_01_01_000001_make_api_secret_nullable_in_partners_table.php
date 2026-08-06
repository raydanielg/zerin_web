<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeApiSecretNullableInPartnersTable extends Migration
{
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('api_secret')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('api_secret')->nullable(false)->change();
        });
    }
}
