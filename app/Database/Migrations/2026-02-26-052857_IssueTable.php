<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IssueTable extends Migration
{
    public function up()
    {
        // Create 'issues' table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'project_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT'
            ],
            'priority' => [
                'type' => 'ENUM("Low", "Medium", "High")',
                'default' => 'Medium'
            ],
            'status' => [
                'type' => 'ENUM("Open", "In Progress", "Closed")',
                'default' => 'Open'
            ],
            'reported_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'assigned_to' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('project_id', 'projects', 'id',
            'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id',
            'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reported_by', 'users', 'id',
            'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('assigned_to', 'users', 'id',
            'SET NULL', 'CASCADE');
        $this->forge->createTable('issues');
    }

    public function down()
    {
        $this->forge->dropTable('issues');
    }
}
