<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Config;

class AuthController extends Controller
{
    public $base_url = "https://testing.sparkdlens.com";
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'password' => 'required',
        ]);
        
        $apiURL = $this->base_url.'/oauth/token';
        $postInput = [
            'grant_type' => 'password',
            'client_id' => '96022a85-d94d-494b-8991-38368e0d2763',
            'client_secret' => 'wbvlDOzhKkmPaW7kLdBP7uj2sCuIpJ6nKsUKjhAm',
            'username' => $request->user_id,
            'password' => $request->password
        ];
  
        $headers = [
            'Accept' => 'application/json'
        ];
  
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $response = json_decode($response);
        if(!isset($response->access_token) || !isset($response->refresh_token))
        {
            return redirect('login')->with(['error_message'=> $response->message]);
        }

        Session::put('access_token',$response->access_token);
        Session::put('refresh_token',$response->refresh_token);
        $user_details = $this->user_details();
        $user_details = json_decode($user_details)->data;
        Session::put('user_name',$user_details->name);
        Session::put('participant_id',$user_details->last_participant->id);
        
        return redirect('/');

    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    public function user_details()
    {
        $apiURL = $this->base_url.'/api/user/me';
        return $response = Http::withToken(Session::get('access_token'))->get($apiURL);
    }

    public function personalDashboard()
    {
        $phase_distribution = array();
        $question_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
        $contrast_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
        $phase_code = "";
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/contrast';
        $response = Http::withToken(Session::get('access_token'))->get($apiURL);
        if(!empty($response)){
            $response = json_decode($response)->data;
            $phase_distribution = $response->phase_distribution;
        }

        $compareable = $this->comparable();
        if(!empty($compareable)){
            $compareable = json_decode($compareable)->data;
            $questions = $compareable->question_values;
            foreach($questions as $index=>$question )
            {
                $question_values[$question->display_order - 1] = $question->question_value;
                if($index == 5)
                {
                    break;
                }
            }
            $phase_code = $compareable->phase_code;
        }

        $contrast = $this->contrast();
        if(!empty($contrast))
        {
            $contrast = json_decode($contrast)->data;
            foreach($contrast->question_averages as $contrast_index=>$average)
            {
                $contrast_values[$average->display_order - 1] = $average->question_average;
                if($contrast_index == 5)
                {
                    break;
                }
            }
        }

        $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
        return view('personal_dashboard',compact('phase_distribution', 'states','phase_code','question_values','contrast_values'));
    }

    public function comparable()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/comparable';
        return $response = Http::withToken(Session::get('access_token'))->get($apiURL);   
    }

    public function contrast()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/contrast';
        return $response = Http::withToken(Session::get('access_token'))->get($apiURL);   
    }

    public function actionPlans()
    {
        $phase_code = "";
        $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
        $myactions = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions';
        $myactions = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions = json_decode($myactions);
        if(isset($myactions->data)){
            $myactions = $myactions->data;
        }

        $compareable = $this->comparable();
        if(!empty($compareable)){
            $compareable = json_decode($compareable)->data;
            $questions = $compareable->question_values;
            $phase_code = $compareable->phase_code;
        }

        $available_action_plans = $this->available_action_plans();
        $available_action_plans = json_decode($available_action_plans)->data;

        $phase_code = $phase_code != "" ? $states[$phase_code] : '';
        return view('action_plan', compact('myactions', 'phase_code','available_action_plans'));
    }

    public function deleteAction($action_id)
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/'.$action_id;
        $response = Http::withToken(Session::get('access_token'))->delete($apiURL); 
       return redirect()->back()->with(['success_message'=> 'Action plan deleted successfully']);
    }

    public function available_action_plans()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/available';
        return Http::withToken(Session::get('access_token'))->get($apiURL);  
    }
}
