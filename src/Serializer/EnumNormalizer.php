<?php

namespace App\Serializer;

use MyCLabs\Enum\Enum;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EnumNormalizer implements NormalizerInterface
{
    /**
     * @param Enum  $object
     * @param null  $format
     * @param array $context
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$this->supportsNormalization($object, $format)) {
            throw new InvalidArgumentException('Could not normalize the object');
        }

        return $object->getValue();
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Enum;
    }
}
