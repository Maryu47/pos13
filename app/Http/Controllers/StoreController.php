<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Transection;

class StoreController extends Controller
{
    //

    public function __construct(){
        $this->middleware("auth:api");
    }

    public function index(){

        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $search = \Request::get('search');

        $store = Store::orderBy('id',$sort)
        ->where(
            function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%")
                ->orWhere('price_buy','LIKE',"%{$search}%");
            }
        )
        ->paginate($perpage)
        ->toArray();

        return array_reverse($store);

        // $store = Store::orderBy('id','asc')->get();
        // return $store;

    }

    public function add(Request $request){
        try {


            $upload_path = "assets/img";

            // ກວດຊອບໄຟລ໌ ທີ່ອັບໂຫຼດມາ
            if($request->file("image")){

                // return $request->file("image");
                // ສ້າງຊື່ຮູບພາບໃໝ່
                $generate_new_name = time().".".$request->image->getClientOriginalExtension();
                // ອັບໂຫຼດຮູບພາບ
                $request->image->move(public_path($upload_path),$generate_new_name);
                // return $generate_new_name;
            } else {
                // return "No img";
                $generate_new_name = '';
            }
            
            $store = new Store([
                'name' => $request->name,
                'image' => $generate_new_name,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);

            $store->save();
            $product_id = $store->id;

            // ບັນທຶກການເຄຶ່ອນໄຫວ ເພິ່ມສິນຄ້າໃໝ່

            $number = '';
                $read_tran = Transection::all()->sortbyDesc('id')->take(1)->toArray();
                foreach($read_tran as $new){
                    $number = $new['tran_id'];
                }

                if ($number!= '') {
                    $number1 = str_replace("INC","",$number); // INC00001 = 00001
                    $number2 = str_replace("INC","",$number1); // INC00001 = 00001
                    $number3 = (int)$number2+1; //1+1= 2
                    $length = 5;
                    $number = substr(str_repeat(0, $length).$number3, - $length); //00002
                } else {
                    $number3 = 1;
                    $length = 5;
                    $number = substr(str_repeat(0, $length).$number3, - $length); //00002
                }

                $tran = new Transection([
                    'tran_id' => "EXP".$number,
                    'tran_type' => "expense",
                    'product_id' => $product_id,
                    'amount' => $request->amount,
                    'price' => $request->amount*$request->price_buy,
                    'tran_detail' => "ຊື້ສິນຄ້າໃໝ່ ".$request->name,
                ]);
                $tran->save();

            $success = true;
            $message = 'ບັນທຶກສຳເລັດ!';
            

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }

    public function edit($id){
        $store = Store::find($id);
        return $store;
    }


    public function update($id, Request $request){
        try {
            
            $store = Store::find($id);
            $upload_path = "assets/img";

            // ກວດຊອບວ່າ ມີຮູບພາບ ຖຶກສົ່ງມາຫຼືບໍ່
            if($request->file("image")){

                // ຖ້າມີຮູບພາບສົ່ງມາໃໝ່ ຕ້ອງທຳການລຶບຮູບເກົ່າອອກກ່ອນ ແລ້ວຈື່ງອັບໂຫຼດໃໝ່

                if($store->image){
                    if(file_exists($upload_path."/".$store->image)){
                        unlink($upload_path."/".$store->image); // ລຶບໄຟລ໌ເກົ່າອອກ
                    }
                }

                // ອັບໂຫຼດໃໝ່ 
                $generate_new_name = time().".".$request->image->getClientOriginalExtension();
                $request->image->move(public_path($upload_path),$generate_new_name);

                $store->update([
                    'name' => $request->name, 
                    'image' => $generate_new_name, 
                    'amount' => $request->amount, 
                    'price_buy' => $request->price_buy, 
                    'price_sell' => $request->price_sell, 
                ]);
    

            } else {

                if($request->image){ // ກໍລະນີ ຮູບພາບບໍ່ມີການປ່ຽນແປງ

                    $store->update([
                        'name' => $request->name, 
                        // 'image' => $generate_new_name, 
                        'amount' => $request->amount, 
                        'price_buy' => $request->price_buy, 
                        'price_sell' => $request->price_sell, 
                    ]);

                } else { // ມີການປ່ຽນແປງ 

                    if(file_exists($upload_path."/".$store->image)){
                        unlink($upload_path."/".$store->image); // ລຶບໄຟລ໌ເກົ່າອອກ
                    }

                    $store->update([
                        'name' => $request->name, 
                        'image' => '', 
                        'amount' => $request->amount, 
                        'price_buy' => $request->price_buy, 
                        'price_sell' => $request->price_sell, 
                    ]);

                }

            }


          
            $success = true;
            $message = 'ອັບເດດສຳເລັດ!';
            

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }

    public function delete($id){
        try {
            
            $store = Store::find($id);
            $upload_path = "assets/img";

            if($store->image){
                if(file_exists($upload_path."/".$store->image)){
                    unlink($upload_path."/".$store->image); // ລຶບໄຟລ໌ເກົ່າອອກ
                }
            }

            $store->delete();

            $success = true;
            $message = 'ລຶບສຳເລັດ!';
            

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }
}
