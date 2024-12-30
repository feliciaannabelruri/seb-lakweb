<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class SecureFile implements Rule
{
    protected $maxSize = 2048;
    protected $allowedMimes = ['jpeg', 'png', 'jpg'];
    protected $message;

    public function passes($attribute, $value)
    {
        if (!($value instanceof UploadedFile)) {
            $this->message = 'File tidak valid.';
            return false;
        }

        if ($value->getSize() > $this->maxSize * 1024) {
            $this->message = 'Ukuran file tidak boleh lebih dari ' . $this->maxSize . 'KB.';
            return false;
        }

        if (!in_array($value->getClientOriginalExtension(), $this->allowedMimes)) {
            $this->message = 'Format file harus berupa: ' . implode(', ', $this->allowedMimes);
            return false;
        }

        $content = file_get_contents($value->getRealPath());
        
        if (strpos($content, '<?php') !== false) {
            $this->message = 'File terdeteksi mengandung kode berbahaya.';
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }
}