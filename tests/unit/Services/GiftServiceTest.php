<?php


namespace App\Tests\unit\Services;

use App\Entity\Gift;
use App\Repository\GiftRepository;
use App\Services\GiftService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class GiftServiceTest extends TestCase
{
    public CONST VALID_FILE_PATH = 'tests/unit/Services/documents/valid_file.csv';
    public CONST INVALID_FILE_PATH = 'tests/unit/Services/documents/invalid_file.csv';
    public CONST DUPLICATE_UUID_FILE_PATH = 'tests/unit/Services/documents/duplicate_uuid_file.csv';

    public function testPopulateSuccess(): void
    {
        $file = new UploadedFile(self::VALID_FILE_PATH, 'valid_file.csv', 'text/plain');

        $em = $this->prophesize(EntityManagerInterface::class);
        $giftRepository = $this->prophesize(GiftRepository::class);


        $em->persist(Argument::type(Gift::class))->shouldBeCalledTimes(2);
        $em->flush()->shouldBeCalled();

        $giftService = new GiftService($giftRepository->reveal(), $em->reveal());
        $result = $giftService->populate($file);

        self::assertSame(["saved" => 2, "ignored"=> 0], $result);
    }


    public function testPopulateNotSaveData(): void
    {
        $file = new UploadedFile(self::INVALID_FILE_PATH, 'invalid_file.csv', 'text/plain');

        $em = $this->prophesize(EntityManagerInterface::class);
        $giftRepository = $this->prophesize(GiftRepository::class);


        $em->persist(Argument::type(Gift::class))->shouldNotBeCalled();
        $em->flush()->shouldBeCalled();

        $giftService = new GiftService($giftRepository->reveal(), $em->reveal());
        $result = $giftService->populate($file);

        self::assertSame(["saved" => 0, "ignored"=> 2], $result);
    }


    public function testPopulateFail(): void
    {
        $file = new UploadedFile(self::DUPLICATE_UUID_FILE_PATH, 'duplicate_uuid_file.csv', 'text/plain');

        $em = $this->prophesize(EntityManagerInterface::class);
        $giftRepository = $this->prophesize(GiftRepository::class);

        $uniqueConstraintViolationException =  $this->prophesize(UniqueConstraintViolationException::class);

        $em->persist(Argument::type(Gift::class))->shouldBeCalled(2);
        $em->flush()->shouldBeCalled()->willThrow($uniqueConstraintViolationException->reveal());

        $giftService = new GiftService($giftRepository->reveal(), $em->reveal());
        $result = $giftService->populate($file);

        self::assertSame(
            [
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'UUID unique constraint violation, please check verify your file for uuid duplication !'
            ],
            $result);
    }


}