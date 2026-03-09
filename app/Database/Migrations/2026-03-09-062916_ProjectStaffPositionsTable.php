<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectStaffPositionsTable extends Migration
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

            'project_member_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'position_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey(['project_member_id', 'position_id']);

        $this->forge->addForeignKey(
            'project_member_id',
            'project_members',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'position_id',
            'positions',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('project_staff_positions');
    }

    public function down()
    {
        $this->forge->dropTable('project_staff_positions');
    }
}