<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Order\Infrastructure\Doctrine\Repository\OrderRepository;
use App\Order\Domain\Entity\Order as DomainOrder;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClientUser $client = null;

    #[ORM\Column]
    private \DateTimeImmutable $add_at;

    #[ORM\Column(length: 31)]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'order', orphanRemoval: true)]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->add_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?ClientUser
    {
        return $this->client;
    }

    public function setClient(?ClientUser $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getAddAt(): ?\DateTimeImmutable
    {
        return $this->add_at;
    }

    public function setAddAt(\DateTimeImmutable $add_at): static
    {
        $this->add_at = $add_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setOrder($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getOrder() === $this) {
                $article->setOrder(null);
            }
        }

        return $this;
    }

    public function setArticles(Article ...$articles): static
    {
        foreach ($articles as $article) {
            $this->addArticle($article);
        }

        return $this;
    }

    public static function fromDomain(DomainOrder $order): self
    {
        $self = new self;

        $self->id = $order->id;
        $self->status = $order->status->name;
        $self->articles = new ArrayCollection($order->articles->get()) ;
        $self->client = ClientUser::fromDomain($order->client);
        $self->add_at = $order->createdAt;

        return $self;
    }
}
