<?php

namespace BatoiBook\Models;

class Module
{
   public function __construct(
   public int $id,
   public string $cliteral = '',
   public string $vliteral = '',
   public int $courseId = 0
   )
   {}
}