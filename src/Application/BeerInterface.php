<?php

namespace App\Application;
use Symfony\Contracts\HttpClient\HttpClientInterface;

interface BeerInterface 
{
    public function filterByString(HttpClientInterface $httpClient);
    public function filterById(HttpClientInterface $httpClient)
}