<?php

namespace Maven\Bundle\FormBundle\Migrations\Schema;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\MigrationBundle\Migration\Installation;

use Maven\Bundle\FormBundle\Migrations\Schema\v1_0\UpdateWorkflowItemStepData;

/**
 * @package Maven\Bundle\FormBundle\Migrations\Schema
 */
class MavenFormBundleInstaller implements Installation, ContainerAwareInterface
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

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
        if ($this->container->hasParameter('installed') && $this->container->getParameter('installed')) {
            $queries->addPreQuery(new UpdateWorkflowItemStepData());
        }
    }
}
