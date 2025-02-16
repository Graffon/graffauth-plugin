<?php namespace Graffon\Graffauth\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGraffonGraffauthApiKeys6 extends Migration
{
    public function up()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->boolean('is_origins_active');
            $table->text('origins');
        });
    }
    
    public function down()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->dropColumn('is_origins_active');
            $table->dropColumn('origins');
        });
    }
}
