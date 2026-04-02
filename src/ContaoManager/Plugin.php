<?php

declare(strict_types=1);

namespace CliffParnitzky\DirectContentElements\ContaoManager;

use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use CliffParnitzky\DirectContentElements\CliffParnitzkyDirectContentElementsBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(CliffParnitzkyDirectContentElementsBundle::class)->setLoadAfter(
                [
                    ContaoCoreBundle::class,
                    ContaoCalendarBundle::class,
                    ContaoNewsBundle::class,
                ]
            )
        ];
    }
}
