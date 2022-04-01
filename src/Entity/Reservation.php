<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\GreaterThan('today', message:"The arrival date must be greater than today")]
    #[ORM\Column(type: 'date')]
    private $checkin;

    #[Assert\GreaterThan(propertyPath:'checkin', message:"The departure date must be higher than the arrival date")]
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
        // Permet de retourner true si les dates sont réservable (toujours disponibles)
        public function isBookableDates(){
            // 1) On récupère l'ensemble des journées pour lesquels cette annonce n'est pas disponible (sous forme d'un tableau qui contient des objets DateTime)
            $notAvailableDays = $this->ad->getNotAvailableDays(); // On utilise la fonction que l'on a créé dans BookingController.php (getNotAvailableDays())
            // 2) On récupère l'ensemble des journées de ma réservation en cours (sous forme d'un tableau qui contient des objets DateTime)
            $bookingDays = $this->getDays(); // On stock les jours de ma réservation (les jours de la durée de résa)
    
            // Fonction qui sera l'argument1 de la fonction array_map() plus bas
            $formatDay = function($day){  
                return $day->format('Y-m-d');
            };
    
            // On transforme le tableau "bookingDays" (tableau de type DateTime) en chaine de caractères de type Y-m-d soit un format date
            $days = array_map($formatDay, $bookingDays);
    
            // On transforme le tableau "notAvailableDays" (tableau de type DateTime) en chaine de caractères de type Y-m-d soit un format date
            $notAvailableDays = array_map($formatDay, $notAvailableDays); // $notAvailableDays représente les jours pour lesquels cette annonce n'est pas dispo
    
            // On boucle sur les jours de la réservation ($days), et pour chaque journée on regarde si elle est présente parmi les journées non disponibles,
            // si c'est le cas, alors cela retourne false, sinon retourne true
            foreach($days as $day){
                if(array_search($day, $notAvailableDays) !== false) return false;
            }
    
            return true;
        }
    
        /**
         * Permet de récupérer un tableau des journées qui correspondent à ma réservation
         *
         * @return array Un tableau d'objet DateTime représentant les jours de la réservation
         */
        public function getDays(){
            $resultat = range(
                $this->checkin->getTimestamp(),
                $this->checkout->getTimestamp(),
                24 * 60 * 60
            );
    
            $days = array_map(function($dayTimestamp){
                return new \DateTime(date('Y-m-d', $dayTimestamp));
            }, $resultat);
    
            return $days; // $days représente un tableau de jours de ma réservation (les jours de la durée de résa)
        }
    
        /* Fonction manuelle qui calcul la duréé d'un annonce (soit la différence entre la date de début (startDate) et la date de fin (endDate) */
        public function getDuration(){
            $diff = $this->checkout->diff($this->checkin); // la méthode diff() provient des objet de type DateTime et permet de faire la différence entre 2 dates et renvoie un objet DateInterval
            return $diff->days; // Retour la différence en jour (soit un nombre)
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
