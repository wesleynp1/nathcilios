<?php

namespace App\Http\Controllers;

use App\Models\service;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class serviceController extends Controller
{
    //SERVICE CRUD
    function createService(Request $r){

        try{
            $this->serviceValidation($r)->save();            
            return redirect("/servicos");
        }catch(Exception $e){
            return back()->withInput(["name","price","image","description"])->with("message",$e->getMessage());
        }
    }
    
    function readServices(Request $r) : View{
        return view("service.listServices",["services" => service::all()]);
    }

    function updateService(Request $r){
        try{
            $service = service::findOrFail($r->idService);
            $this->serviceValidation($r,$service)->save();
            return redirect("/servicos");
        }catch(Exception $e){
            return redirect("/servicos")->with("message","Erro ao atualizar:".$e->getMessage());
        }
    }

    function deleteService(Request $r){
        if (service::destroy($r->idService)){
            return redirect("/servicos")->with("message","Deletado com sucesso!");
        }else{
            return redirect("/servicos")->with("message","Erro ao deletar");
        }
        
    }

    function updateServiceForm(Request $r){
        return view("service.updateService",["service" => service::find($r->idService)]);
    }

    /** 
     * Verify user entries and return a valid service or throws a Exception 
    */
    function serviceValidation(Request $r,$service = new service()) : service{
        $r->validate([
            'name' => 'required|min:1',
            'price' => 'required|decimal:2|gt:0',
            'image' => 'image',
            'description' =>'required'
        ]);

        if(isset($r->image)){
            $this->checkImageSize($r->image);
            $service->image = $this->saveImage($r);
        }

        $service->name = $r->name;
        $service->description = $r->description;
        $service->price = floatval($r->price);
        
        return $service;
    }

    /* 
    *Save a image and return it's path
    */
    function saveImage(Request $r) : string{
        if($r->has("image")){
            $pathImage = "img/services/";
            $nameImage = time() . "." . $r->image->extension();

            $r->image->move(env("PUBLIC_FOLDER") . $pathImage , $nameImage);            
        }

        return $pathImage . $nameImage;
    }

    /* 
    *Check it's size
    */
    function checkImageSize($fileImage){
        //CONFERE TAMANHO DA image
        $sizeImage = getimagesize($fileImage);
        if($sizeImage[0]>1080 || $sizeImage[1]>1080){
            throw new Exception("Tamanho de imagem não permitido: ".$sizeImage[0]."x".$sizeImage[1]);
        }
    }

    /* 
    *Confirm page for deleting services
    */
    function deleteServiceConfirm(Request $r){
        return View("service.deleteServiceConfirm",["service" => service::findOrFail($r->idService)]);
    }
}
