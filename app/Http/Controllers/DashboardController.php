<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Complaint;
use App\Models\Information;
use App\Models\RequestType;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\RequestLetter;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index(){

        if (Auth::user()->role === 'admin') {
            return $this->admin();
        }else if (Auth::user()->role === 'operator') {
            return $this->operator();
        }else{
            return $this->resident();
        }
    }

    private function admin(){
        $statuses = ['Diajukan','Diproses', 'Ditolak', 'Selesai'];
        $totalRequest = RequestLetter::whereIn('status', $statuses)->count();
        $totalComplaint = Complaint::whereIn('status', $statuses)->count();
        $totalNotification = Notification::where('read', true)->count();
        $totalResident = Resident::count();
        $totalInformation = Information::count();
        $totalLetterType = RequestType::count();
        $latestRequests = RequestLetter::whereIn('status', $statuses)->orderBy('updated_at', 'desc')->latest()->take(5)->get();
        $latestComplaints = Complaint::whereIn('status', $statuses)->orderBy('updated_at', 'desc')->latest()->take(5)->get();
        
        $data = [
            'totalRequest' => $totalRequest,
            'totalComplaint' => $totalComplaint,
            'totalNotification' => $totalNotification,
            'totalResident' => $totalResident,
            'totalInformation' => $totalInformation,
            'totalLetterType' => $totalLetterType,
            'latestRequests' => $latestRequests,
            'latestComplaints' => $latestComplaints
        ] ;
        return view('cms.dashboard.admin')->with($data);
    }

    private function operator(){
        $statuses = ['Diajukan','Diproses', 'Ditolak', 'Selesai'];
        $totalRequest = RequestLetter::whereIn('status', $statuses)->count();
        $totalComplaint = Complaint::whereIn('status', $statuses)->count();
        $totalNotification = Notification::where('read', true)->count();
        $totalResident = Resident::count();
        $latestRequests = RequestLetter::whereIn('status', $statuses)->orderBy('updated_at', 'desc')->latest()->take(5)->get();
        $latestComplaints = Complaint::whereIn('status', $statuses)->orderBy('updated_at', 'desc')->latest()->take(5)->get();
        
        $data = [
            'totalRequest' => $totalRequest,
            'totalComplaint' => $totalComplaint,
            'totalNotification' => $totalNotification,
            'totalResident' => $totalResident,
            'latestRequests' => $latestRequests,
            'latestComplaints' => $latestComplaints
        ] ;
        return view('cms.dashboard.operator')->with($data);
    }

    private function resident(){

        $statuses = ['Diajukan', 'Diproses', 'Ditolak', 'Selesai'];
        $countsRequest = [];
        $countComplaint = [];
        foreach ($statuses as $status) {
            $countsRequest[$status] = Auth::user()->requestLetters()->where('status', $status)->count();
            $countComplaint[$status] = Auth::user()->complaints()->where('status', $status)->count();
        }
        $countsRequest['total'] = array_sum($countsRequest);
        $countComplaint['total'] = array_sum($countComplaint);

        $data = [
            'countRequest' => $countsRequest,
            'countComplaint' => $countComplaint
        ];


        return view('cms.dashboard.resident')->with($data);
    }

    
}
