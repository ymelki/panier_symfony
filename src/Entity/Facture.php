<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Mescommandes::class, mappedBy="facture")
     */
    private $mescommandes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="factures")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datecreation;

    public function __construct()
    {
        $this->mescommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Mescommandes>
     */
    public function getMescommandes(): Collection
    {
        return $this->mescommandes;
    }

    public function addMescommande(Mescommandes $mescommande): self
    {
        if (!$this->mescommandes->contains($mescommande)) {
            $this->mescommandes[] = $mescommande;
            $mescommande->setFacture($this);
        }

        return $this;
    }

    public function removeMescommande(Mescommandes $mescommande): self
    {
        if ($this->mescommandes->removeElement($mescommande)) {
            // set the owning side to null (unless already changed)
            if ($mescommande->getFacture() === $this) {
                $mescommande->setFacture(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }
}
