<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bonuses extends Migration
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
            'id_worker' => [
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'       => true,
            ],
            'percent' => [
                'type'       => 'INT',
                'constraint' => '3',
                'default' => 0,
            ],
            'result' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            "slug" => [
                "type" => "VARCHAR",
                "constraint" => "100",
            ],
            "created_at" => [
                "type" => "INT",
                "constraint" => '11',
                "null" => true,
            ],
            "updated_at" => [
                "type" => "INT",
                "constraint" => '11',
                "null" => true,
            ],
            "created_by" => [
                "type" => "VARCHAR",
                "constraint" => "11",
                "null" => true,
            ],
            "updated_by" => [
                "type" => "VARCHAR",
                "constraint" => "11",
                "null" => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_worker', 'workers', 'id');
        $this->forge->createTable('bonuses');
    }

    public function down()
    {
        $this->forge->dropTable('bonuses');
    }
}