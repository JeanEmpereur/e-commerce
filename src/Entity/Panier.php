<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_achat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Etat;

    /**
     * @ORM\OneToMany(targetEntity=ContenuPanier::class, mappedBy="Panier")
     */
    private $contenuPanier;

    public function __construct()
    {
        $this->ContenuPanier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(?\DateTimeInterface $date_achat): self
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->Etat;
    }

    public function setEtat(bool $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    /**
     * @return Collection|ContenuPanier[]
     */
    public function getContenuPanier(): Collection
    {
        return $this->contenuPanier;
    }

    public function addContenuPanier(ContenuPanier $contenuPanier): self
    {
        if (!$this->contenuPanier->contains($contenuPanier)) {
            $this->contenuPanier[] = $contenuPanier;
            $contenuPanier->setPanier($this);
        }

        return $this;
    }

    public function removeContenuPanier(ContenuPanier $contenuPanier): self
    {
        if ($this->contenuPanier->contains($contenuPanier)) {
            $this->contenuPanier->removeElement($contenuPanier);
            // set the owning side to null (unless already changed)
            if ($contenuPanier->getPanier() === $this) {
                $contenuPanier->setPanier(null);
            }
        }

        return $this;
    }
}
