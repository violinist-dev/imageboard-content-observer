<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class InlineKeyboardMarkupNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (!$this->supportsDenormalization($data, $class, $format)) {
            throw new InvalidArgumentException('Could not denormalize the data');
        }

        return new InlineKeyboardMarkup($data);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $format === JsonEncoder::FORMAT && $type === InlineKeyboardMarkup::class;
    }
}
