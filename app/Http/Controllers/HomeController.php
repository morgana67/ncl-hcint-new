<?php

namespace App\Http\Controllers;

use App\Functions\Functions;
use App\Models\Category;
use App\Models\DiseaseType;
use App\Models\LabLocation;
use App\Models\Page;
use App\Models\Post;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CatalogProduct;
use App\Models\Catalog;
use TCG\Voyager\Models\Role;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page = Page::withoutGlobalScopes()->where(['code_page' => 'home'])->first();
        $faq = Page::withoutGlobalScopes()->where(['code_page' => 'faq'])->first();
        $about = Page::withoutGlobalScopes()->where(['code_page' => 'about-us'])->first();
        return view('front.index',compact('page','faq','about'));
    }

    public function shop(){
        $products = array();
        $model = Product::select('name','slug','code')->active()->simpleType()->get();

        foreach ($model as $product) {
            $alphabet = substr($product->name, 0, 1);
            $products[$alphabet][] = $product;
        }
        ksort($products);
        return view('front.shop',compact('products'));
    }

    public function product_detail($slug){
        if (is_numeric($slug)){
            $product = Product::where('id',$slug)->firstOrFail();
        }else{
            $product = Product::where('slug',$slug)->firstOrFail();
        }

        $price_for_doctor = $this->getPriceForDoctor($product);

        return view('front.product-detail', compact('product', 'price_for_doctor'));
    }

    private function getPriceForDoctor($product)
    {
        $is_doctor = false;
        $price = 0;

        $user = user();

        if ($user !== null)
        {
            $role = Role::find($user->role_id);
            if (strtolower($role->name) == 'doctor') {
                $is_doctor = true;
                $price = $product->price_for_doctor;
            }
        }

        $price_for_doctor = [
            'is_doctor' => $is_doctor,
            'price'     => $price
        ];

        return $price_for_doctor;
    }


    public function testbydisease(){
        $diseaseTypes = DiseaseType::select('id','name')->orderBy('name','asc')->get();
        return view('front.testbydisease', compact('diseaseTypes'));
    }
    public function testlistbydisease($id = null){
        $disease = DiseaseType::where('id',$id)->firstOrFail();

        if(!empty($disease)){
            $products = Product::whereIn('id',explode(',',$disease->products))->get();
        }else{
            $products = "No Test Found";
        }
        //    print_r($get_product_details);exit;
        return view('front.testlistbydisease', compact('products','disease'));
    }

    public function blog(Request $request,$slug = ''){
        $where = array();
        $category = null;
        if (!empty($slug)){
            $category = Category::where('slug',$slug)->firstOrFail();
            $where[] = ['category_id','=',$category->id];
        }
        if ($request->has('q')){
            $where[] = ['title','LIKE','%'.$request->get('q').'%'];
        }
        $posts = Post::published()->where($where)->orderBy('featured', 'DESC')->orderBy('created_at', 'DESC')->paginate(9);
        $latestPosts = Post::published()->orderBy('created_at', 'DESC')->take(5)->get();
        $categories = Category::all();
        return view('front.blog',compact('posts','categories','latestPosts','category'));
    }

    public function post_detail($slug){
        $post = Post::published()->where([['slug','=',$slug]])->firstOrFail();
        $similarPosts = Post::where("category_id", '=', $post->category_id)->limit(3)->get();
        return view('front.blog-detail',compact('post','similarPosts'));
    }

    public function faq(){
        $faq = Page::withoutGlobalScopes()->where(['code_page' => 'faq'])->first();
        return view('front.faq',compact('faq'));
    }

    public function howToOrder(){
        $page = Page::withoutGlobalScopes()->where(['code_page' => 'how-to-order'])->first();
        return view('front.how-to-order',compact('page'));
    }

    public function aboutUs(){
        $page = Page::withoutGlobalScopes()->where(['code_page' => 'about-us'])->first();
        return view('front.about-us',compact('page'));
    }

    public function privacy(){
        $page = Page::withoutGlobalScopes()->where(['code_page' => 'privacy'])->first();
        return view('front.privacy',compact('page'));
    }
    public function terms(){
        $page = Page::withoutGlobalScopes()->where(['code_page' => 'terms'])->first();
        return view('front.terms',compact('page'));
    }

    public function credits(){
        $page = Page::withoutGlobalScopes()->where(['code_page' => 'site-credits'])->first();
        return view('front.credits',compact('page'));
    }

    public function page_detail($slug){
        $page = Page::where(['slug' => 'page/'.$slug])->firstOrFail();
        return view('front.page-detail',compact('page'));
    }

    public function locations(Request $request){
        $search['address'] = $request->input('address');
        $search['activity'] = $request->input('activity');
        $search['lat'] = $request->input('lat');
        $search['lng'] = $request->input('lng');

        $locations = array();
        if (!empty($search['address']) && !empty($search['activity']) && !empty($search['lat']) && !empty($search['lng'])) {
            try {
                $date = new DateTime('now', new DateTimeZone('UTC'));
                $dateFormat = $date->format('D, d M Y H:i:s O');
                $method = "POST";
                $uri = "/assets/psc/schedule/locations";
                $key = "{$method}\n\ntext/xml\n\nx-newcentury-date:{$dateFormat}\n{$uri}";
                $secret = "Q14zeK0turtrszgisqtsgsgsgsc7WzdnlkYZR==";
                $digestCode = HmacSHA1Encrypt($key, $secret);
                $xmlRequest = "<request version=\"1.0\">
                                    <radius>25</radius>
                                    <coordinates>
                                        <latitude>{$search['lat']}</latitude>
                                        <longitude>{$search['lng']}</longitude>
                                    </coordinates>
                                    <scheduling>YES</scheduling>
                                    <activity_id>{$search['activity']}</activity_id>
                                </request>";
                $url = "https://services-qa.questdiagnostics.com/assets/psc/schedule/locations";
                $headers = [
                    "Authorization: newcentury 1Y58HJ80-4859-43ZF-CEBB-A1763FG37D93:{$digestCode}",
                    "Date: {$dateFormat}",
                    "x-newcentury-date: {$dateFormat}",
                    "Content-Type: text/xml",
                ];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{$xmlRequest}");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                if(empty(json_decode($response, TRUE))) {
                    $response = simplexml_load_string($response);
                    $response = json_encode($response);
                    $response = json_decode($response, TRUE);
                    if($response['respcode'] == '200')
                        $locations = $response['location'];
                }

                if(count($locations) == 0 ) {
                    return view('front.locations')->with(['locations' => []])->withErrors(['No locations found']);
                }

				if (!isset($locations[0])) {
					$locations = [$locations];
				}

            } catch (\Exception $e) {
                return view('front.locations')->with(['locations' => []]);
            }
        }
        return view('front.locations',compact('locations'));
    }

    public function location($site_code, Request $request) {
        $uri = "/assets/facilities/psc/{$site_code}";
        $method = "GET";
        $date = new DateTime('now', new DateTimeZone('UTC'));
        $dateFormat = $date->format('D, d M Y H:i:s O');
        $key = "{$method}\n\ntext/xml\n\nx-newcentury-date:{$dateFormat}\n{$uri}";
        $secret = "Q14zeK0turtrszgisqtsgsgsgsc7WzdnlkYZR==";
        $digestCode = HmacSHA1Encrypt($key, $secret);
        $url = "https://services-qa.questdiagnostics.com{$uri}";
        $headers = [
            "Authorization: newcentury 1Y58HJ80-4859-43ZF-CEBB-A1763FG37D93:{$digestCode}",
            "Date: {$dateFormat}",
            "x-newcentury-date: {$dateFormat}",
            "Content-Type: text/xml",
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response, TRUE);
        if($response['respcode'] == '200') {
            $location = $response['location'];
        } else {
            abort(404,'No location found');
        }
        return view('front.location', compact('location'));
    }
}
