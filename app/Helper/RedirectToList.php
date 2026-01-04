<?php

namespace App\Helper;

trait RedirectToList
{
    protected function getRedirectUrl(): string
    {
        return $this->getResourceUrl(parameters: $this->getRedirectUrlParameters());
    }
}
