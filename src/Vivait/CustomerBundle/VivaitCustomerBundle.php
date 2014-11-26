<?php

namespace Vivait\CustomerBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class VivaitCustomerBundle extends Bundle
{
    private static $hasTypes = false;

    public static function addTypes()
    {
        self::$hasTypes = true;

        Type::addType('email', 'Vivait\CustomerBundle\Type\EmailType');
        Type::addType('gender', 'Vivait\CustomerBundle\Type\GenderType');
        Type::addType('title', 'Vivait\CustomerBundle\Type\TitleType');
    }

    public function boot()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        if (!self::$hasTypes) {
            self::addTypes();
        }

        /** @var AbstractPlatform $platform */
        $platform = $em->getConnection()->getDatabasePlatform();

        $platform->registerDoctrineTypeMapping('Email', 'email');
        $platform->registerDoctrineTypeMapping('Gender', 'gender');
        $platform->registerDoctrineTypeMapping('Title', 'title');
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->registerModel($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerModel(ContainerBuilder $container)
    {
        $modelDir = realpath(__DIR__);
        $mappings = array(
            __NAMESPACE__ . '\Model' => $modelDir . '/Model/',
        );

        $container->addCompilerPass(
        // Replace with 'DoctrineOrmMappingsPass' when using DoctrineBundle 1.3
        // See: https://github.com/doctrine/DoctrineBundle/issues/283
            self::createAnnotationMappingDriver(
                array_keys($mappings),
                $mappings,
                [],
                false
            )
        );
    }

    private static function createAnnotationMappingDriver(
        array $namespaces,
        array $directories,
        array $managerParameters = array(),
        $enabledParameter = false
    ) {
        $reader = new Reference('annotation_reader');
        $driver = new Definition('Doctrine\ORM\Mapping\Driver\AnnotationDriver', array($reader, $directories));

        return new DoctrineOrmMappingsPass($driver, $namespaces, $managerParameters, $enabledParameter);
    }
}
