<?php

namespace App\Entity;

use App\Entity\Trait\PictureTrait;
use App\Entity\Trait\TitleTrait;
use App\Entity\Trait\UrlTrait;
use App\Repository\PartnerRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
#[Vich\Uploadable]
class Partner
{
    use TitleTrait;
    use PictureTrait;
    use UrlTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
