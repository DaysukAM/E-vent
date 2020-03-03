<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FieldRepository")
 */
class Field
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="fields")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FieldType", inversedBy="fields")
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEvent(): ?event
    {
        return $this->event;
    }

    public function setEvent(?event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getType(): ?fieldType
    {
        return $this->type;
    }

    public function setType(?fieldType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
