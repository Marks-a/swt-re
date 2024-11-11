<?php

namespace App\Models;

class HeaderButton
{
    private string $text;
    private string $link;
    private string $id;
    private string $type;

    public function __construct(string $text,string $id, string $link,string $type)
    {
        $this->text = $text;
        $this->link = $link;
        $this->id = $id;
        $this->type = $type;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getLink(): string
    {
        return $this->link;
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getType():string {
        return $this->type;
    }
}
