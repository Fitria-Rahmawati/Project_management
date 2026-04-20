<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivityLogsTable extends Migration
{
   public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'user_id' => [
            'type' => 'INT',
            'constraint' => 11,
        ],
        'activity' => [
            'type' => 'TEXT',
        ],
        'created_at' => [
            'type' => 'DATETIME',
        ],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addKey('user_id');
    $this->forge->createTable('activity_logs');
}

public function down()
{
    $this->forge->dropTable('activity_logs');
}
}