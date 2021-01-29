<?php

namespace App\Entity;

use App\Entity\Traits\TimeStamps;
use App\Repository\GiftRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GiftRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Gift
{
    use TimeStamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="uuid", length=255, unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $receiverUuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $receiverFirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $receiverLastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReceiverUuid()
    {
        return $this->receiverUuid;
    }

    public function setReceiverUuid(string $receiverUuid): self
    {
        $this->receiverUuid = $receiverUuid;

        return $this;
    }

    public function getReceiverFirstName(): ?string
    {
        return $this->receiverFirstName;
    }

    public function setReceiverFirstName(string $receiverFirstName): self
    {
        $this->receiverFirstName = $receiverFirstName;

        return $this;
    }

    public function getReceiverLastName(): ?string
    {
        return $this->receiverLastName;
    }

    public function setReceiverLastName(string $receiverLastName): self
    {
        $this->receiverLastName = $receiverLastName;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }


    public static function createFromCsv(array $data): self
    {
        $gift = new self();
        $gift->setUuid($data['gift_uuid'])
            ->setCode($data['gift_code'])
            ->setPrice($data['gift_price'])
            ->setReceiverUuid($data['receiver_uuid'])
            ->setReceiverFirstName($data['receiver_first_name'])
            ->setReceiverLastName($data['receiver_last_name'])
            ->setReceiverLastName($data['receiver_last_name'])
            ->setCountryCode($data['receiver_country_code']);

        return $gift;
    }
}
