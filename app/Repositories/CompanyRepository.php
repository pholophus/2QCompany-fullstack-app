<?php

// CompanyRepository.php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Http\UploadedFile;

class CompanyRepository
{
    public function save($company, $data)
    {
        $company->name = $data['name'];
        $company->email = $data['email'];
        $company->website = $data['website'];

        // Handle logo upload
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            $logoPath = $data['logo']->store('public/logos');
            $company->logo = basename($logoPath);
        }

        $company->save();

        return $company;
    }
}
