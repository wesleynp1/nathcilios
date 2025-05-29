<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\available_datetime;
use App\Models\scheduling;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class agendaController extends Controller
{
    function agenda(Request $r){
        $availableDatetimes = agendaController::noExpiredAvailableDateTimes();  
        $arrayAvailableDatetimes = [];

        foreach($availableDatetimes as $availableDatetime){
            $arrayAvailableDatetimes[] = date_create($availableDatetime->date_time);
        }

        if(Auth::check()){
            $arrayscheduledDatetimes = [];

            if(Gate::allows("isAdmin")){
                $scheduledDatetimes = scheduling::all("scheduled_time");                

                foreach($scheduledDatetimes as $scheduledDatetime){
                    $arrayscheduledDatetimes[] = date_create($scheduledDatetime->scheduled_time);
                }

                return view("agenda.agenda",[
                "availableDatetimes"=>$arrayAvailableDatetimes,
                "scheduledDatetimes"=>$arrayscheduledDatetimes
                ]);
            }
        }
            return view("agenda.agenda",["availableDatetimes"=>$arrayAvailableDatetimes]);
    }
        

    function makeAvailableForm(){
        $availableDatetimes = agendaController::noExpiredAvailableDateTimes();
        $scheduledDatetimes = scheduling::all("scheduled_time");

        $busyDateTimes = [];
        
        foreach($availableDatetimes as $availableDatetime){
            $busyDateTimes[] = date_format(date_create($availableDatetime->date_time),"Y-m-d H:i:s");
        }

        $arrayscheduledDatetimes = [];

        foreach($scheduledDatetimes as $scheduledDatetime){
            $dateTime   = date_create($scheduledDatetime->scheduled_time);
            
            $arrayscheduledDatetimes[] = $dateTime;
            $busyDateTimes[] = date_format($dateTime,"Y-m-d H:i:s");
        }
        
        return view("agenda.makeAvailable",[
            "scheduledDatetimes"=>$arrayscheduledDatetimes,
            "busyDateTimes"=>$busyDateTimes
        ]);
    }

    
    function makeAvailable(Request $r){
        try{
            if(empty($r->input('newAvailableDatetime'))){
                throw new Exception("Nada foi selecionado");
            }

            array_map( function($newDate){
                if(date_create($newDate)  < date_create('now',new DateTimeZone(env('APP_TIMEZONE')))){
                    throw new Exception("Data e horário já passaram");
                }
                available_datetime::create(['date_time'=>date_create($newDate)]);
            } ,     
            $r->input('newAvailableDatetime'));        

            return redirect("agenda")->with("message","Acão realizada com sucesso!");
        }catch(Exception $e){
            return back()->with("message","Operação mau sucedida: ".$e->getMessage());
        }
    }

    function makeUnavailable(Request $r){
        try{
            if(empty($r->input('datesToUnavailable'))){
                throw new Exception("Nada foi selecionado");
            }

            array_map( function($dateToDelete){
                $availableDatetimeToDelete =  available_datetime::findOrFail(date_create($dateToDelete));
                $availableDatetimeToDelete->delete();
            },
            $r->input('datesToUnavailable'));

            return redirect("agenda")->with("message","Operação bem sucedida!");
        }catch(Exception $e){
            return redirect("agenda")->with("message","Operação mau sucedida: " . $e->getMessage());
        }
        
    }

    static function noExpiredAvailableDateTimes(){
        $availableDatetimes = available_datetime::all();

        foreach($availableDatetimes as $availableDatetime){
            if(date_create($availableDatetime->date_time) < date_create('now',new DateTimeZone(env('APP_TIMEZONE')))){
                $availableDatetime->delete();
            }
        }

        return $availableDatetimes;
    }
}