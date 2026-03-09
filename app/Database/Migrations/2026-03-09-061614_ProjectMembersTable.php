<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectMembersTable extends Migration
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

            'project_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'user_id' => [  
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'role_in_project' => [  
                'type'       => 'ENUM',
                'constraint' => ['project_manager', 'staff', 'client'],
                'default'    => 'staff',
                'null'       => false,
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

        $this->forge->addUniqueKey(['project_id', 'user_id']);

        $this->forge->addForeignKey(
            'project_id',
            'projects',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('project_members');
    }

    public function down()
    {
        $this->forge->dropTable('project_members');
    }
}