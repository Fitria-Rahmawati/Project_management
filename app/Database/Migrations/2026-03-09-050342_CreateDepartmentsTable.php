<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDepartmentsTable extends Migration
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
            'department_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'department_code' => [  
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true, 
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'head_position_id' => [  
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'parent_id' => [  
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'is_active' => [  
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
            'head_position_id',
            'positions',
            'id',
            'SET NULL', 
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'parent_id',
            'departments',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('departments');
    }

    public function down()
    {
        $this->forge->dropTable('departments');
    }
}