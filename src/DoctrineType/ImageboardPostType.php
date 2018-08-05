<?php

namespace App\DoctrineType;

use App\Factory\DanbooruClientFactory;
use DesuProject\ChanbooruInterface\PostInterface;
use DesuProject\DanbooruSdk\Post;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use RuntimeException;
use const App\IMAGEBOARD_DANBOORU;
use function App\getImageboardByPost;

class ImageboardPostType extends Type
{
    const TYPE = 'imageboard_post';

    /**
     * @param PostInterface|null $value
     * @param AbstractPlatform   $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }

        return json_encode([
            'id' => $value->getId(),
            'imageboard' => getImageboardByPost($value),
        ]);
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }

        $value = json_decode($value, true);

        switch ($value['imageboard']) {
            case IMAGEBOARD_DANBOORU:
                $post = Post::byId(
                    DanbooruClientFactory::create(),
                    $value['id']
                );

                break;

            default:
                throw new RuntimeException('Unknown imageboard type');
        }

        return $post;
    }

    public function getName()
    {
        return self::TYPE;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
