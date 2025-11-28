<?php

namespace App\Exports;

use App\Models\ShortUrl;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShortUrlExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ShortUrl::with(['user.name', 'company.name'])->select('id', 'user_id', 'company_id', 'original_url', 'short_code', 'clicks')->get();


    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function headings(): array
    {
        return ['id', 'user id', 'company id', 'original url', 'short code', 'clicks'];
    }
}
