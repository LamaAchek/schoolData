<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dob = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagepath = null;

    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'students')]
    private Collection $courseid;

    #[ORM\ManyToMany(targetEntity: Classes::class, inversedBy: 'students')]
    private Collection $classid;

    #[ORM\ManyToMany(targetEntity: Studentgrades::class, mappedBy: 'studentid')]
    private Collection $studentgrades;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modifiedDate = null;

    public function __construct()
    {
        $this->courseid = new ArrayCollection();
        $this->classid = new ArrayCollection();
        $this->studentgrades = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getImagepath(): ?string
    {
        return $this->imagepath;
    }

    public function setImagepath(?string $imagepath): self
    {
        $this->imagepath = $imagepath;

        return $this;
    }



    /**
     * @return Collection<int, course>
     */
    public function getCourseid(): Collection
    {
        return $this->courseid;
    }

    public function addCourseid(course $courseid): self
    {
        if (!$this->courseid->contains($courseid)) {
            $this->courseid[] = $courseid;
        }

        return $this;
    }

    public function removeCourseid(course $courseid): self
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
            $studentgrade->addStudentid($this);
        }

        return $this;
    }

    public function removeStudentgrade(Studentgrades $studentgrade): self
    {
        if ($this->studentgrades->removeElement($studentgrade)) {
            $studentgrade->removeStudentid($this);
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

    public function __toString()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
    
}
