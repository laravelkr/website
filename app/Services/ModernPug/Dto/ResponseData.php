<?php

namespace App\Services\ModernPug\Dto;

class ResponseData
{
    public int $id;
    public string $title;
    public string $company_name;
    public string $description;
    public ?string $image_url;
    public string $skills;
    public string $link;
    public int $min_salary;
    public int $max_salary;
    public string $address;
    public string $created_at;
    public string $updated_at;
    public string $expired_at;
    public string $created_user;

}
