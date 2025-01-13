<?php

namespace App\Entity;

use App\Entity\Trait\ActiveTrait;
use App\Entity\Trait\EmailTrait;
use App\Entity\Trait\PdfTrait;
use App\Entity\Trait\PictureTrait;
use App\Entity\Trait\PositionTrait;
use App\Entity\Trait\TitleTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Vich\Uploadable]
class Project
{
    use ActiveTrait;
    use EmailTrait;
    use TitleTrait;
    use PictureTrait;
    use PdfTrait;
    use UpdatedAtTrait;
    use PositionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $style = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $presentation = null;

    /**
     * @var Collection<int, Calendar>
     */
    #[ORM\OneToMany(targetEntity: Calendar::class, mappedBy: 'project', orphanRemoval: true, fetch: 'EAGER')]
    private Collection $calendars;

    /**
     * @var Collection<int, Member>
     */
    #[ORM\ManyToMany(targetEntity: Member::class, inversedBy: 'project', cascade: ['persist'])]
    private Collection $members;

    /**
     * @var Collection<int, Gallery>
     */
    #[ORM\OneToMany(targetEntity: Gallery::class, mappedBy: 'project', cascade: ['persist'])]
    private Collection $galleries;

    /**
     * @var Collection<int, Formula>
     */
    #[ORM\OneToMany(targetEntity: Formula::class, mappedBy: 'project',  orphanRemoval: true)]
    private Collection $formulas;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    /**
     * @var Collection<int, YoutubeLink>
     */
    #[ORM\OneToMany(targetEntity: YoutubeLink::class, mappedBy: 'project', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $youtubeLinks;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram = null;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->galleries = new ArrayCollection();
        $this->formulas = new ArrayCollection();
        $this->youtubeLinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
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
            $calendar->setProject($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): static
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getProject() === $this) {
                $calendar->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addProject($this);
        }

        return $this;
    }

    public function removeMember(Member $member): static
    {
        if ($this->members->removeElement($member)) {
            $member->removeProject($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): static
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries->add($gallery);
            $gallery->setProject($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->galleries->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getProject() === $this) {
                $gallery->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Formula>
     */
    public function getFormulas(): Collection
    {
        return $this->formulas;
    }

    public function addFormula(Formula $formula): static
    {
        if (!$this->formulas->contains($formula)) {
            $this->formulas->add($formula);
            $formula->setProject($this);
        }

        return $this;
    }

    public function removeFormula(Formula $formula): static
    {
        if ($this->formulas->removeElement($formula)) {
            // set the owning side to null (unless already changed)
            if ($formula->getProject() === $this) {
                $formula->setProject(null);
            }
        }

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): static
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * @return Collection<int, YoutubeLink>
     */
    public function getYoutubeLinks(): Collection
    {
        return $this->youtubeLinks;
    }

    public function addYoutubeLink(YoutubeLink $youtubeLink): static
    {
        if (!$this->youtubeLinks->contains($youtubeLink)) {
            $this->youtubeLinks->add($youtubeLink);
            $youtubeLink->setProject($this);
        }

        return $this;
    }

    public function removeYoutubeLink(YoutubeLink $youtubeLink): static
    {
        if ($this->youtubeLinks->removeElement($youtubeLink)) {
            // set the owning side to null (unless already changed)
            if ($youtubeLink->getProject() === $this) {
                $youtubeLink->setProject(null);
            }
        }

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static
    {
        $this->instagram = $instagram;

        return $this;
    }
}
