<?php

declare(strict_types=1);

namespace Kochan\FroalaEditorBundle\Twig;

use Kochan\FroalaEditorBundle\DependencyInjection\Configuration;
use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FroalaExtension extends AbstractExtension
{
    private ParameterBagInterface $parameterBag;
    private Packages $packages;

    public function __construct(ParameterBagInterface $parameterBag, Packages $packages)
    {
        $this->parameterBag = $parameterBag;
        $this->packages = $packages;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('froala_display', [$this, 'froalaDisplay'], ['is_safe' => ['html']]),
        ];
    }

    public function froalaDisplay(?string $html): string
    {
        $str = '';
        $includeCSS = $this->parameterBag->get(Configuration::NODE_ROOT . '.includeCSS');

        if ($includeCSS) {
            $basePath = $this->parameterBag->get(Configuration::NODE_ROOT . '.basePath');
            $url = $this->packages->getUrl(trim($basePath, '/') . '/' . 'css/froala_style.min.css');
            $str .= '<link href="' . $url . '" rel="stylesheet" type="text/css" />';
        }

        $str .= '<div class="fr-view">' . $html . '</div>';

        return $str;
    }
}
