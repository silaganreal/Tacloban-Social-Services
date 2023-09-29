<?php

namespace App\Http\Controllers;

use App\Models\Barangays;
use App\Models\Clients;
use App\Models\History;
use App\Models\Medicines;
use App\Models\MedicinesList;
use App\Models\Offices;
use App\Models\Services;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class ClientController extends Controller
{

    public function showAllClients() {
        $clients = Clients::paginate(10);
        $barangays = Barangays::all();
        $household = DB::table('household')->whereNull('leaderID')->get();
        $hhMember = DB::table('household')->get();

        foreach($clients as $client) {
            $client->memberCount = DB::table('clients')->where('householdID', $client->householdID)->where('householdID', '!=', null)->count();
            $client->recentService = DB::table('histories')->select('service','dateTime')->where('clientID', $client->id)->orderBy('dateTime', 'DESC')->take(1)->get();
        }

        return view('clients', compact(['clients','barangays','household','hhMember']));
    }

    public function addClient(Request $request) {
        $count = Clients::where('fname', $request->fname)
            ->where('mname', $request->mname)
            ->where('lname', $request->lname)
            ->count();

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
                'category' => $request->category,
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
        $histories = History::where('clientID', $id)->orderBy('dateTime', 'DESC')->get();
        $logs = DB::table('logs')->where('clientID', $id)->get();
        $barangays = Barangays::all();
        $offices = Offices::all();
        $services = Services::all();
        $medlist = MedicinesList::all();
        $cswdoServices = DB::table('services')->where('officeID', 'CSWDO')->get();
        $dhcServices = DB::table('services')->where('officeID', 'CHO')->get();
        $indigencies = DB::table('indigency')->where('clientID', $id)->get();

        return view('client', compact(['client','histories','logs','barangays','offices','services','medlist','cswdoServices','dhcServices','indigencies']));
    }

    public function searchClient(Request $request) {
        $barangays = Barangays::all();
        $fname = $_GET['sfname'];
        $lname = $_GET['slname'];
        $hhMember = DB::table('household')->get();

        if($fname != '' || $lname != '') {
            $clients = Clients::where('fname', 'LIKE', '%'. $fname .'%')
            ->where('lname', 'LIKE', '%'. $lname .'%')
            ->get();

            foreach($clients as $client) {
                $client->memberCount = DB::table('clients')->where('householdID', $client->householdID)->where('householdID', '!=', null)->count();
                $client->recentService = DB::table('histories')->select('service','dateTime')->where('clientID', $client->id)->orderBy('dateTime', 'DESC')->take(1)->get();
            }

            return view('search', compact(['clients','barangays','hhMember']));
        } else {
            return back()->withStatus('Please enter name to search!');
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
            // 'barangay' => $request->barangay,
            'office' => $request->office,
            'amount' => $request->amount,
            'reference' => $request->reference,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment
        ]);

        if($newHistory) {
            return back()->withStatus('New Service has been added!');
        } else {
            return back()->withStatus('Failed! Error creating new service!');
        }
    }

    public function updateClient(Request $request, $id) {
        $client = Clients::find($id);
        $client->fname = $request->fname;
        $client->mname = $request->mname;
        $client->lname = $request->lname;
        $client->birthday = $request->birthday;
        $client->gender = $request->gender;
        $client->maritalStatus = $request->maritalStatus;
        $client->occupation = $request->occupation;
        $client->mobileNo = $request->mobileNo;
        $client->barangay = $request->barangay;
        $client->category = $request->category;
        $client->spouse = $request->spouse;
        $client->emergencyName = $request->emergencyName;
        $client->emergencyNumber = $request->emergencyNumber;

        if($request->profile_photo != '') {
            $imageName = time() .'.'. $request->profile_photo->extension();
            $client->profile = $imageName;
        }

        if($client->update()) {
            if($request->profile_photo != '') {
                $request->profile_photo->move(public_path('img'), $imageName);
            }
            return back()->withStatus('Profile has been updated!');
        } else {
            return redirect()->back()->withStatus('Fail! There is an error uploading the image.');
        }
    }

    public function editHistory(Request $request, $id) {
        $newDate = date('Y-m-d H:i:s');
        $history = History::find($id);
        $history->clientID = $request->clientID;
        $history->office = $request->office;
        $history->service = $request->service;
        $history->remarks = $request->remarks;
        $history->dateTime = $request->dateTime;
        $history->assisstedBy = $request->assisstedBy;
        $history->type = $request->type;
        $history->barangay = $request->barangay;
        $history->diagnosis = $request->diagnosis;
        $history->treatment = $request->treatment;
        $history->amount = $request->amount;
        $history->reference = $request->reference;
        $history->dateTime = $newDate;

        if($history->update()) {
            return back()->withStatus('Record has been updated!');
        } else {
            return redirect()->back()->withStatus('Fail! There is an error updating the record!');
        }
    }

    public function getServices($office) {
        $service['data'] = Services::orderBy('id', 'asc')
        ->select('officeID','service')
        ->where('officeID', $office)
        ->get();

        return response()->json($service);
    }

    public function getMedicines() {
        $medicines = DB::table('medicines_lists')->get();
        return view('medicines', compact('medicines'));
    }

    public function addMedicine(Request $request) {
        $newMed = MedicinesList::create([
            'medicine' => $request->medicine,
            'quantity' => $request->quantity
        ]);
        if($newMed) {
            return back()->with('mtrue','New Medicine has been added!');
        } else {
            return back()->with('mfalse','Fail saving new medicine!');
        }
    }

    public function editMedicine(Request $request) {
        $updatedMed = DB::table('medicines_lists')
        ->where('id', $request->editMedID)
        ->update([
            'medicine' => $request->editMed,
            'quantity' => $request->editQuan
        ]);
        if($updatedMed) {
            return back()->with('mtrue','Medicine has been updated!');
        } else {
            return back()->with('mfalse','Fail! Error updating the record.');
        }
    }

    public function addService(Request $request) {
        if(request()->ajax()){
            $clientID = $request->clientID;
            $office = $request->sel_office;
            $service = $request->sel_service;
            $remarks = $request->remarks;
            $type = $request->type;
            $assisstedBy = $request->assisstedBy;
            $diagnosis = $request->diagnosis;
            $treatment = $request->treatment;
            $medlist = $request->medlist;

            if(Auth::user()->accountType == 'dhc') {
                $dateTime = $request->serviceDate .' '. $request->serviceTime;
            } else {
                $dateTime = date('Y-m-d H:i:s');
            }

            $newHistory = History::create([
                'clientID' => $clientID,
                'office' => $office,
                'service' => $service,
                'diagnosis' => $diagnosis,
                // 'medicine' => $medlist,
                // 'treatment' => $treatment,
                'remarks' => $remarks,
                'dateTime' => $dateTime,
                'assisstedBy' => $assisstedBy,
                'type' => $type
            ]);

            if($office == 'CHO' || $office == 'TCH') {
                $historyID = $newHistory->id;
                if($request->medhistory > 0) {
                    foreach($request->medhistory as $key => $val) {
                        Medicines::create([
                            'clientID' => $clientID,
                            'historyID' => $historyID,
                            'diagnosis' => $val['diagnosis'],
                            'treatment' => $val['treatment'],
                            'medicine' => $val['medicine'],
                            'pieces' => $val['pieces'],
                            'dateTime' => $dateTime
                        ]);
                    }
                }
            }
        }
    }

    public function viewService($id) {
        $history = History::find($id);
        $clientID = $history->clientID;
        $medicines = Medicines::where('historyID', $id)->get();
        $client = Clients::where('id', $clientID)->get();

        return view('view-service', compact(['client','history','medicines']));
    }

    public function addLog(Request $request) {
        $dateTime = $request->logDate .' '. $request->logTime;
        $newLog = DB::table('logs')->insert([
            'clientID' => $request->logclientID,
            'dateTime' => $dateTime,
            'placeEvent' => $request->logPlaceEvent,
            'remarks' => $request->logRemarks
        ]);
        if($newLog) {
            return back()->withStatus('New Log has been addded!');
        } else {
            return back()->withStatus('Fail saving new log!');
        }
    }

    public function household() {
        $households = DB::table('household')->get();
        $barangays = DB::table('taclobanbarangays')->get();

        foreach($households as $household) {
            $household->memCount = DB::table('clients')->where('householdID', $household->householdNumber)->count();
        }

        return view('household', compact(['households','barangays']));
    }

    public function view_members($id) {
        $members = DB::table('clients')->where('householdID', $id)->get();
        foreach($members as $member) {
            $member->recentService = DB::table('histories')->where('clientID', $member->id)->orderBy('dateTime', 'DESC')->take(1)->value('service');
            $member->serviceDateTime = DB::table('histories')->where('clientID', $member->id)->orderBy('dateTime', 'DESC')->take(1)->value('dateTime');
        }

        return view('view-members', compact(['members']));
        // dd($members);
    }

    public function newHousehold(Request $request) {
        $count = DB::table('household')->where('householdNumber', $request->hhID)->count();
        if($count == 0) {
            $newHH = DB::table('household')->insert([
                'householdNumber' => $request->hhID,
                'barangay' => $request->hhBrgy
            ]);
            if($newHH) {
                return back()->with('mtrue','New Household has beed created!');
            } else {
                return back()->with('mfalse','Fail saving new household!');
            }

        } else {
            return back()->with('mfalse','Fail! Household already exist!');
        }
    }

    public function newHholdStat(Request $request) {
        $hhNumber = $request->hhNumber;
        // $hhtype = $request->hhtype;
        $hhcID = $request->hhcID;
        $hhcName = $request->hhcName;
        $hLeader = 1;
        $hmember = 0;

        DB::table('household')
        ->where('householdNumber', $hhNumber)
        ->update([
            'leaderID' => $hhcID,
            'leaderName' => $hhcName
        ]);

        $newStat = DB::table('clients')
            ->where('id', $hhcID)
            ->update([
                'householdID' => $hhNumber,
                'householdLeader' => $hLeader,
                'householdMember' => $hmember
            ]);

        if($newStat) {
            return back()->with('mtrue','Status has been updated!');
        } else {
            return back()->with('mfalse','Fail! Error updating status!');
        }
    }

    public function newHholdStat2(Request $request) {
        $hhNumber2 = $request->hhNumber2;
        // $hhtype2 = $request->hhtype2;
        $hhcID2 = $request->hhcID2;
        $hhcName2 = $request->hhcName2;
        $hLeader = 0;
        $hmember = 1;
        $relation2 = $request->relation2;
        $educAttain2 = $request->educAttain2;
        $occupation2 = $request->occupation2;
        $income2 = $request->income2;

        DB::table('household')
        ->where('householdNumber', $hhNumber2)
        ->update([
            'leaderID' => $hhcID2,
            'leaderName' => $hhcName2
        ]);

        $newStat = DB::table('clients')
            ->where('id', $hhcID2)
            ->update([
                'householdID' => $hhNumber2,
                'householdLeader' => $hLeader,
                'householdMember' => $hmember,
                'relation' => $relation2,
                'educationAttain' => $educAttain2,
                'occupation' => $occupation2,
                'income' => $income2
            ]);

        if($newStat) {
            return back()->with('mtrue','Status has been updated!');
        } else {
            return back()->with('mfalse','Fail! Error updating status!');
        }
    }

    public function householdMembers($id) {
        $household = DB::table('household')->where('householdNumber', $id)->get();
        $members = DB::table('clients')->where('householdID', $id)->get();
        foreach($members as $client) {
            $client->recentService = DB::table('histories')->select('service','dateTime')->where('clientID', $client->id)->orderBy('dateTime', 'DESC')->take(1)->get();
        }
        return view('view-household-members', compact(['household','members']));
    }

    public function printClient($id) {
        $indigencies = DB::table('indigency')->where('id', $id)->get();
        $clientID = DB::table('indigency')->where('id', $id)->value('clientID');
        $totalFamIncome = DB::table('indigency')->where('id', $id)->value('totalFamilyIncome');
        $qclient = DB::table('clients')->where('id', $clientID)->get();
        return view('print-preview', compact(['qclient','indigencies']));
    }

    public function printBCfindings($id) {
        $qclient = DB::table('clients')->where('id', $id)->get();
        $householdID = DB::table('clients')->where('id', $id)->value('householdID');
        $members = DB::table('clients')->where('householdID', $householdID)->where('householdID', '!=', '')->get();
        return view('print-bcfindings', compact(['qclient','members']));
    }

    public function addIndigency(Request $request) {
        $newIndigency = DB::table('indigency')->insert([
            'clientID' => $request->indigencyClientID,
            'sourceOfIncome' => $request->sourceIncome,
            'totalFamilyIncome' => $request->income,
            'needs' => $request->needs,
            'servicesToAvail' => $request->services,
            'financialAmount' => $request->financialAmount,
            'bcfscsr' => $request->bcfscsr,
            'assisstedBy' => $request->assisstedBy,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($newIndigency) {
            History::create([
                'clientID' => $request->indigencyClientID,
                'service' => 'Indigency',
                'dateTime' => date('Y-m-d H:i:s'),
                'assisstedBy' => $request->assisstedBy,
                'remarks' => $request->needs,
                'type' => $request->type,
                'office' => $request->type,
                'amount' => $request->amfinancialAmountount,
                'reference' => '',
                'diagnosis' => '',
                'treatment' => ''
            ]);
            return back()->with('mtrue', 'New Record has been addedd!');
        } else {
            return back()->with('mfalse', 'Fail! Error adding new record.');
        }
    }

    public function editIndigency(Request $request, $id) {
        $updatedIndigency = DB::table('indigency')
        ->where('id', $id)
        ->update([
            'sourceOfIncome' => $request->sourceIncome,
            'totalFamilyIncome' => $request->income,
            'needs' => $request->needs,
            'servicesToAvail' => $request->services,
            'financialAmount' => $request->financialAmount,
            'bcfscsr' => $request->bcfscsr,
            'assisstedBy' => $request->assisstedBy,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($updatedIndigency > 0) {
            return back()->with('mtrue', 'Indigency has been updated!');
        } else {
            return back()->with('mfalse', 'Fail! Error updating Indigency!');
        }
    }

    public function client_logs() {
        $logs = DB::table('histories')
        ->leftJoin('clients', 'histories.clientID', '=', 'clients.id')
        ->leftJoin('medicines', 'histories.id', 'medicines.historyID')
        ->select('histories.*','clients.*','medicines.*')
        // ->where('histories.office', 'CHO')
        ->where(function($query) {
            $query->where('histories.office', 'CHO')
            ->orWHere('histories.office','TCH');
        })
        ->groupBy('medicines.dateTime')
        ->get();

        $dhcs = DB::table('users')->where('accountType', 'dhc')->get();
        return view('client-logs', compact(['logs','dhcs']));
    }

    public function filterLogs(Request $request) {
        $dhc = $_GET['filterDHC'];
        $date = $_GET['filterDate'];

        if($dhc != '' || $date != '') {
            $logs = DB::table('histories')
            ->leftJoin('clients', 'histories.clientID', '=', 'clients.id')
            ->leftJoin('medicines', 'histories.id', 'medicines.historyID')
            ->select('histories.*','clients.*','medicines.*')
            ->where('histories.type', 'LIKE', '%'. $dhc . '%')
            ->where('histories.dateTime', 'LIKE', '%' . $date . '%')
            ->get();

            $dhcs = DB::table('users')->where('accountType', 'dhc')->get();
            return view('client-logs', compact(['logs','dhcs']));
        } else {
            return back()->with('mfalse', 'Please enter DHC or Date to search!');
        }
    }

}
