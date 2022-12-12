<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

//請完成下方所有方法的實作，並撰寫對應的路由，用 Postman 來進行測試
class ArticleController extends Controller
{
    /**
     * 回傳該表格的所有資料，以 sort 欄位從小到大排序
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Article::orderBy('sort', 'asc')->get();
        return $result;
    }

    /**
     * 儲存前端傳入的資料，成功後回傳儲存的內容
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Article::create($request->all());   //設黑白名單 app\Models\Article.php 不然會 Mass Assignment

        // $task = new Article( [
        //     'subject' => $request->input('subject'),
        //     'content' => $request->input('content'),
        //     'enabled_at' => $request->input('enabled_at'),
        //      'pic' => $request->input('pic'),
        //     'sort' => $request->input('sort'),
        //     'enabled' => $request->input('enabled'),
        //     'cgy_id' => $request->input('cgy_id')
        //     ]);
        // $task->save();

        // return '...chk db';
        return Article::latest()->firstOrFail();
    }

    /**
     * 回傳指定的資料
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Article::findOrFail($id);
    }

    /**
     * 更新指定的資料，成功後回傳更新後的內容
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ！注意！ postman 的 Header 和 Body 要做相對應設定，否則無法收到要更新的資料...（坑我好久　＠＠）

        // dd($request->all());
        // Article::updateOrCreate(['id' => $id], $request->all())->fresh();
        tap(Article::findOrFail($id))->update($request->all());
        return Article::findOrFail($id);
    }

    /**
     * 刪除指定的資料，成功後回傳 Success
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return Article::where('id',$id)->delete() ? 'Success' : 'Delete Fail ！';
        return Article::destroy($id) ? 'Success' : 'Delete Fail ！';
    }

    //查詢所有資料，只取 id , subject 以及 content 這三個欄位
    public function querySelect()
    {
        return Article::select(['id','subject','content'])->get();
        // return Article::pluck($array, 'id','subject','content');
    }

    //查詢 enabled_at 於 2022/12/13 00:00:00 之後，enabled 為 true 的資料，按照 created_at 從新到舊排序，回傳第一筆資料的 subject 欄位內容
    public function querySpecific()
    {
        // return 'Specific';

        // return Article::select(['id','subject','created_at','enabled_at'])
        return Article::select('subject')

        ->where([
            ['enabled_at','>','2022/12/13'],
            ['enabled',true]
        ])

        // ->where('enabled_at','>=','2022/12/13')
        // ->where('enabled',true)

        ->orderBy('created_at', 'desc')
        // ->get();
        ->firstOrFail();


    }

    //查詢 enabled_at 於 2022/12/10 00:00:00 之後，enabled 為 true 的資料，按照 created_at 從新到舊排序，回傳第2~4筆資料
    public function queryPagination()
    {
        // return 'Pagiination';

        // return Article::select(['id','subject','created_at','enabled_at'])
        // return Article::select('subject')
        return Article::select('*')
        // return DB::table('articles')
        ->where([
            ['enabled_at','>',new Carbon('2022/12/10')],
            ['enabled',true]
        ])
        ->orderBy('created_at', 'desc')
        // ->skip(1)->take(3)
        ->offset(1)->limit(3)
        ->get();    
    }

    //查詢 enabled_at 介於 2022/12/10 00:00:00 和 2022/12/15 23:59:59 之間，sort 位於 $min 到 $max 之間的資料並回傳
    public function queryRange($min,$max)
    {
        // return "queryRange ： min = $min  , max = $max";

        // return Article::select('*')
        return DB::table('articles')
        ->whereBetween('enabled_at', [new Carbon('2022/12/10'), new Carbon('2022/12/15 23:59:59')])
        ->whereBetween('sort',[$min,$max])
        ->get(); 
    }

    //根據所傳入的分類id，取出該分類所有 enabled 為 true 的資料，依照 sort 從小到大排序，回傳符合的資料
    public function queryByCgy($cgy_id)
    {
        return Article::select('*')
        ->where([
            ['enabled',true],
            ['cgy_id',$cgy_id],
        ])
        ->orderBy('sort','asc')
        ->get();
    }

    //試著使用 pluck() 來取得 id 為 key ， subject 為 value 的陣列
    public function queryPluck()
    {
        return Article::pluck('subject','id');
    }

    //計算所有 enabled 為 true 的資料筆數後回傳，利用查詢方法 count()
    public function enabledCount()
    {
        return DB::table('articles')->where('enabled',true)->count();
    }
}
