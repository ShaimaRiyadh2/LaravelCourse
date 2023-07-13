<?php

namespace App\Exports;

use App\Models\User;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromView
{
    use Exportable;


    // public function __construct($status){
    //     $this->status=$status;

    // }
    public function forStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    public function forYear(int $year)
    {
        $this->year = $year;

        return $this;
    }
    public function query()
    {
        return  User::query()
            ->where('status',$this->status)
            ->whereYear('created_at',$this->year);
    }
    public function view():View{
        return view('exports.users', [
            'users' => User::all()
        ]);
    }

    // public function collection()
    // {
    //     return User::all(['id','name','email','status'])->where('status',1);
    // }
}
