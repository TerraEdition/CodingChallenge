<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class Users extends Migration
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
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['1', '2'],
                'default' => '1',
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
        $this->forge->addUniqueKey(['name', 'username']);
        $this->forge->createTable('users');
        $data = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => password_hash("1122", PASSWORD_DEFAULT),
                'role' => '2',
                'slug' => Time::now()->getTimestamp() . '1',
                'status' => 'true',
                'created_by' => '1',
                'created_at' => Time::now()->getTimestamp(),
                'updated_at' => Time::now()->getTimestamp(),
            ],
            [
                'name' => 'Regular User',
                'username' => 'user',
                'password' => password_hash("1122", PASSWORD_DEFAULT),
                'role' => '1',
                'slug' => Time::now()->getTimestamp() . '2',
                'status' => 'true',
                'created_by' => '1',
                'created_at' => Time::now()->getTimestamp(),
                'updated_at' => Time::now()->getTimestamp(),
            ],
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}