<?php declare(strict_types=1);

namespace Example;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class DoctrineUserStatusType extends Type
{
    public function getName(): string
    {
        return 'UserStatus';
    }

    /**
     * @param mixed[] $fieldDeclaration
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        if ($platform instanceof MySqlPlatform) {
            return 'ENUM(' . \implode(',', UserStatus::cases()) . ')';
        }

        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param mixed $value
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof UserStatus) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                [UserStatus::class, 'NULL']
            );
        }

        return $value->value;
    }

    /**
     * @param mixed $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserStatus
    {
        if (null === $value) {
            return null;
        }

        $userStatus = UserStatus::tryFrom($value);
        if (!$userStatus) {
            throw ConversionException::conversionFailedInvalidType(
                $value,
                $this->getName(),
                [UserStatus::class, 'NULL']
            );
        }

        return $userStatus;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
