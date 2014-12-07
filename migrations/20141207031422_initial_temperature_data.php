<?php

use Phinx\Migration\AbstractMigration;

class InitialTemperatureData extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('temperature_data_point');
        $table
            ->addColumn('year', 'integer')
            ->addColumn('month', 'integer')
            ->addColumn('data', 'integer')
            ->addIndex(['year'])
            ->addIndex(['month'])
            ->addIndex(['data'])
            ->save()
        ;
    }

    public function down()
    {
        $this->dropTable('temperature_data_point');
    }
}
