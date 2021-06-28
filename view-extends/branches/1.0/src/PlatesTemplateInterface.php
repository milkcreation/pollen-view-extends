<?php

declare(strict_types=1);

namespace Pollen\ViewExtends;

use Pollen\View\Engines\Plates\PlatesTemplateInterface as BasePlatesTemplateInterface;

/**
 * @method string field(string $alias, string|array $idOrParams = null, array|null $params = null)
 * @method string faker(string $formatter, ...$args)
 * @method string partial(string $alias, string|array $idOrParams = null, array|null $params = null)
 */
interface PlatesTemplateInterface extends BasePlatesTemplateInterface
{
}