<?php namespace Graffon\Graffauth\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateGraffonGraffauthApiKeys extends Migration
{
    public function up()
    {
        Schema::create('graffon_graffauth_api_keys', function($table)
        {
            $table->integer('id')->unsigned();
            $table->string('name');
            $table->string('app_key');
            $table->string('api_key');
            $table->string('ip_address');
            $table->boolean('is_active');
            $table->boolean('is_ip_active');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('graffon_graffauth_api_keys');
    }
}
