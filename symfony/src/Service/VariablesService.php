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

  public function stripePSK(): string
  {
    $stripePSK = 'sk_test_51LeDueKgHxrl7uH30Bcdhjo2Lp7DkfhJhTCR3IYM65bUj5VYAWLVMeXe4gA8nBpVVybT9PyplESArJccqjfSUCHr00gExJt9S5';
    return $stripePSK;
  }
}