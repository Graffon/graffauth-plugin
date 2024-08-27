<?php namespace Graffon\Graffauth\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGraffonGraffauthApiKeys3 extends Migration
{
    public function up()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->increments('id')->change();
        });
    }
    
    public function down()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->integer('id')->change();
        });
    }
}
