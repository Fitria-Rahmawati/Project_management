<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IssueLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'issue_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'old_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'new_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'changed_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'changed_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('issue_id', 'issues', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('changed_by', 'employees', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('issue_logs');
    }

    public function down()
    {
        $this->forge->dropTable('issue_logs');
    }
}
