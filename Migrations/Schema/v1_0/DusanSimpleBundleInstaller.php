<?php

namespace Dusan\Bundle\SimpleBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class DusanSimpleBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createSimplecrudTable($schema);

        /** Foreign keys generation **/
    }

    /**
     * Create simple_crud table
     *
     * @param Schema $schema
     */
    protected function createSimplecrudTable(Schema $schema)
    {
        $table = $schema->createTable('simple_crud');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('firstname', 'string', ['length' => 255]);
        $table->addColumn('lastname', 'string', ['length' => 255]);
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);
    }
}
