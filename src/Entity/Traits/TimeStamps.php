<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimeStamps
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    /**
     * @ORM\PrePersist()
     */
    public function createdAt(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }
}