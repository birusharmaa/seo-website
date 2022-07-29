<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAppointmentBookingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'date_time' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'query' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('appointment_booking');
    }

    public function down()
    {
        $this->forge->dropTable('appointment_booking');
    }
}
