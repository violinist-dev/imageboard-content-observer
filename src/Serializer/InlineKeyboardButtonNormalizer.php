<?php

namespace App\Serializer;

use App\ValueObject\InlineKeyboardButton;
use Spatie\Emoji\Emoji;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function App\getImageboardByPost;

class InlineKeyboardButtonNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param InlineKeyboardButton $object
     * @param string               $format
     * @param array                $context
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = [])
    {
        if (!$this->supportsNormalization($object, $format)) {
            throw new InvalidArgumentException('Could not normalize the object');
        }

        $callbackData = json_encode([
            'ib' => getImageboardByPost($object->getImageboardPost()),
            'pi' => $object->getImageboardPost()->getId(),
            'ac' => $object->getAction(),
        ]);

        $label = $object->isActive()
            ? (Emoji::okHandSign() . ' ' . $object->getLabel() . ' ' . Emoji::okHandSign())
            : $object->getLabel();

        return $this->normalizer->normalize([
            'text' => $label,
            'callback_data' => $callbackData,
        ]);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $format === JsonEncoder::FORMAT && $data instanceof InlineKeyboardButton;
    }
}
