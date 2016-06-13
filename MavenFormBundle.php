<?php

namespace Maven\Bundle\FormBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Maven\Bundle\FormBundle\DependencyInjection\Compiler\ContactRequestFormPass;

class MavenFormBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ContactRequestFormPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'OroCRMContactUsBundle';
    }
}
