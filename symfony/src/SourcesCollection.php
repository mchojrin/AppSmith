<?php

namespace App;

use App\Scraper\Contracts\SourceInterface;

class SourcesCollection
{
    private array $sources;

    public function __construct(iterable $sources)
    {
        foreach ($sources as $source) {
            $this->addSource($source);
        }
    }

    public function addSource(SourceInterface $source): self
    {
        $this->sources[$source->getName()] = $source;

        return $this;
    }

    public function getSources(): array
    {
        return $this->sources;
    }
}