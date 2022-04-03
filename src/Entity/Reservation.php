<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{   
    /**
     * @Groups({"fetch_rooms"})
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Groups({"fetch_rooms"})
     */
    #[Assert\GreaterThan('today', message:"The arrival date must be greater than today")]
    #[ORM\Column(type: 'date')]
    private $checkin;

    /**
     * @Groups({"fetch_rooms"})
     */
    #[Assert\GreaterThan(propertyPath:'checkin', message:"The departure date must be higher than the arrival date")]
    #[ORM\Column(type: 'date')]
    private $checkout;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    /**
     * @Groups({"fetch_rooms"})
     */
    #[ORM\ManyToOne(targetEntity: Room::class, inversedBy: 'reservations')]
    private $roomId;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    private $customerId;

    #[ORM\ManyToMany(targetEntity: Hotel::class, inversedBy: 'reservations')]
    private $hotel;

    #[ORM\Column(type: 'boolean')]
    private $isBooked;

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

        public function getIsBooked(): ?bool
        {
            return $this->isBooked;
        }

        public function setIsBooked(bool $isBooked): self
        {
            $this->isBooked = $isBooked;

            return $this;
        }
}
