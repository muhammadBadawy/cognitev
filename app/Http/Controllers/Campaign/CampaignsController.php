<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $campaigns = Campaign::where('name', 'LIKE', "%$keyword%")
                ->orWhere('url', 'LIKE', "%$keyword%")
                ->orWhere('category_id', 'LIKE', "%$keyword%")
                ->orWhere('budget', 'LIKE', "%$keyword%")
                ->orWhere('country', 'LIKE', "%$keyword%")
                ->orWhere('goal', 'LIKE', "%$keyword%")
                ->orWhere('category', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $campaigns = Campaign::latest()->paginate($perPage);
        }

        return view('campaign.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('campaign.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required|max:255',
			'url' => 'required|max:255',
			// 'category_id' => 'required|max:255|numeric',
			'budget' => 'required',
			'country' => 'required',
			'goal' => 'required',
			'category' => ''
		]);
        $requestData = $request->all();

        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://ngkc0vhbrl.execute-api.eu-west-1.amazonaws.com/api/?url='.$requestData['url']);
        $response = $request->getBody()->getContents();
        // echo '<pre>';
        $obj = json_decode($response);
        // print_r($response);
        $requestData['category_id'] = $obj->category->id;

        if ($requestData['category'] == "" || !isset($requestData['category']))
          $requestData['category'] = $obj->category->name;

        Campaign::create($requestData);
        // return $requestData;
        return redirect('client/campaigns')->with('flash_message', 'Campaign added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);

        return view('campaign.campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);

        return view('campaign.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'name' => 'required|max:255',
			'url' => 'required|max:255',
			'category_id' => 'required|max:255|numeric',
			'budget' => 'required',
			'country' => 'required',
			'goal' => 'required',
			'category' => 'required'
		]);
        $requestData = $request->all();

        $campaign = Campaign::findOrFail($id);
        $campaign->update($requestData);

        return redirect('client/campaigns')->with('flash_message', 'Campaign updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Campaign::destroy($id);

        return redirect('client/campaigns')->with('flash_message', 'Campaign deleted!');
    }

    public function report(Request $request)
    {


    /*
    @  IMPROTANT NOTICE : I could have used laravel elquent but laravel 5.5 has a problem at groupBy function so i did it the hard way
    */


        $requestData = $request->all();

        $campaign = Campaign::whereBetween('created_at', [$requestData['from'], $requestData['to']])
                            // ->groupBy('country')
                            ->get();
        // $campaign = DB::table('campaigns')
        //          ->select(DB::raw('*'))
        //          // ->whereBetween('created_at', [$requestData['from'], $requestData['to']])
        //          // ->groupBy('country')
        //          ->get();
        // return $requestData;
        $bag = [];
        foreach ($campaign as $key => $value) {

          if($requestData['dimention'] == 'country'){
            $arr_key = $value->country;
          }elseif($requestData['dimention'] == 'budget'){
            $arr_key = $value->budget;
          }elseif($requestData['dimention'] == 'category'){
            $arr_key = $value->category;
          }elseif($requestData['dimention'] == 'goal'){
            $arr_key = $value->goal;
          }

          if( !isset($bag[$arr_key]) ){
            $bag[$arr_key] = [$value];
          }
          else{
            $bag[$arr_key][] = $value;
          }
        }


        $output_data = [];

        foreach ($bag as $key => $group) {
          $output_data[$key] = [];
          foreach ($requestData['filters'] as $filter) {
            foreach ($group as $element) {

              if($filter == 'country'){

                if(!isset($output_data[$key][$element->country]))
                  $output_data[$key][$element->country] = 0;
                $output_data[$key][$element->country]+=1;
              }elseif($filter == 'budget'){
                // $element_required_field = $element->budget;
                if(!isset($output_data[$key][$element->budget]))
                  $output_data[$key][$element->budget] = 0;
                $output_data[$key][$element->budget]+=1;
              }elseif($filter == 'category'){
                // $element_required_field = $element->category;
                if(!isset($output_data[$key][$element->category]))
                  $output_data[$key][$element->category] = 0;
                $output_data[$key][$element->category]+=1;
              }elseif($filter == 'goal'){
                // $element_required_field = $element->goal;
                if(!isset($output_data[$key][$element->goal]))
                  $output_data[$key][$element->goal] = 0;
                $output_data[$key][$element->goal]+=1;
              }

            }
          }
        }

        return view('report.report_resault', compact('output_data'));
        // return $output_data;
    }
}
