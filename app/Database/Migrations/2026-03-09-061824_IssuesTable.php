<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IssueTable extends Migration
{
    public function up()
    {
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
            'issue_type' => [  
                'type' => 'ENUM("task", "bug", "story", "epic", "subtask")',
                'default' => 'task',
                'null' => false
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'priority' => [
                'type' => 'ENUM("Lowest", "Low", "Medium", "High", "Highest")', 
                'default' => 'Medium'
            ],
            'status' => [
                'type' => 'ENUM("To Do", "In Progress", "In Review", "Done", "Closed")', 
                'default' => 'To Do'
            ],
            'reporter_id' => [  
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'assignee_id' => [  
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'parent_issue_id' => [  
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'due_date' => [  
                'type' => 'DATE',
                'null' => true
            ],
            'estimated_hours' => [  
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
            ],
            'actual_hours' => [  
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
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
        
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reporter_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('assignee_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('parent_issue_id', 'issues', 'id', 'CASCADE', 'CASCADE'); // self reference
        
        $this->forge->createTable('issues');
    }

    public function down()
    {
        $this->forge->dropTable('issues');
    }
}