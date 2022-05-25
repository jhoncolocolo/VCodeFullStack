<?php

namespace App\Repositories\Pet;

interface PetRepositoryInterface { 
   public function store($data);
   public function update($pet,$data);
   public function getPetsByStatus($status);
}