<?php

declare(strict_types=1);

namespace Pollen\ViewExtends;

use Pollen\Container\BootableServiceProvider;
use Pollen\View\ViewManagerInterface;

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
    }
}
