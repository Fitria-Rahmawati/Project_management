<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectsTable extends Migration
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

            'project_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'project_type' => [
                'type'       => 'ENUM',
                'constraint' => ['internal', 'client'],
                'default'    => 'internal',
            ],

            'company_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, 
            ],

            'project_manager_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],

            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['not_started', 'in_progress', 'completed'],
                'default'    => 'not_started',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'company_id',
            'companies',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'project_manager_id',
            'employees',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('projects');
    }

    public function down()
    {
        $this->forge->dropTable('projects');
    }
}