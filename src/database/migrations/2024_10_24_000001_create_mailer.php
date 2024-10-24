a<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateMailer extends Migration
{
/**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    if (!Schema::hasTable('notifications')) {
      Schema::create('notifications', function(BluePrint $table) {
        $table->id();
        $table->bigInteger('notification_id')->unsigned();
        $table->bigInteger('user_id')->nullable()->unsigned();
        $table->string('email');
        $table->string('name');
        $table->timestamp('created_at');
      });
    }
    
    if (!Schema::hasTable('notification_messages')) {
      Schema::create('notification_messages', function(BluePrint $table) {
        $table->id();
        $table->string('title');
        $table->longText('body');
        $table->string('type');
        $table->timestamp('created_at');
      });
    }
  }


  public function down()
  {
    Schema::dropIfExists('notifications');
    Schema::dropIfExists('market_notification_messagesbanks');
  }
}