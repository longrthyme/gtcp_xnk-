<?php
#App\Plugins\Cms\ProductReview\Controllers\FrontController.php
namespace App\Plugins\Cms\ProductReview\Controllers;

use App\Plugins\Cms\ProductReview\AppConfig;
use App\Http\Controllers\Controller;
use App\Plugins\Cms\ProductReview\Models\PluginModel;

use Intervention\Image\ImageManagerStatic as Image;

use Validator;
class FrontController extends Controller
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function postReview() {
        // dd('fdafa');
        /*if (!auth()->user()) {
            return redirect()->guest(sc_route('login'));
        }*/
        $data = request()->all();
        $validate = [
            'product_id' => 'required',
            'comment' => 'required|string|max:300|min:10',
            'point' => 'required|numeric|min:1|max:5',
        ];

        $validator = Validator::make($data, $validate);
        
        if ($validator->fails()) {
            /*return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);*/
            return response()->json([
                'error' => 1,
                'msg' => $validator->errors()->first()

            ]);
        }
        // dd($data);
        //upload image comment
        $picture = [];
        $folderPath = 'upload/image-comment/';
        if(request()->picture_rate){

            $year = date('Y');
            $m = date('m');
            $dir = $folderPath . $year;
            $dir_m = $folderPath . $year.'/'.$m;
            if (is_dir($dir) === false) {
                mkdir($dir);
            }
            if (is_dir($dir_m) === false) {
                mkdir($dir_m);
            }

            $files = request()->file("picture_rate");
            // dd($files);
            if(request()->hasFile('picture_rate'))
            {
                foreach ($files as $key => $file) {
                    $file_name = uniqid() . '-' . $file->getClientOriginalName();
                    $img_name = '/' . $dir_m . '/' . $file_name;
                    $picture[] = $img_name;
                    
                    $image_resize = Image::make($file->getRealPath());
                    /* insert watermark at bottom-right corner with 10px offset */
                    // $image_resize->insert(public_path('theme/images/logo-white.png'), 'center-center', 0, 0);
                
                    $image_resize->save( $dir_m.'/'.$file_name );

                    // $file->move( public_path($dir_m), $file_name );
                    
                }
            }
        }
        // dd($picture);
        //upload image comment
        $picture = $picture!= null ? json_encode($picture) : '';    
        $dataInsert = [
            'product_id' => $data['product_id'],
            'customer_id' => auth()->user()->id ?? 0,
            'name' => $data['name'],
            'picture' => $picture,
            'phone' => $data['phone'] ?? '',
            'email' => $data['email'] ?? '',
            'comment' => strip_tags(str_replace("\n", "<br>", $data['comment']), '<br>'),
            'point' => min((int)$data['point'], 5),
            'status' => 1,
        ];

        // $dataInsert = sc_clean($dataInsert);
        PluginModel::create($dataInsert);

        return response()->json([
            'error' => 0,
            'msg' => 'Gửi đánh giá thành công'

        ]);
        return redirect()->back()->with('success', trans($this->plugin->pathPlugin.'::lang.submit_success'));
    }

    /**
     * Remove review
     * @return [type] [description]
     */
    public function removeReview()
    {
        if (!auth()->user()) {
            return redirect()->guest(sc_route('login'));
        }
        $data = request()->all();
        $id = $data['id'];
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $uID = auth()->user()->id;
            $review = PluginModel::where('id', $id)->where('customer_id', $uID)->first();
            if ($review) {
                $review->delete();
                return response()->json(['error' => 0, 'msg' => 'OK']);
            } else {
                return response()->json(['error' => 1, 'msg' => 'Access denied']);
            }
        }

    } 

}
