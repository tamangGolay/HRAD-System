<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Ring\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

use GuzzleHttp\Client;
use DB;

class apiControllers extends Controller
{
    //

    public function __constructor(Request $request)
    {        
        $this->middleware('guest');
    }

    protected function getCIDDetailsFromApi(Request $request) {
        $myToken = "dad246e9-c8b9-3572-9507-c776e2a06984";//$this->generateToken(); //
        $cid = '11103000420';//$request->cid;
        $api_url ="https://staging-datahub-apim.dit.gov.bt/dcrc_citizen_details_api/1.0.0/citizendetails/11103000420";   
        //dd($api_url);
        $this->client = new Client([
            'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ),
            'base_uri' => env('API_BASE_URL'),
            'timeout'  => 2.0,
            ]);
            
        $user_response = $this->client->request('GET',$api_url,[
          'headers' => ['Authorization' => 'Bearer '.(string)$myToken],
              //'headers' => ['Authorization' => 'Bearer '.env('API_TOKEN')],                           
              'timeout' => 60,
         ]);

       // dd(response()->json_decode($user_response->getBody()->getContents()));

        return $user_response->getBody()->getContents();
        }
     protected function getAuthorizationCode() {
         return base64_encode(env('CONSUMER_KEY').':'.env('CONSUMER_SECRET'));
     }
 
     public function generateToken(){
 
       $this->client = new Client([
           'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ),
          'base_uri' => env('SSO_BASE_TOKEN_URL'),
           'timeout'  => 2.0,
           ]);
 
       $response = $this->client->request('POST', env('SSO_TOKEN_URL'), [
         'headers' => ['Authorization' => 'Basic '.$this->getAuthorizationCode()],
         'form_params' =>  [
         'grant_type' => 'client_credentials'
        ]
       ]);
    
       if($response->getStatusCode()==200)
       {
    
            $jsonObject = json_decode($response->getBody());
       
            $sessionObject = new SessionObject();
            $sessionObject->setAccessToken($jsonObject->access_token);
            $GLOBALS['APPLICATION_TOKEN']=$jsonObject->access_token;
            $expiryTime=(time() + $jsonObject->expires_in);
            $sessionObject->setTokenExpiryTime($expiryTime);
            $_SESSION["datahub_session"] = $sessionObject; // Set to $GLOBALS
    
            $global=$this->readGlobal();
            $global['accessToken']=$jsonObject->access_token;
            $global['expiryTime']=$expiryTime;
 
            $this->writeGlobal($global);
    
             return $global['accessToken'];   
       } else
       {    
         return "Something went wrong. Please try again!";    
       }
    }
       private function readGlobal() {
         $json=json_decode(file_get_contents('global.json'),true);
        return $json;
   
       }
   
       private function globalSession() {
        $json=json_decode(file_get_contents('global.json'),true);
        if(($json['accessToken']!="")&&($json['expiryTime']>time())) {
          return true;
        } else return false;
       }
 
       private function writeGlobal($json) {
         $fp = fopen('global.json', 'w');
         fwrite($fp, json_encode($json));
         fclose($fp);
       }


      
           


      

         //get checkin details
         public function getCheckindetail(Request $request)
         {
            //check if token is matching.
                $token = $request->token;
                $stoken = $request->session()->token();
    
            
                if($token != $stoken)
                {
                    return response("error:invalid session");   
                }
    
               //first check if data already exits and if not fetch from dcrc system.
               if(DB::table('tbl_check_in')->where('cid_passport_no','=',$request->cid)
                                            ->where('checkout_status',0)
                                            ->exists())
               {
                    $checkin = DB::table('tbl_check_in')->where('cid_passport_no','=',$request->cid)
                                    ->select('name','yob','gender')
                                    ->get();
    
    
                    foreach($checkin as $d)
                    {             
                        $retValues = array("name"=>$d->name,
                                    "yob"=>$d->yob,
                                    "gender"=>$d->gender,
                                    "message"=>"exists");
                    }
                    
    
                    //keep age to null to indicate that the details is ready registered.
                    return response(json_encode($retValues));
               }
               else {
                    $retValues = array("name"=>0,
                                    "yob"=>0,
                                    "gender"=>0,
                                    "nationality_id"=>1,
                                    "message"=>"norecord");
    
                     return response(json_encode($retValues));
                    }
         }



         public function getUserDetails(Request $request)
        {
        //check if token is matching.
            $token = $request->token;
            $stoken = $request->session()->token();
        
            if($token != $stoken)
            {
                return response("error:invalid session");   
            }

           //first check if data already exits and if not fetch from dcrc system.
           if(DB::table('users')->where('emp_id','=',$request->emp_id)->exists())
           {
                $user = DB::table('users')->where('emp_id','=',$request->emp_id)
                                ->select('name','emp_id')
                                ->limit(1)
                                ->get();


                foreach($user as $u)
                {             
                    $retValues = array("name"=>$u->name,
                                "emp_id"=>$u->emp_id,                          
                                "message"=>"exists");
                }

                //keep age to null to indicate that the details is ready registered.
                return response(json_encode($retValues));
           }
          
           else {
                $retValues = array("name"=>0,
                                "emp_id"=>0,
                              
                                "message"=>"norecord");                               

                 return response(json_encode($retValues));
           }
         
        }
}
