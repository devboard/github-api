<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory\Status;

use DevboardLib\GitHub\External\ExternalService;
use DevboardLib\GitHub\External\Service\CodeCoverage\CodeCovIo;
use DevboardLib\GitHub\External\Service\CodeCoverage\CoverallsIo;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\AppVeyor;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\CircleCi;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\CodeClimate;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\FabbotIo;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\Shippable;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\StyleCi;
use DevboardLib\GitHub\External\Service\ContinuousIntegration\TravisCi;
use DevboardLib\GitHub\External\Service\UnknownService;
use DevboardLib\GitHub\Status\StatusContext;

/**
 * @deprecated Remove in version 2.0, please use the one from lib-github!
 */
class ExternalServiceFactory
{
    /** @var array */
    private static $regex = ['|^ci/circleci|' => CircleCi::class, '|^codecov|' => CodeCovIo::class];

    /** @var array */
    private static $text = [
        'coverage/coveralls'                     => CoverallsIo::class,
        'continuous-integration/travis-ci/pr'    => TravisCi::class,
        'continuous-integration/travis-ci/push'  => TravisCi::class,
        'continuous-integration/travis-ci'       => TravisCi::class,
        'continuous-integration/appveyor/branch' => AppVeyor::class,
        'continuous-integration/appveyor/pr'     => AppVeyor::class,
        'fabbot.io'                              => FabbotIo::class,
        'continuous-integration/styleci/push'    => StyleCi::class,
        'codeclimate'                            => CodeClimate::class,
        // @TODO: is this really OK?
        'default'   => FabbotIo::class,
        'Shippable' => Shippable::class,
    ];

    public function create(StatusContext $context): ExternalService
    {
        foreach (self::$text as $pattern => $class) {
            if ($pattern === $context->getValue()) {
                return new $class($context);
            }
        }

        foreach (self::$regex as $pattern => $class) {
            if (preg_match($pattern, $context->getValue())) {
                return new $class($context);
            }
        }

        return new UnknownService($context);
    }

    public function createFromString(string $name): ExternalService
    {
        return $this->create(new StatusContext($name));
    }
}
