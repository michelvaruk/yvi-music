<?php

namespace App\Entity;

use App\Entity\Trait\DescriptionTrait;
use App\Entity\Trait\LogoTrait;
use App\Entity\Trait\PhoneTrait;
use App\Entity\Trait\PictureTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\SiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[Vich\Uploadable]
class Site
{
    use LogoTrait;
    use PictureTrait;
    use UpdatedAtTrait;
    use PhoneTrait;
    use DescriptionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
