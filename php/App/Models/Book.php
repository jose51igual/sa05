<?php

namespace BatoiBook\Models;

use DateTime;

class Book
{
   public function __construct(
   public int $id,
   public int $userId = null,
   public string $moduleCode = '',
   public string $publisher = '',
   public float $price = 0.0,
   public int $pages = 0,
   public string $status = '',
   public string $photo = '',
   public string $comments = '',
   public DateTime $soldDate = null
   )
   {}
}