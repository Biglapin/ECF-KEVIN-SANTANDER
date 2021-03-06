<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[Vich\Uploadable]
class Room
{
    /**
     * @Groups({"fetch_rooms"})
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255,  nullable: true)]
    private $image;
    
    #[Vich\UploadableField(mapping: 'rooms_images' ,fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $secondImage;
    
    #[Vich\UploadableField(mapping: 'rooms_images' ,fileNameProperty: 'secondImage')]
    private ?File $secondImageFile = null;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'boolean')]
    private $isAvailable;

    #[ORM\OneToMany(mappedBy: 'roomId', targetEntity: Reservation::class)]
    private $reservations;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Slug(fields: ['title', 'title'])]
    private string $slug = '';

    #[ORM\Column(type: 'string', length: 255)]
    private $link;

    #[ORM\ManyToOne(targetEntity: Hotel::class, inversedBy: 'rooms')]
    private $hotelId;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'managerId')]
    private $users;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }
    
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getSecondImage(): ?string
    {
        return $this->secondImage;
    }

    public function setSecondImage(?string $secondImage): self
    {
        $this->secondImage = $secondImage;

        return $this;
    }
    
    public function getSecondImageFile()
    {
        return $this->secondImageFile;
    }
    public function setSecondImageFile(File $secondImage = null)
    {
        $this->secondImageFile = $secondImage;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($secondImage) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }



    /**
     * @Groups({"fetch_rooms"})
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @Groups({"fetch_rooms"})
     */
    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setRoomId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRoomId() === $this) {
                $reservation->setRoomId(null);
            }
        }

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): string
    {
        $this->slug = $slug;

        return $this;
    }


    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getHotelId(): ?Hotel
    {
        return $this->hotelId;
    }

    public function setHotelId(?Hotel $hotelId): self
    {
        $this->hotelId = $hotelId;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addManagerId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeManagerId($this);
        }

        return $this;
    }
}
