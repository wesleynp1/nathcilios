<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\scheduling;
use App\Models\service;
use App\Models\available_datetime;
use Illuminate\Support\Facades\Gate;
use DateTimeZone;
use Exception;

class schedulingController extends Controller
{
    //CRUD
    function createScheduling(Request $r){
        try{
            $newScheduling = $this->SchedulingValidation($r);

            available_datetime::destroy($newScheduling->scheduled_time);
            $newScheduling->save();
            
            return redirect("agendamentos")->with("message","agendamento realizado com sucesso!");
        }catch(Exception $e){
            return back()->withInput(["name","scheduled_time","serviceId"])->with("message",$e->getMessage());
        }
    }
    
    function readScheduling(Request $r) : View{
        if(Gate::allows('isAdmin')){
            $schedulings = DB::select("
            SELECT scheduling.id, 
            scheduling.scheduled_time,
            scheduling.created_at,
            users.name as client_name,
            service.name as service_name 
            from scheduling inner join users inner join service 
            where scheduling.serviceId=service.id and scheduling.client = users.id
            ORDER BY scheduling.scheduled_time DESC;");
        }else{
            $schedulings = DB::select("
            SELECT scheduling.id, 
            scheduling.scheduled_time,
            users.name as client_name,
            service.name as service_name 
            from scheduling inner join users inner join service 
            where scheduling.serviceId=service.id and scheduling.client = users.id and users.id=".$r->user()->id.
            " ORDER BY scheduling.scheduled_time DESC;"
            );
        }

        foreach ($schedulings as $scheduling){
            $scheduling->scheduled_time = date_create($scheduling->scheduled_time);
        }

        return view("scheduling.listScheduling",["schedules" => $schedulings]);
    }

    function updateScheduling(Request $r){
        try{
            $schedulingToBeUpdated = scheduling::findOrFail($r->id);
            Gate::authorize("isTheOwner",[$schedulingToBeUpdated]);

            $this->SchedulingValidation($r,$schedulingToBeUpdated)->save();

            if($schedulingToBeUpdated->scheduled_time != $r->scheduled_time){
                $oldScheduled_time = new available_datetime();                
                $oldScheduled_time->date_time = $schedulingToBeUpdated->scheduled_time;                
                available_datetime::destroy($r->scheduled_time);
                available_datetime::noExpiredAvailableDateTimes();
            }

            return redirect("agendamentos")->with("message","agendamento editado com sucesso!");;
        }catch(Exception $e){
            return back()->withInput(["client_name","scheduled_time","serviceId"])->with("message",$e->getMessage());
        }
    }

    function deleteScheduling(Request $r){
        try{
            $schedulingToDelete = scheduling::findOrFail($r->id);
            if(!Gate::allows("isAdmin")){
                Gate::authorize("isTheOwner",[$schedulingToDelete]);
            }

            if(date_create($schedulingToDelete->scheduled_time) > date_create('now',new DateTimeZone(env('APP_TIMEZONE')))){
                $newAvailableDateTime = new available_datetime();
                $newAvailableDateTime->date_time = $schedulingToDelete->scheduled_time;
                $newAvailableDateTime->save();
            }
            
            $schedulingToDelete->delete();
            return redirect("/agendamentos")->with("message","Deletado com sucesso!");
        }catch(Exception $e){
            return redirect("/agendamentos")->with("message","Erro ao deletar:".$e->getMessage());
        }
    }


    //FORM's
    function formCreateScheduling(Request $r){
        try{
            $available_dateTimes = $this->retrieveAvailableDatetime();
            if(count($available_dateTimes)==0){
                throw new Exception("Desculpe não temos horários dispoíveis no momento");
            }

            return view("scheduling.createScheduling",[
                "serviceIntentedId"=>$r->serviceIntentedId,
                "services"=> DB::select("SELECT id,name from service;"),
                "datetimes"=> $available_dateTimes
            ]);
        }catch(Exception $e){
            return back()->with("message","Erro: ".$e->getMessage());
        }
    }

    function formUpdateScheduling(Request $r){
        try{
            $schedulingToBeUpdated = scheduling::findOrFail($r->id);
            Gate::authorize("isTheOwner",[$schedulingToBeUpdated]);

            return view("scheduling.updateScheduling",[
                "scheduling"=> $schedulingToBeUpdated,
                "services"  => DB::select("SELECT id,name from service;"),
                "datetimes" => $this->retrieveAvailableDatetime()
            ]);
        }catch(Exception $e){
            return back()->with("message","Falha ao realizar a ação");
        }
    }

    function formDeleteScheduling(Request $r){
        try{
            $schedulingForDeleting = scheduling::findOrFail($r->id);
            if(!Gate::allows("isAdmin")){
                Gate::authorize("isTheOwner",[$schedulingForDeleting]);
            }

            $schedulingForDeleting->service_name = service::findOrFail($schedulingForDeleting->serviceId)->name;
            return view("scheduling.deleteScheduling",["scheduling"=> $schedulingForDeleting]);
        }catch(Exception $e){
            return back()->with("message","Falha ao realizar a ação");
        }
    }

    //VALIDATION
    function SchedulingValidation(Request $r,$scheduling = new scheduling()){
        
            $r->validate([                
                "scheduled_time" => "required | date",
                "serviceId" => "required"
            ]);

            if(date_create($r->scheduled_time) < date_create('now',new DateTimeZone(env('APP_TIMEZONE')))){
                throw new Exception("Sinto muito, mas a data pretendida já passou");
            }

            if( isset($scheduling->scheduled_time) && $scheduling->scheduled_time != $r->scheduled_time){
                available_datetime::findOrFail($r->scheduled_time);
            }
            $user = $r->user();
            $scheduling->client         = $user->id;
            $scheduling->scheduled_time = $r->scheduled_time;
            $scheduling->serviceId      = $r->serviceId;

            return $scheduling;
    }

    function retrieveAvailableDatetime(){
        $available_datetimes = agendaController::noExpiredAvailableDateTimes();

        $datestimes = [];

        foreach($available_datetimes as $ad){
            $datestimes[] = date($ad->date_time);
        }

        return $datestimes;
    }
}
