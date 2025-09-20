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
    function agenda(){
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
        try{
            if(!Gate::allows("isAdmin"))throw new Exception("acesso negado");

            //QUAIS HORÁRIOS TEM CLIENTE MARCADO NO FUTURO
            $scheduledDatetimes = scheduling::whereFuture("scheduled_time")->get()->map(function ($d){
                return date_create($d->scheduled_time);
            });

            //QUAIS HORÁRIOS JÁ SE ENCONTRAM DISPONIVEIS
            $availableDatetimes = agendaController::noExpiredAvailableDateTimes()->map(function ($d){
                return date_create($d->date_time);
            });

            return view("agenda.makeAvailable",[
                "scheduledDatetimes"=>$scheduledDatetimes,
                "availableDatetimes"=>$availableDatetimes
            ]);
        }catch(Exception $e){
            return back()->with("message","Operação mau sucedida: ".$e->getMessage());
        }
    }
    
    function makeAvailable(Request $r){
        try{
            if(!Gate::allows("isAdmin"))throw new Exception("acesso negado");

            if(empty($r->input('datetimeToAvailable'))){
                throw new Exception("Nada foi selecionado");
            }

            array_map( function($newDate){
                if(date_create($newDate)  < date_create('now',new DateTimeZone(env('APP_TIMEZONE')))){
                    throw new Exception("Data e horário já passaram");
                }
                available_datetime::create(['date_time'=>date_create($newDate)]);
            } ,     
            $r->input('datetimeToAvailable'));

            return redirect("agenda")->with("message","Acão realizada com sucesso!");
        }catch(Exception $e){
            return back()->with("message","Operação mau sucedida: ".$e->getMessage());
        }
    }

    function makeUnavailable(Request $r){
        try{
            if(!Gate::allows("isAdmin"))throw new Exception("acesso negado");

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