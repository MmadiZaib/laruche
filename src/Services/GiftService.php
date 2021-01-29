<?php

namespace App\Services;

use App\Entity\Gift;
use App\Repository\GiftRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GiftService
{
    /**
     * @var GiftRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        GiftRepository $repository,
        EntityManagerInterface $em
    )
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    public function getGiftStats(): array
    {
        try {
            return $this->repository->getStats();
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }


    public function populate(UploadedFile $file): array
    {
        $serializer= $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $data = $serializer->decode(file_get_contents($file), 'csv', [CsvEncoder::DELIMITER_KEY => ',']);

        $saved = 0;

        foreach ($data as $line) {
            if (
                !array_key_exists('gift_uuid', $line)
                || !array_key_exists('gift_code', $line)
                || !array_key_exists('gift_description', $line)
                || !array_key_exists('gift_price', $line)
                || !array_key_exists('receiver_uuid', $line)
                || !array_key_exists('receiver_first_name', $line)
                || !array_key_exists('receiver_last_name', $line)
                || !array_key_exists('receiver_country_code', $line)
            ) {

                continue;
            }

            $this->em->persist(Gift::createFromCsv($line));

            $saved++;
        }

        try {
            $this->em->flush();
        } catch (UniqueConstraintViolationException $e) {
            return [
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'UUID unique constraint violation, please check verify your file for uuid duplication !',
            ];
        }

        return [
            'saved' => $saved,
            'ignored' =>  count($data) - $saved
        ];
    }
}