<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ClassesRepository::class)]
class Classes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $section = null;

    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'classid')]
    private Collection $students;

    #[ORM\ManyToMany(targetEntity: Studentgrades::class, mappedBy: 'classid')]
    private Collection $studentgrades;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifiedDate = null;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->studentgrades = new ArrayCollection();
    }

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

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addClassid($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            $student->removeClassid($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Studentgrades>
     */
    public function getStudentgrades(): Collection
    {
        return $this->studentgrades;
    }

    public function addStudentgrade(Studentgrades $studentgrade): self
    {
        if (!$this->studentgrades->contains($studentgrade)) {
            $this->studentgrades[] = $studentgrade;
            $studentgrade->addClassid($this);
        }

        return $this;
    }

    public function removeStudentgrade(Studentgrades $studentgrade): self
    {
        if ($this->studentgrades->removeElement($studentgrade)) {
            $studentgrade->removeClassid($this);
        }

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedDate(): void
    {
        $this->createdDate = new \DateTimeImmutable();
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }


    public function getModifiedDate(): ?\DateTimeInterface
    {
        return $this->modifiedDate;
    }

    #[ORM\PrePersist]
    public function setModifiedDate(): void
    {
        $this->modifiedDate = new \DateTimeImmutable();
    }

    public function __toString() {
        return $this->name;
    }
}
