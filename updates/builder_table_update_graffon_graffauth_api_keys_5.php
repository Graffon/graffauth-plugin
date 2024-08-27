<?php namespace Graffon\Graffauth\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateGraffonGraffauthApiKeys5 extends Migration
{
    public function up()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('graffon_graffauth_api_keys', function($table)
        {
            $table->integer('id')->unsigned(false)->change();
        });
    }
}
