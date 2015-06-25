<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle;

use ONGR\OXIDConnectorBundle\DependencyInjection\Compiler\SeoServicePass;
use ONGR\OXIDConnectorBundle\DependencyInjection\ONGROXIDConnectorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * OXID Connector Bundle.
 */
class ONGROXIDConnectorBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new ONGROXIDConnectorExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SeoServicePass());
    }
}
