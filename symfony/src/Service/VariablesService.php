<?php

namespace App\Service;

class VariablesService 
{
  public function adminEmail(): string
  {
    $admin_email = 'guyotmathieu572@gmail.com';
    return $admin_email;
  }

  public function adminCompanyName(): string
  {
    $admin_company = 'MG Production';
    return $admin_company;
  }
}