<?php

declare(strict_types=1);

namespace Kochan\FroalaEditorBundle\Tests\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ConfigurationTest extends KernelTestCase
{
    public function testLoad(): void
    {
        // Make sure default config loads without issues
        self::bootKernel();
        self::assertSame([], self::getContainer()->getParameter('kochan_froala_editor.profiles'));
    }
}
