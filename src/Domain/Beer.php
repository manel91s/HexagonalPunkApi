<?php

namespace App\Domain;

class Beer
{
    private int $id;

    private string $name;
    private string $tagline;

    private string $firstBrewed;

    private string $description;
    private string $image;

    public function __construct(
        int $id,
        string $name,
        string $tagline,
        string $firstBrewed,
        string $description,
        string $image
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->tagline = $tagline;
        $this->firstBrewed = $firstBrewed;
        $this->description = $description;
        $this->image = $image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    public function getFirstBrewed(): ?string
    {
        return $this->firstBrewed;
    }

    public function setFirstBrewed(string $firstBrewed): void
    {
        $this->firstBrewed = $firstBrewed;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}
