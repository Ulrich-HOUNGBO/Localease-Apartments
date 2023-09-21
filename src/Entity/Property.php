<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:property'],
        'openapi_definition_name'=> 'ReadCollection'],
    denormalizationContext: ['groups' => ['write:property'],
        'openapi_definition_name'=> 'WriteItem'],
    order: ['updatedAt' => 'DESC'],
    paginationItemsPerPage: 9,
    paginationMaximumItemsPerPage: 9,
)]

#[GetCollection(normalizationContext: ['groups' => ['read:property'],
                                       'openapi_definition_name' => 'ReadCollection'],)]
#[Post(normalizationContext: ['groups' => ['write:property'],
                              'openapi_definition_name' => 'PostProperty'],
      security: "is_granted('ROLE_USER')",)]
#[Get(normalizationContext: ['groups' => ['read:property:item'],
                             'openapi_definition_name' => 'GetProperty'],)]
#[Put(
    denormalizationContext: ['groups' => ['write:property:item'],
                             'openapi_definition_name' => 'PutProperty'],
    security: "is_granted('ROLE_USER')",
    validationContext: ['Default', 'put'],
)]
#[Patch(
    denormalizationContext: ['groups' => ['write:property:patch'],
                             'openapi_definition_name' => 'PatchProperty'],
    security: "is_granted('ROLE_USER')",
    validationContext: ['Default', 'patch'],)]
#[Delete( security: "is_granted('ROLE_USER')",)]

#[ApiFilter(RangeFilter::class, properties: ['price'])]
#[ApiFilter(SearchFilter::class, properties: ['city.name' => 'exact', 'town.name' => 'exact', 'type.title' => 'exact',
    'status.title' => 'exact', 'name' => 'partial', 'bedNumber' => 'exact', 'bathNumber' => 'exact', 'square' => 'exact'])]

class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:property", "read:property:item", "write:property"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?City $city = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?Town $town = null;

    #[ORM\Column]
    #[Groups(["read:property","write:property"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item", "write:property"])]
    private ?bool $isOnline = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: Illustration::class)]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private Collection $illustrations;

    #[ORM\Column]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?PropertyType $type = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?PropertyStatus $status = null;

    #[ORM\ManyToMany(targetEntity: Feature::class, inversedBy: 'properties')]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private Collection $feature;

    #[ORM\Column]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?int $bathNumber = null;

    #[ORM\Column]
    #[Groups(["read:property", "read:property:item", "write:property", "write:property:item"])]
    private ?int $bedNumber = null;

    #[ORM\Column]
    #[Groups(["read:property", "write:property", "write:property:item"])]
    private ?int $square = null;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: ScheduleRequest::class)]
    private Collection $scheduleRequests;

    public function __construct()
    {
        $this->illustrations = new ArrayCollection();
        $this->feature = new ArrayCollection();
        $this->scheduleRequests = new ArrayCollection();
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

        // Mettre à jour le slug basé sur le nouveau nom
        $slug = strtolower(str_replace(' ', '-', $name));
        $this->setSlug($slug);

        return $this;
    }



    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getTown(): ?Town
    {
        return $this->town;
    }

    public function setTown(?Town $town): static
    {
        $this->town = $town;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $createdAt = new \DateTimeImmutable();
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $updatedAt = new \DateTimeImmutable();
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isIsOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline(bool $isOnline): static
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $slug = strtolower(str_replace(' ', '-', $this->name));
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Illustration>
     */
    public function getIllustrations(): Collection
    {
        return $this->illustrations;
    }

    public function addIllustration(Illustration $illustration): static
    {
        if (!$this->illustrations->contains($illustration)) {
            $this->illustrations->add($illustration);
            $illustration->setProperty($this);
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): static
    {
        if ($this->illustrations->removeElement($illustration)) {
            // set the owning side to null (unless already changed)
            if ($illustration->getProperty() === $this) {
                $illustration->setProperty(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?PropertyType
    {
        return $this->type;
    }

    public function setType(?PropertyType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?PropertyStatus
    {
        return $this->status;
    }

    public function setStatus(?PropertyStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Feature>
     */
    public function getFeature(): Collection
    {
        return $this->feature;
    }

    public function addFeature(Feature $feature): static
    {
        if (!$this->feature->contains($feature)) {
            $this->feature->add($feature);
        }

        return $this;
    }

    public function removeFeature(Feature $feature): static
    {
        $this->feature->removeElement($feature);

        return $this;
    }

    public function getSquare(): ?int
    {
        return $this->square;
    }

    public function setSquare(?int $square): void
    {
        $this->square = $square;
    }

    public function getBedNumber(): ?int
    {
        return $this->bedNumber;
    }

    public function setBedNumber(?int $bedNumber): void
    {
        $this->bedNumber = $bedNumber;
    }

    public function getBathNumber(): ?int
    {
        return $this->bathNumber;
    }

    public function setBathNumber(?int $bathNumber): void
    {
        $this->bathNumber = $bathNumber;
    }

    /**
     * @return Collection<int, ScheduleRequest>
     */
    public function getScheduleRequests(): Collection
    {
        return $this->scheduleRequests;
    }

    public function addScheduleRequest(ScheduleRequest $scheduleRequest): static
    {
        if (!$this->scheduleRequests->contains($scheduleRequest)) {
            $this->scheduleRequests->add($scheduleRequest);
            $scheduleRequest->setProperty($this);
        }

        return $this;
    }

    public function removeScheduleRequest(ScheduleRequest $scheduleRequest): static
    {
        if ($this->scheduleRequests->removeElement($scheduleRequest)) {
            // set the owning side to null (unless already changed)
            if ($scheduleRequest->getProperty() === $this) {
                $scheduleRequest->setProperty(null);
            }
        }

        return $this;
    }
}
