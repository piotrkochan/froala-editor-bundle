<?php

declare(strict_types=1);

use Kochan\FroalaEditorBundle\Command\InstallCommand;
use Kochan\FroalaEditorBundle\Controller\MediaController;
use Kochan\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Kochan\FroalaEditorBundle\Service\MediaManager;
use Kochan\FroalaEditorBundle\Service\OptionManager;
use Kochan\FroalaEditorBundle\Service\PluginProvider;
use Kochan\FroalaEditorBundle\Twig\FroalaExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container->services()
        // Commands
        ->set(InstallCommand::class)
            ->tag('console.command', ['command' => 'froala:install'])

        // Controllers
        ->set(MediaController::class)
            ->arg('$mediaManager', service('Kochan_froala_editor.media_manager'))
            ->arg('$kernel', service('kernel'))
            ->public()

        // Form types
        ->set('Kochan_froala_editor.form.type')
            ->class(FroalaEditorType::class)
            ->arg('$parameterBag', service('parameter_bag'))
            ->arg('$optionManager', service('Kochan_froala_editor.option_manager'))
            ->arg('$pluginProvider', service('Kochan_froala_editor.plugin_provider'))
            ->tag('form.type')

        // Managers/providers
        ->set('Kochan_froala_editor.option_manager')
            ->class(OptionManager::class)
            ->arg('$router', service('router'))

        ->set('Kochan_froala_editor.plugin_provider')
            ->class(PluginProvider::class)

        ->set('Kochan_froala_editor.media_manager')
            ->class(MediaManager::class)
            ->public()

        // Twig extensions
        ->set('Kochan_froala_editor.froala_extension')
            ->class(FroalaExtension::class)
            ->arg('$parameterBag', service('parameter_bag'))
            ->arg('$packages', service('assets.packages'))
            ->tag('twig.extension')
    ;
};
