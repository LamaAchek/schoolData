<?php

namespace App\Entity;

use App\Repository\StudentgradesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: StudentgradesRepository::class)]
class Studentgrades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $grades = null;

    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'studentgrades')]
    private Collection $studentid;

    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'studentgrades')]
    private Collection $courseid;

    #[ORM\ManyToMany(targetEntity: Classes::class, inversedBy: 'studentgrades')]
    private Collection $classid;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifiedDate = null;

    public function __construct()
    {
        $this->studentid = new ArrayCollection();
        $this->courseid = new ArrayCollection();
        $this->classid = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrades(): ?float
    {
        return $this->grades;
    }

    public function setGrades(float $grades): self
    {
        $this->grades = $grades;

        return $this;
    }


    /**
     * @return Collection<int, Student>
     */
    public function getStudentid(): Collection
    {
        return $this->studentid;
    }

    public function addStudentid(Student $studentid): self
    {
        if (!$this->studentid->contains($studentid)) {
            $this->studentid[] = $studentid;
        }

        return $this;
    }

    public function removeStudentid(Student $studentid): self
    {
        $this->studentid->removeElement($studentid);

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourseid(): Collection
    {
        return $this->courseid;
    }

    public function addCourseid(Course $courseid): self
    {
        if (!$this->courseid->contains($courseid)) {
            $this->courseid[] = $courseid;
        }

        return $this;
    }

    public function removeCourseid(Course $courseid): self
    {
        $this->courseid->removeElement($courseid);

        return $this;
    }

    /**
     * @return Collection<int, Classes>
     */
    public function getClassid(): Collection
    {
        return $this->classid;
    }

    public function addClassid(Classes $classid): self
    {
        if (!$this->classid->contains($classid)) {
            $this->classid[] = $classid;
        }

        return $this;
    }

    public function removeClassid(Classes $classid): self
    {
        $this->classid->removeElement($classid);

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

}
