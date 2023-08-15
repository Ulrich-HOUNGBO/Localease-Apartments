<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[Vich\Uploadable]
#[ApiResource(types: ['https://schema.org/City'],
    operations: [
        new Post(inputFormats: ['multipart' => ['multipart/form-data']])
    ],
    normalizationContext: ['groups' => ['city:read']],
    denormalizationContext: ['groups' => ['city:write']])]
#[GetCollection]
#[Get]
#[Put(security: "is_granted('ROLE_USER')")]
#[Patch(security: "is_granted('ROLE_USER')")]
#[Delete(security: "is_granted('ROLE_USER')")]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read:property", "city:read", "city:write"])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["city:read", "city:write"])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Property::class)]
    private Collection $properties;

    #[ORM\Column(length: 255, nullable: true)]
    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(["city:read", "city:write"])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "city_images", fileNameProperty: "filePath")]
    #[Groups(["city:read", "city:write"])]
    public ?File $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["city:read", "city:write"])]
    public ?string $filePath = null;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): static
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->setCity($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getCity() === $this) {
                $property->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    /**
     * @param string|null $contentUrl
     */
    public function setContentUrl(?string $contentUrl): void
    {
        $this->contentUrl = $contentUrl;
    }
}
