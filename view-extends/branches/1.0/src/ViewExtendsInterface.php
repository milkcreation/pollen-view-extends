<?php

declare(strict_types=1);

namespace Pollen\ViewExtends;

use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\FieldProxyInterface;
use Pollen\Support\Proxy\PartialProxyInterface;

interface ViewExtendsInterface extends
    BootableTraitInterface,
    ContainerProxyInterface,
    FieldProxyInterface,
    PartialProxyInterface
{
    /**
     * Booting.
     *
     * @return void
     */
    public function boot(): void;
}