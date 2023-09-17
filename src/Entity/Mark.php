<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarkRepository::class)
 */
class Mark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="marks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Student;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="marks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Subject;

    /**
     * @ORM\Column(type="float")
     */
    private $ASM1;

    /**
     * @ORM\Column(type="float")
     */
    private $ASM2;

    /**
     * @ORM\Column(type="float")
     */
    private $Average;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->Student;
    }

    public function setStudent(?Student $Student): self
    {
        $this->Student = $Student;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->Subject;
    }

    public function setSubject(?Subject $Subject): self
    {
        $this->Subject = $Subject;

        return $this;
    }

    public function getASM1(): ?float
    {
        return $this->ASM1;
    }

    public function setASM1(float $ASM1): self
    {
        $this->ASM1 = $ASM1;

        return $this;
    }

    public function getASM2(): ?float
    {
        return $this->ASM2;
    }

    public function setASM2(float $ASM2): self
    {
        $this->ASM2 = $ASM2;

        return $this;
    }

    public function getAverage(): ?float
    {
        return $this->Average;
    }

    public function setAverage(float $Average): self
    {
        $this->Average = $Average;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }
}
