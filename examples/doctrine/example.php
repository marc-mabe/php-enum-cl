<?php declare(strict_types=1);

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

use Example\DoctrineUserStatusType;
use Example\UserEntity;
use Example\UserStatus;

require __DIR__ . '/vendor/autoload.php';

// initialize doctrine
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/src'], true, null, null, false);
$em = EntityManager::create(['driver' => 'pdo_sqlite', 'uri' => 'sqlite:///:memory:'], $config);
$em->getConnection()->exec('CREATE TABLE User (name TEXT NOT NULL, status TEXT NOT NULL)');


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
    $user->getId(),    // "1"
    $user->getName(),  // "test-user"
    $user->getStatus() // object(Example\UserStatus) { value = "active", name = "ACTIVE" }
);

// ban user
$user->setStatus(UserStatus::BANNED());
$em->persist($user);
$em->flush();
$em->clear();
var_dump(
    $user->getId(),    // "1"
    $user->getName(),  // "test-user"
    $user->getStatus() // object(Example\UserStatus) { value = "banned", name = "BANNED" }
);
