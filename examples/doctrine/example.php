<?php declare(strict_types=1);

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;

use Example\DoctrineUserStatusType;
use Example\UserEntity;
use Example\UserStatus;

require __DIR__ . '/vendor/autoload.php';

// initialize doctrine
$config = new Configuration();
$config->setProxyDir(sys_get_temp_dir());
$config->setProxyNamespace('DoctrineProxies');
$config->setAutoGenerateProxyClasses(true);
$config->setMetadataDriverImpl($config->newDefaultAnnotationDriver([__DIR__ . '/src'], false));
$em = EntityManager::create(['driver' => 'pdo_sqlite', 'uri' => 'sqlite:///:memory:'], $config);
$em->getConnection()->executeStatement('CREATE TABLE User (name TEXT NOT NULL, status TEXT NOT NULL)');

// register custom doctrine type
Type::addType('UserStatus', DoctrineUserStatusType::class);
$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('UserStatus', 'UserStatus');

// create user
$user = new UserEntity('test-user');
$em->persist($user);
$em->flush();
$em->clear();

// fetch user
$query = $em->createQuery("SELECT u FROM Example\\UserEntity u WHERE u.status = 'active'");
$user = $query->getSingleResult();
var_dump(
    $user->getId(),     // "1"
    $user->getName(),   // "test-user"
    $user->getStatus()  // Example\UserStatus Object ( value => "active", name => "ACTIVE" )
);

// ban user
$user->setStatus(UserStatus::BANNED());
$em->persist($user);
$em->flush();
$em->clear();
var_dump(
    $user->getId(),     // "1"
    $user->getName(),   // "test-user"
    $user->getStatus()  // Example\UserStatus Object ( value => "banned", name => "BANNED" )
);
