<?php

use Phinx\Migration\AbstractMigration;

class GenericDataPoints extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('temperature_data_point');

        $typeTable = $this->table('data_point_type');
        $typeTable
            ->addColumn('name', 'string')
            ->addIndex(['name'], ['unique' => true])
            ->save()
        ;

        $table
            ->rename('data_point')
            ->addColumn('type', 'integer')
            ->addForeignKey(['type'], $typeTable, ['id'], [
                'delete' => 'CASCADE'
            ])
            ->save()
        ;
    }

    public function down()
    {
        $table = $this->table('data_point');

        $table
            ->dropForeignKey(['type'])
            ->removeColumn('type')
            ->rename('temperature_data_point')
            ->save()
        ;

        $this->dropTable('data_point_type');
    }
}
