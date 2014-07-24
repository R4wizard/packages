<?php

namespace Terramar\Packages\Plugin\Satis;

use Composer\Satis\Satis;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Terramar\Packages\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    /**
     * Configure the given ContainerBuilder
     *
     * This method allows a plugin to register additional services with the
     * service container.
     *
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function configure(ContainerBuilder $container)
    {
        $container->register('packages.plugin.satis.subscriber', 'Terramar\Packages\Plugin\Satis\EventSubscriber')
            ->addArgument(new Reference('packages.helper.resque'))
            ->addArgument(new Reference('doctrine.orm.entity_manager'))
            ->addTag('kernel.event_subscriber');

        $container->register('packages.plugin.satis.config_helper', 'Terramar\Packages\Plugin\Satis\ConfigurationHelper')
            ->addArgument(new Reference('doctrine.orm.entity_manager'))
            ->addArgument('%app.root_dir%')
            ->addArgument('%app.cache_dir%');
    }

    /**
     * Get the plugin name
     *
     * @return string
     */
    public function getName()
    {
        return 'Satis (' . Satis::VERSION . ')';
    }
}