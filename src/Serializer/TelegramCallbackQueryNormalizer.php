<?php

namespace App\Serializer;

use App\Enum\Imageboard;
use App\Enum\ReportKeyboardAction;
use App\Factory\ImageboardClientFactory;
use App\ValueObject\TelegramCallbackQuery;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class TelegramCallbackQueryNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (!$this->supportsDenormalization($data, $class, $format)) {
            throw new InvalidArgumentException('Could not denormalize the data');
        }

        $postData = json_decode($data['callback_query']['data'], true);

        $client = ImageboardClientFactory::create(new Imageboard($postData['ib']));
        $post = $client->getPostById($postData['pi']);

        return new TelegramCallbackQuery(
            $data['update_id'],
            $data['callback_query']['id'],
            $data['callback_query']['message']['chat']['id'],
            $data['callback_query']['message']['message_id'],
            $data['callback_query']['from']['username'],
            $data['callback_query']['from']['id'],
            $post,
            new ReportKeyboardAction($postData['ac'])
        );
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $format === JsonEncoder::FORMAT && $type === TelegramCallbackQuery::class;
    }
}
