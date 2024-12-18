<?php

namespace App\Entity;

use App\Entity\Trait\AddressTrait;
use App\Entity\Trait\DescriptionTrait;
use App\Entity\Trait\EmailTrait;
use App\Entity\Trait\PhoneTrait;
use App\Entity\Trait\TitleTrait;
use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    use AddressTrait;
    use TitleTrait;
    use PhoneTrait;
    use EmailTrait;
    use DescriptionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Calendar>
     */
    #[ORM\OneToMany(targetEntity: Calendar::class, mappedBy: 'place')]
    private Collection $calendars;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Calendar>
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): static
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars->add($calendar);
            $calendar->setPlace($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): static
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getPlace() === $this) {
                $calendar->setPlace(null);
            }
        }

        return $this;
    }
}
