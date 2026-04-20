<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
class AddClientCommentsToProjects extends Migration
{
    public function up()
    {
        $this->forge->addColumn('projects', [
            'client_comments' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'comments_updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('projects', 'client_comments');
        $this->forge->dropColumn('projects', 'comments_updated_at');
    }
}