<?php

namespace App\DoctrineType;

use App\Factory\ImageboardClientFactory;
use DesuProject\ChanbooruInterface\PostInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use function App\getImageboardByPost;

class ImageboardPostType extends Type
{
    public const TYPE = 'imageboard_post';

    /**
     * @param PostInterface|null $value
     * @param AbstractPlatform   $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return json_encode([
            'id' => $value->getId(),
            'imageboard' => getImageboardByPost($value),
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $value = json_decode($value, true);

        $client = ImageboardClientFactory::create($value['imageboard']);

        return $client->getPostById($value['id']);
    }

    public function getName()
    {
        return self::TYPE;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
