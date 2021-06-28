<?php

declare(strict_types=1);

namespace Pollen\ViewExtends\Extensions;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Pollen\View\Engines\Plates\PlatesViewEngine;
use Pollen\View\Engines\Twig\TwigViewEngine;
use Pollen\View\ViewEngineInterface;
use Pollen\View\ViewExtension;
use Pollen\ViewBlade\BladeViewEngine;
use Twig\TwigFunction;

class FakerViewExtension extends ViewExtension
{
    protected ?string $locale = null;

    protected ?FakerGenerator $faker = null;

    /**
     * @inheritDoc
     */
    public function register(ViewEngineInterface $viewEngine)
    {
        if ($viewEngine instanceof PlatesViewEngine) {
            $viewEngine->platesEngine()->registerFunction(
                $this->getName(),
                function (...$args) {
                    return $this->getFormatter(...$args);
                }
            );
        }

        if ($viewEngine instanceof TwigViewEngine) {
            $viewEngine->twigEnvironment()->addFunction(
                new TwigFunction(
                    $this->getName(),
                    function (...$args) {
                        return $this->getFormatter(...$args);
                    },
                    [
                        'is_safe' => ['html'],
                    ]
                )
            );
        }

        if ($viewEngine instanceof BladeViewEngine) {
            $viewEngine->blade()->directive(
                $this->getName(),
                function ($expression) {
                    /** @var array $args */
                    $args = array_map(
                        function ($arg) {
                            eval('$param=' . trim($arg) . ';');

                            /** @var array $param */
                            return $param;
                        },
                        explode(',', $expression)
                    );

                    return $this->getFormatter(...$args);
                }
            );
        }

        return null;
    }

    /**
     * Get Facker Generator instance
     *
     * @return FakerGenerator
     */
    public function faker(): FakerGenerator
    {
        if ($this->faker === null) {
            $this->faker = FakerFactory::create($this->locale ?? FakerFactory::DEFAULT_LOCALE);
        }

        return $this->faker;
    }

    /**
     * Set Faker generator locale.
     *
     * @param string $locale
     *
     * @return $this
     */
    public function setFakerLocale(string $locale): self
    {
        $this->locale = $locale;
        $this->faker = null;

        return $this;
    }

    /**
     * Get Faker formatter.
     * @see https://fakerphp.github.io/formatters/
     *
     * @param string $formatter
     * @param ...$args
     *
     * @return string
     */
    protected function getFormatter(string $formatter, ...$args): string
    {
        return $this->faker()->$formatter(...$args);
    }
}