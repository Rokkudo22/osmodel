<?php

namespace App\Manager;

use App\Client\APIClient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractManager
{
    protected $index = '';

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var APIClient
     */
    private $client;

    /**
     * @var string
     */
    private $class;

    public function __construct(ObjectManager $objectManager, APIClient $client, string $class)
    {
        $this->objectManager = $objectManager;
        $this->client = $client;
        $this->class = $class;
    }

    public function getPagerfanta(array $criteria): Pagerfanta
    {
        $qb = $this->getRepository()->getSearchQuery($criteria);
        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pagerfanta->setCurrentPage($criteria['page']);
        $pagerfanta->setMaxPerPage($criteria['limit']);

        return $pagerfanta;
    }

    public function getClass()
    {
        if (false !== strpos($this->class, ':')) {
            $metadata = $this->objectManager->getClassMetadata($this->class);
            $this->class = $metadata->getName();
        }

        return $this->class;
    }

    public function list(): ?array
    {
        return $this->client->list($this->index);
    }

    protected function getRepository(): ObjectRepository
    {
        return $this->objectManager->getRepository($this->getClass());
    }
}
