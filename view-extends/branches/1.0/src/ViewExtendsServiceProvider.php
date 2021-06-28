<?php

declare(strict_types=1);

namespace Pollen\ViewExtends;

use Pollen\Container\BootableServiceProvider;
use Pollen\View\ViewManagerInterface;
use Pollen\ViewExtends\Extensions\FakerViewExtension;
use Pollen\ViewExtends\Extensions\FieldViewExtension;
use Pollen\ViewExtends\Extensions\PartialViewExtension;

class ViewExtendsServiceProvider extends BootableServiceProvider
{
    protected $provides = [
        ViewExtendsInterface::class
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->getContainer()->get(ViewExtendsInterface::class);
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(ViewExtendsInterface::class, function () {
           return new ViewExtends($this->getContainer()->get(ViewManagerInterface::class), $this->getContainer());
        });

        $this->getContainer()->share(FakerViewExtension::class, function () {
            return new FakerViewExtension('faker', $this->getContainer());
        });

        $this->getContainer()->share(FieldViewExtension::class, function () {
            return new FieldViewExtension('field', $this->getContainer());
        });

        $this->getContainer()->share(PartialViewExtension::class, function () {
            return new PartialViewExtension('partial', $this->getContainer());
        });
    }
}
