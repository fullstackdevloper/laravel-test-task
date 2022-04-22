<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Analytics; 
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DataTables;
use App\Models\User;
class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * dashboard view
     * @return type
     */
    public function index()
    {
           
        return view('admin.dashboard');
    }
    public function analyticData(Request $request)
    {
        if(!empty($request->timeInterval)){
            $date_range= explode('-',$request->timeInterval);
            $start_date=$date_range[0];
            $end_date=$date_range[1];
            $start_date = date("Y-m-d", strtotime($start_date));
            $end_date = date("Y-m-d", strtotime($end_date));
            $StartDate = $start_date.' 00:00:00';
            $endDate = $end_date.' 23:59:59';
            $period = new CarbonPeriod($StartDate, '1 day', $endDate);
         
            $lables=[];
            $data=Analytics::fetchTotalVisitorsAndPageViews(Period::days(count($period)));
           
        }else{
            $lables=[];
            $data=Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
        }
        
       
        foreach ($data as $dt) {
           
          
      
          
            $datas[0]=$dt['date']->format("dM");
            $datas[1]=$dt['visitors'];
     
            
                array_push($lables,$datas);           
           }
           $header[0]='Date';
           $header[1]='User';
     
           array_unshift($lables,$header);
        $finalData=   json_encode($lables);
        return response()->json($finalData);
    }
    public function fetchData(  Request $request)
    {
  
    if(!empty($request->time)){
        $date_range= explode('-',$request->time);
        $start_date=$date_range[0];
        $end_date=$date_range[1];
    }else{
        $start_date=Carbon::now()->subDays(30);
        $end_date=Carbon::now();
    }
       
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
        $StartDate = $start_date;
        $endDate = $end_date;
        $period = new CarbonPeriod($StartDate, '1 day', $endDate);
       
        $lables=[];
        $links=[];

        $data = Analytics::performQuery(
            Period::days(count($period)),
            'ga:sessions',
            [
                'dimensions' => 'ga:medium',
                'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goalCompletionsAll,ga:goalValueAll',
   
                'sort' => '-ga:sessions',

            ]
        );
        $gloablKey = 1;
        $linkedId=1;
        foreach ($data['rows'] as $key => $value) {
            
           
            $fetchData['id']= $gloablKey++;

            $fetchData['text']=$value[0];
            $fetchData['start_date']=$start_date;
            $fetchData['duration']=count($period);
            array_push($lables,$fetchData);   
          if($value[0] == 'referral'){
            $referalData = Analytics::performQuery(
                Period::days(count($period)),
                'ga:sessions',
                [
                    'dimensions' => 'ga:source',
                    'metrics' => 'ga:users',
                    'filters' => 'ga:medium==referral',
                    'sort' => '-ga:users',

                ]
            );
       
            foreach ($referalData['rows'] as $referalKey => $values) {
                // $fetchData['id']=++$key;
                $referal['id']=$gloablKey++;

                $referal['text']=$values[0];
                $referal['start_date']=$start_date;
                // $referal['end_date']=$start_date;
    
          
                $referal['parent']=$fetchData['id'];
                $referal['duration']=count($period);
                $gloablKey = $gloablKey + $key;
                $linked['id']=$linkedId;
                $linked['source']=$fetchData['id'];
                $linked['target']=$referal['id'];
                $linked['type']=1;
                array_push($links,$linked);
                array_push($lables,$referal);   

            }
          }elseif($value[0] == 'organic'){
            $organicData = Analytics::performQuery(
                Period::days(count($period)),
                'ga:sessions',
                [
                    'dimensions' => 'ga:source',
                    'metrics' => 'ga:users',
                    'filters' => 'ga:medium==organic',
                    'sort' => '-ga:users',

                ]
            );
            
            foreach ($organicData['rows'] as $key => $values) {
                // $fetchData['id']=++$key;
                $organic['id']=$gloablKey++;

                $organic['text']=$values[0];
                $organic['start_date']=$start_date;
                
    
          
                $organic['parent']=$fetchData['id'];
                $organic['duration']=count($period);
                $linked['id']=$linkedId++;
                $linked['source']=$fetchData['id'];
                $linked['target']=$organic['id'];
                $linked['type']=1;
                array_push($links,$linked);
                array_push($lables,$organic);   

            }
          }else{

            $directData = Analytics::performQuery(
                Period::days(count($period)),
                'ga:sessions',
                [
                    'dimensions' => 'ga:pagePath',
                    'metrics' => 'ga:users',
                    'sort' => '-ga:users',
                ]
            );
            // print_r($directData);die;
            foreach ($directData['rows'] as $key => $values) {
              
                $direct['id']=$gloablKey++;
                $direct['text']=$values[0];
                $direct['start_date']=$start_date;
                $direct['parent']=$fetchData['id'];
                $direct['duration']=count($period);
                $linked['id']=$linkedId++;
                $linked['source']=$fetchData['id'];
                $linked['target']=$direct['id'];
                $linked['type']=1;
                array_push($links,$linked);
                array_push($lables,$direct);   

            }
           
          }

        

                   
           }
     

        echo   '{'.'"'.'tasks'.'":'. json_encode($lables).',"links":'.json_encode($links).'}'  ;

   
    }


    public function direct_data(Request $request){
        
        if ($request->ajax())
        {
            if(!empty($request->timeInterval)){
                $date_range= explode('-',$request->timeInterval);
                $start_date=$date_range[0];
                $end_date=$date_range[1];
                $start_date = date("Y-m-d", strtotime($start_date));
                $end_date = date("Y-m-d", strtotime($end_date));
                $StartDate = $start_date.' 00:00:00';
                $endDate = $end_date.' 23:59:59';
                $period = new CarbonPeriod($StartDate, '1 day', $endDate);
             
                $lables=[];
        
            $data = Analytics::performQuery(
                Period::days(count($period)),
                    'ga:sessions',
                    [
                        'dimensions' => 'ga:medium',
                        'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goalCompletionsAll,ga:goalValueAll',
           
                        'sort' => '-ga:sessions',
  
                    ]
            );
           
            }else{
                $lables=[];
                // $data=Analytics::fetchMostVisitedPages(Period::days(30));
                $data = Analytics::performQuery(
                    Period::days(30),
                    'ga:sessions',
                    [
                        'dimensions' => 'ga:medium',
                        'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goalCompletionsAll,ga:goalValueAll',
           
                        'sort' => '-ga:sessions',
  
                    ]
                );


            }
         
         
            return Datatables::of($data['rows'])
            ->addIndexColumn()
            ->addColumn('link', function ($row)
            {
               

                $link = 
                '<a  class="changeTable" id="'.$row[0].'" ><i ></i>
                '.$row[0].'
                </a>';
                return $link;
            })
            ->addColumn('value', function ($row)
                            {
                               

                                $value = 'US$'.$row[8];
                                return $value;
                            })
                            ->rawColumns(['link'])
                            ->make(true);
        }
       

    }

    public function referal_data(Request $request){
           
        if ($request->ajax())
        {
           
            if($request->id== 'referral'){
             
                    if(!empty($request->timeInterval)){
                        $date_range= explode('-',$request->timeInterval);
                        $start_date=$date_range[0];
                        $end_date=$date_range[1];
                        $start_date = date("Y-m-d", strtotime($start_date));
                        $end_date = date("Y-m-d", strtotime($end_date));
                        $StartDate = $start_date.' 00:00:00';
                        $endDate = $end_date.' 23:59:59';
                        $period = new CarbonPeriod($StartDate, '1 day', $endDate);
                    
                
            
                    $data = Analytics::performQuery(
                        Period::days(count($period)),
                        'ga:sessions',
                        [
                            'dimensions' => 'ga:source',
                            'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goal1Completions,ga:goalValueAll',
                            'filters' => 'ga:medium==referral',
                            'sort' => '-ga:users',
        
                        ]
                    );
                }else{
                    
                        
                
                        $data = Analytics::performQuery(
                            Period::days(30),
                            'ga:sessions',
                            [
                                'dimensions' => 'ga:source',
                                'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goal1Completions,ga:goalValueAll',
                                'filters' => 'ga:medium==referral',
                                'sort' => '-ga:users',
        
                            ]
                        );

                
                    }
            }elseif($request->id== 'organic'){
                if(!empty($request->timeInterval)){
                    $date_range= explode('-',$request->timeInterval);
                    $start_date=$date_range[0];
                    $end_date=$date_range[1];
                    $start_date = date("Y-m-d", strtotime($start_date));
                    $end_date = date("Y-m-d", strtotime($end_date));
                    $StartDate = $start_date.' 00:00:00';
                    $endDate = $end_date.' 23:59:59';
                    $period = new CarbonPeriod($StartDate, '1 day', $endDate);
                
            
        
                $data = Analytics::performQuery(
                    Period::days(count($period)),
                    'ga:sessions',
                    [
                        'dimensions' => 'ga:source',
                        'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goal1Completions,ga:goalValueAll',
                        'filters' => 'ga:medium==organic',
                        'sort' => '-ga:users',
    
                    ]
                );
            }else{
                
                    
            
                    $data = Analytics::performQuery(
                        Period::days(30),
                        'ga:sessions',
                        [
                            'dimensions' => 'ga:source',
                            'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goal1Completions,ga:goalValueAll',
                            'filters' => 'ga:medium==organic',
                            'sort' => '-ga:users',
    
                        ]
                    );

            
                }

            }else{
                if(!empty($request->timeInterval)){
                    $date_range= explode('-',$request->timeInterval);
                    $start_date=$date_range[0];
                    $end_date=$date_range[1];
                    $start_date = date("Y-m-d", strtotime($start_date));
                    $end_date = date("Y-m-d", strtotime($end_date));
                    $StartDate = $start_date.' 00:00:00';
                    $endDate = $end_date.' 23:59:59';
                    $period = new CarbonPeriod($StartDate, '1 day', $endDate);
                
            
        
                $data = Analytics::performQuery(
                    Period::days(count($period)),
                    'ga:sessions',
                    [
                        'dimensions' => 'ga:pagePath',
                        'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goal1Completions,ga:goalValueAll',
                        'sort' => '-ga:users',
                    ]
                );
            }else{
                
                    
            
                    $data = Analytics::performQuery(
                        Period::days(30),
                        'ga:sessions',
                        [
                                      'dimensions' => 'ga:pagePath',
                    'metrics' => 'ga:users,ga:newUsers,ga:sessions,ga:bounces,ga:timeOnPage,ga:sessionDuration,ga:goal1Completions,ga:goalValueAll',
                    'sort' => '-ga:users',
    
                        ]
                    );

            
                }
            }
     
           
            if(empty($data['rows'])){  
                $data = [];
                $row = [[0=>'',1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'',8=>'']];
                $data['rows'] = $row;
            }

            return Datatables::of($data['rows'])
            ->addIndexColumn()
            ->addColumn('value', function ($row)
                            {
                               

                                $value = 'US$'.$row[8];
                                return $value;
                            })
            ->make(true);
       
         
        }      
        

    }
}
