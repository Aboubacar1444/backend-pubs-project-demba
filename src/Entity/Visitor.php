<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorRepository::class)]
class Visitor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ipAddress = null;


    #[ORM\ManyToOne(inversedBy: 'visitors')]
    private ?Video $video = null;

    #[ORM\Column(length: 255)]
    private ?string $clientUniqueId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deviceType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): static
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }



    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): static
    {
        $this->video = $video;

        return $this;
    }


    public function getClientUniqueId(): ?string
    {
        return $this->clientUniqueId;
    }

    public function setClientUniqueId(string $clientUniqueId): static
    {
        $this->clientUniqueId = $clientUniqueId;

        return $this;
    }



    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    public function setDeviceType(?string $deviceType): static
    {
        $this->deviceType = $deviceType;

        return $this;
    }
    public function serialize(): array|string
    {
        return [
            'id' => $this->id,
            'videoName' => $this->video->getName(),
            'clientUniqueId' => $this->clientUniqueId,
            'ipAddress' => $this->ipAddress,
            'deviceType' => $this->deviceType,
        ];
    }
}
