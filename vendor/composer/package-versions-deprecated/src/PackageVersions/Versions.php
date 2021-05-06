<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = '__root__';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6',
  'doctrine/cache' => '1.11.0@a9c1b59eba5a08ca2770a76eddb88922f504e8e0',
  'doctrine/dbal' => '3.1.0@5ba62e7e40df119424866064faf2cef66cb5232a',
  'doctrine/deprecations' => 'v0.5.3@9504165960a1f83cc1480e2be1dd0a0478561314',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '2.0.3@9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
  'illuminate/bus' => 'v8.40.0@7b5c0f1aa52cc70259352ff6b7adb67c7d46bcc5',
  'illuminate/cache' => 'v8.40.0@267a541171a375d56622117fbd0a60515402f2ef',
  'illuminate/collections' => 'v8.40.0@deccb956d38710f3f8baf36dd876c3fa1585ec22',
  'illuminate/container' => 'v8.40.0@0e38ee1632d470e56aece0079e6e22d13e6bea8e',
  'illuminate/contracts' => 'v8.40.0@5152041a5c4ac4dbebb3c8ee72d05666c592ae08',
  'illuminate/database' => 'v8.40.0@742c062a6447278f6b6f8622bd649173ed51fa3a',
  'illuminate/events' => 'v8.40.0@bd2941d4d55f5d357b203dc2ed81ac5c138593dc',
  'illuminate/filesystem' => 'v8.40.0@8ef5902052c5b3bb4a6c1c3afc399f30e7723cb8',
  'illuminate/macroable' => 'v8.40.0@300aa13c086f25116b5f3cde3ca54ff5c822fb05',
  'illuminate/pipeline' => 'v8.40.0@23aeff5b26ae4aee3f370835c76bd0f4e93f71d2',
  'illuminate/support' => 'v8.40.0@ce1682ef73ab28a61be01c24ec5b090bdf2c3256',
  'illuminate/view' => 'v8.40.0@696a1d6d2213be192429e97245a3d2bb4d6d1849',
  'nesbot/carbon' => '2.47.0@606262fd8888b75317ba9461825a24fc34001e1e',
  'psr/container' => '1.1.1@8622567409010282b7aeebe4bb841fe98b58dcaf',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'symfony/console' => 'v5.2.7@90374b8ed059325b49a29b55b3f8bb4062c87629',
  'symfony/finder' => 'v5.2.4@0d639a0943822626290d169965804f79400e6a04',
  'symfony/polyfill-ctype' => 'v1.22.1@c6c942b1ac76c82448322025e084cadc56048b4e',
  'symfony/polyfill-intl-grapheme' => 'v1.22.1@5601e09b69f26c1828b13b6bb87cb07cddba3170',
  'symfony/polyfill-intl-normalizer' => 'v1.22.1@43a0283138253ed1d48d352ab6d0bdb3f809f248',
  'symfony/polyfill-mbstring' => 'v1.22.1@5232de97ee3b75b0360528dae24e73db49566ab1',
  'symfony/polyfill-php73' => 'v1.22.1@a678b42e92f86eca04b7fa4c0f6f19d097fb69e2',
  'symfony/polyfill-php80' => 'v1.22.1@dc3063ba22c2a1fd2f45ed856374d79114998f91',
  'symfony/service-contracts' => 'v2.4.0@f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb',
  'symfony/string' => 'v5.2.6@ad0bd91bce2054103f5eaa18ebeba8d3bc2a0572',
  'symfony/translation' => 'v5.2.7@e37ece5242564bceea54d709eafc948377ec9749',
  'symfony/translation-contracts' => 'v2.4.0@95c812666f3e91db75385749fe219c5e494c7f95',
  'voku/portable-ascii' => '1.5.6@80953678b19901e5165c56752d087fc11526017c',
  'woocommerce/action-scheduler' => '3.1.6@275d0ba54b1c263dfc62688de2fa9a25a373edf8',
  '__root__' => 'dev-master@fbabb2b83e0c9d26c2d7cb09cc06ebf21ab5a81b',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
