<?php namespace Graffon\Graffauth\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGraffonGraffauthApiKeys2 extends Migration
{
    public function up()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->text('ip_address')->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->string('ip_address', 255)->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
        });
    }
}
