<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class Workers extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['true', 'false'],
                'default' => 'false',
            ],
            "slug" => [
                "type" => "VARCHAR",
                "constraint" => "150",
            ],
            "created_at" => [
                "type" => "VARCHAR",
                "constraint" => '30',
                "null" => true,
            ],
            "updated_at" => [
                "type" => "VARCHAR",
                "constraint" => '30',
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
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('workers');


        for ($i = 0; $i < 7; $i++) {
            $data[$i] = [
                'name' => 'Buruh ' . $i,
                'status' => 'true',
                'slug' => Time::now()->getTimestamp() . $i,
                'created_by' => '1',
                'created_at' => Time::now()->getTimestamp(),
                'updated_at' => Time::now()->getTimestamp(),
            ];
        }

        $this->db->table('workers')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('workers');
    }
}