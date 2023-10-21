<?php 
namespace App\Export;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportBooks implements FromCollection , WithHeadings
{
    public function collection()
    {
        return Book::with('publisher')->get()
        ->map(function($item){
        return [
            'Kode'=> $item->code,
            'Judul'=> $item->title,
            'Penerbit'=> $item->publisher->name

        ];
    });
    }
    public function headings(): array 
    {
        return [
            'Kode',
            'Judul',
            'Penerbit'
        ];
    }
   
}

