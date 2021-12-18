<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class RajaOngkirController extends Controller
{
   protected $API_KEY = '14307389528944559944fe6ea8f01090'; 


   

   public function index()
   {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces = collect($response['rajaongkir']['results']);
        $data = $provinces->pluck('province_id','province');
        return view('ongkir',compact('data'));
   }

    public function getCities($id)
    {
        
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/city?&province='.$id.'');

        $cities = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get City By ID Provinces : '.$id,
            'data'    => $cities    
        ]);
    }

     public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin'            => $request->origin,
            'destination'       => $request->destination,
            'weight'            => 100,
            'courier'           => $request->courier
        ]);

        $ongkir = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Result Cost Ongkir',
            'data'    => $ongkir    
        ]);
    }
}
