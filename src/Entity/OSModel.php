<?php

namespace OSModel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OSModelRepository")
 * @ORM\Table(name="tks_os_model")
 */
class OSModel
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="application_date", type="datetime")
     */
    private $applicationDate;

    /**
     * @var array|null
     *
     * {
     *   name: etas,
     *   label: Efficacité énergétique saisonnière ou ETAS,
     *   type: input > number
     *   required: true
     * }
     *
     * @ORM\Column(name="attributes", type="json")
     */
    private $attributes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="os_type", type="string")
     */
    private $osType;

//    private $template;
//
//    private $calculMethod;
//
//    private $os;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplicationDate(): ?\DateTime
    {
        return $this->applicationDate;
    }

    public function setApplicationDate(?\DateTime $applicationDate): void
    {
        $this->applicationDate = $applicationDate;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function setAttributes(?array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function getOsType(): ?string
    {
        return $this->osType;
    }

    public function setOsType(?string $osType): void
    {
        $this->osType = $osType;
    }
}
