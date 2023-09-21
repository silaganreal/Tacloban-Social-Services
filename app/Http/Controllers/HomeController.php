<?php

namespace App\Http\Controllers;

use App\Barangays;
use App\Clients;
use App\History;
use App\Offices;
use App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $clients = Clients::all();
        $clients = Clients::paginate(10);
        $barangays = Barangays::all();
        return view('home', compact(['clients','barangays']))->with('no', 1);
    }

    public function addClient(Request $request) {
        $count = Clients::where('fname', $request->fname)
        ->where('mname', $request->mname)->where('lname', $request->lname)->count();

        if($count == 0) {
            $imageName = time() .'.'. $request->profile_photo->extension();
            $newClient = Clients::create([
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'mobileNo' => $request->mobileNo,
                'email' => $request->email,
                'barangay' => $request->barangay,
                'houseNoStName' => $request->houseNoStName,
                'profile' => $imageName
            ]);

            if($newClient) {
                // $lastId = $newClient->id;
                $request->profile_photo->move(public_path('img'), $imageName);
                return back()->withStatus('New client has been created!');
            } else {
                return back()->withStatus('Failed! Error creating new client.');
            }
        } else {
            return back()->withStatus('Failed! Error creating new client.');
        }

    }

    public function viewClient($id) {
        $client = Clients::find($id);
        $histories = History::where('clientID', $id)->get();
        $barangays = Barangays::all();
        $offices = Offices::all();
        $services = Services::all();
        return view('client', compact(['client','histories','barangays','offices','services']));
    }

    public function updateClient(Request $request, $id) {
        $client = Clients::find($id);
        $client->fname = $request->fname;
        $client->mname = $request->mname;
        $client->lname = $request->lname;
        $client->birthday = $request->birthday;
        $client->gender = $request->gender;
        $client->mobileNo = $request->mobileNo;
        $client->email = $request->email;
        $client->barangay = $request->barangay;
        $client->houseNoStName = $request->houseNoStName;

        if($request->profile_photo != '') {
            $imageName = time() .'.'. $request->profile_photo->extension();
            $client->profile = $imageName;
        }

        if($client->update()) {
            if($request->profile_phote != '') {
                $request->profile_photo->move(public_path('img'), $imageName);
            }
            return back()->withStatus('Profile has been updated!');
        } else {
            return redirect()->back()->withStatus('Fail! There is an error uploading the image.');
        }
    }

    public function addHistory(Request $request) {
        $newDate = date('Y-m-d H:i:s');
        $newHistory = History::create([
            'clientID' => $request->clientID,
            'service' => $request->service,
            'dateTime' => $newDate,
            'assisstedBy' => $request->assisstedBy,
            'remarks' => $request->remarks,
            'type' => $request->type,
            'barangay' => $request->barangay,
            'office' => $request->office,
            'amount' => $request->amount,
            'reference' => $request->reference
        ]);

        if($newHistory) {
            return back()->withStatus('New history has been added!');
        } else {
            return back()->withStatus('Failed! Error creating new history.');
        }
    }

    public function searchClient(Request $request) {
        $barangays = Barangays::all();
        $fname = $_GET['sfname'];
        $lname = $_GET['slname'];
        $clients = Clients::where('fname', 'LIKE', '%'. $fname .'%')
        ->where('lname', 'LIKE', '%'. $lname .'%')
        ->get();
        return view('search', compact(['clients','barangays']));
    }
}
