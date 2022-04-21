<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Mescommandes::class, mappedBy="produits")
     */
    private $mescommandes;

    public function __construct()
    {
        $this->mescommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): self
    {
        $this->categories = $categories;

        return $this;
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
            $mescommande->setProduits($this);
        }

        return $this;
    }

    public function removeMescommande(Mescommandes $mescommande): self
    {
        if ($this->mescommandes->removeElement($mescommande)) {
            // set the owning side to null (unless already changed)
            if ($mescommande->getProduits() === $this) {
                $mescommande->setProduits(null);
            }
        }

        return $this;
    }
}
