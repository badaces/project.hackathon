<?php

use Phinx\Migration\AbstractMigration;

class DataPointFromIntToFloat extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('data_point');

        $table
            ->changeColumn('data', 'float')
        ;
    }

    public function down()
    {
        $table = $this->table('data_point');

        $table
            ->changeColumn('data', 'integer')
        ;
    }
}
