<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ExtBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->input("page") ?? 1;
        $perPage = 5;
        $offset = ($page-1) * $perPage;
        $sortfield = $request->input("sortfield") ?? "created_at";
        $sortmethod = $request->input("sortmethod") ?? "desc";
        $searchfield = request()->input("searchfield");
        $searchtext = request()->input("searchtext");
        $matchtext = $searchfield && $searchtext ? "'match' => ['".$searchfield ."' => '". $searchtext."']": "'match_all' => new \stdClass()";
/*        echo "page :".$page;
        echo "offset : ".$offset;
        echo "sortfield :".$sortfield.PHP_EOL;
        echo "sortmethod : ".$sortmethod;
        echo "searchfield : ".$searchfield;
        echo "searchtext : ".$searchtext;
        echo "matchtext : ".$matchtext;
        $testtext="'match' => ['content' => 'Atque'\]";
        echo "testtext : ".$testtext;*/
        $hosts = [
            'http://192.168.56.2:9200'
        ];
        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
        $params = [
            'index' => 'board_document',
            'from'   => $offset,
            'size'   => 5,
            'body'   => [
                "sort" => [
                    $sortfield => $sortmethod,
                ],
                /*'query' => [
                    'match' => ['content' => 'Atque']
                   ],
                    'query' => [
                        'match_all' => new \stdClass()
                    ]*/
                "highlight" => [
                    "type" => "unified",
                    "number_of_fragments" => "3",
                    "fragment_size" => 150,
                    "fields" => [
                        $searchfield => [ "pre_tags" => "<b style='color: #4cd213'>", "post_tags" => "</b>" ]
                    ]
                ]
            ]
        ];
        $params['body']['query'] = $searchfield && $searchtext ? ['match' => [$searchfield => $searchtext]] : ['match_all' => new \stdClass()];
        $result = $client->search($params);
        $getboardslist = $result["hits"]["hits"];
        $count = $result["hits"]["total"]["value"];
        $boardspagearr = [];
        foreach($getboardslist as $board){
            array_push($boardspagearr, $board);
        }
        $boards = $boardspagearr;
        $boardsmakepagearrs = array_slice($boardspagearr, $offset, $perPage);
        $boardspagearr = new LengthAwarePaginator($boardsmakepagearrs, $count, $perPage, $page, ['path'  => $request->url(),'query' => $request->query(),]);

        return view('board.index', ['boardspagearr' => $boardspagearr,'boards' => $boards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
