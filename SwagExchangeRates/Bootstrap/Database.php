<?php declare(strict_types = 1);

namespace SwagExchangeRates\Bootstrap;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use SwagExchangeRates\Models\RatesModel;

/**
 * Class Database
 * @package SwagExchangeRates\Bootstrap
 */
class Database
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;
    private SchemaTool $schemaTool;

    /**
     * Database constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schemaTool = new SchemaTool($this->entityManager);
    }

    /**
     *
     */
    public function install()
    {
        $this->schemaTool->updateSchema($this->getClassesMetaData(), true);
    }

    /**
     *
     */
    public function uninstall()
    {
        $this->schemaTool->dropSchema($this->getClassesMetaData());
    }

    /**
     * @return array
     */
    private function getClassesMetaData(): array
    {
        return [
            $this->entityManager->getClassMetadata(RatesModel::class)
        ];
    }
}