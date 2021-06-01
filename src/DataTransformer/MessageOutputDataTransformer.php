<?php

namespace App\DataTransformer;

use App\Entity\Message;
use App\Entity\Account;
use App\Dto\MessageOutput;
use App\Repository\AccountRepository;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;

class MessageOutputDataTransformer implements DataTransformerInterface
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        $messageOutput = new MessageOutput();
        $messageOutput->id = $data->getId();
        $messageOutput->account_name = $data->getAccount()->getName();
        $messageOutput->date = $data->getDate();
        $messageOutput->message = $data->getMessage();

        return $messageOutput;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return MessageOutput::class === $to && $data instanceof Message;
    }
}
