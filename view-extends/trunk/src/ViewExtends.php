<?php

declare(strict_types=1);

namespace Pollen\ViewExtends;

use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Proxy\ContainerProxy;
use Pollen\Support\Proxy\FieldProxy;
use Pollen\Support\Proxy\PartialProxy;
use Pollen\Support\Proxy\ViewProxy;
use Pollen\View\ViewManagerInterface;
use Psr\Container\ContainerInterface as Container;
use Throwable;

class ViewExtends implements ViewExtendsInterface
{
    use BootableTrait;
    use ContainerProxy;
    use FieldProxy;
    use PartialProxy;
    use ViewProxy;

    /**
     * @param ViewManagerInterface $viewManager
     * @param Container|null $container
     */
    public function __construct(ViewManagerInterface $viewManager, ?Container $container = null)
    {
        $this->setViewManager($viewManager);

        if ($container !== null) {
            $this->setContainer($container);
        }

        $this->boot();
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if (!$this->isBooted()) {
            try {
                $this->field();

                $this->viewManager()->setSharedFunction(
                    'field',
                    function (string $alias, $idOrParams = null, ?array $params = null) {
                        return $this->field($alias, $idOrParams, $params)->render();
                    }
                );
            } catch (Throwable $e) {
                unset($e);
            }

            try {
                $this->partial();

                $this->viewManager()->setSharedFunction(
                    'partial',
                    function (string $alias, $idOrParams = null, ?array $params = null) {
                        return $this->partial($alias, $idOrParams, $params)->render();
                    }
                );
            } catch (Throwable $e) {
                unset($e);
            }

            $this->setBooted();
        }
    }
}