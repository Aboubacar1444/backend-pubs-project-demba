<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $views = 0;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $video = null;

    /**
     * @var Collection<int, Visitor>
     */
    #[ORM\OneToMany(targetEntity: Visitor::class, mappedBy: 'video')]
    private Collection $visitors;

    public function __construct()
    {
        $this->visitors = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): static
    {
        $this->views = $views;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    #[ORM\PrePersist()]
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }



    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): static
    {
        $this->video = $video;

        return $this;
    }


    public function serialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'video' => $this->video,
            'views' => $this->views,
            'createdAt' => $this->createdAt,
        ];
    }

    /**
     * @return Collection<int, Visitor>
     */
    public function getVisitors(): Collection
    {
        return $this->visitors;
    }

    public function addVisitor(Visitor $visitor): static
    {
        if (!$this->visitors->contains($visitor)) {
            $this->visitors->add($visitor);
            $visitor->setVideo($this);
        }

        return $this;
    }

    public function removeVisitor(Visitor $visitor): static
    {
        if ($this->visitors->removeElement($visitor)) {
            // set the owning side to null (unless already changed)
            if ($visitor->getVideo() === $this) {
                $visitor->setVideo(null);
            }
        }

        return $this;
    }




}
