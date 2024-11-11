<?php

namespace BatoiBook\Models;

class User
{
   public function __construct(
   public int $id,
   public string $email,
   public string $nick = '',
   public string $password,
   public bool $isAdmin = false)
   {}
}
