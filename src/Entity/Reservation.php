<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $checkin;

    #[ORM\Column(type: 'date')]
    private $checkout;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: Room::class, inversedBy: 'reservations')]
    private $roomId;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    private $customerId;

    #[ORM\ManyToMany(targetEntity: Hotel::class, inversedBy: 'reservations')]
    private $hotel;

    public function __construct()
    {
        $this->hotel = new ArrayCollection();
        $this->createdAt  = new \DateTime("now");
    }

    public function __toString(): string
    {
        return $this->hotel; 
        return $this->roomId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckin(): ?\DateTimeInterface
    {
        return $this->checkin;
    }

    public function setCheckin(\DateTimeInterface $checkin): self
    {
        $this->checkin = $checkin;

        return $this;
    }

    public function getCheckout(): ?\DateTimeInterface
    {
        return $this->checkout;
    }

    public function setCheckout(\DateTimeInterface $checkout): self
    {
        $this->checkout = $checkout;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt  = new \DateTime("now");
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRoomId(): ?Room
    {
        return $this->roomId;
    }

    public function setRoomId(?Room $roomId): self
    {
        $this->roomId = $roomId;

        return $this;
    }

    public function getCustomerId(): ?User
    {
        return $this->customerId;
    }

    public function setCustomerId(?User $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function getHotel(): Collection
    {
        return $this->hotel;
    }

    public function addHotel(Hotel $hotel): self
    {
        if (!$this->hotel->contains($hotel)) {
            $this->hotel[] = $hotel;
        }

        return $this;
    }

    public function removeHotel(Hotel $hotel): self
    {
        $this->hotel->removeElement($hotel);

        return $this;
    }
}
