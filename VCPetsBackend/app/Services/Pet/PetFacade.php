<?php

namespace App\Services\Pet;
use Illuminate\Support\Facades\Facade;


class PetFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return 'Pet';
    }
}