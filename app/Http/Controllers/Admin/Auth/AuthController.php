<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Model\Admin;
use App\Http\Model\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

require_once 'app/Vendor/code/Code.class.php';

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin/index';
    //protected $redirectPath = 'admin/index';
    protected $guard = 'admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
         * 这句话代表着除了getLogout之外的请求  其他的访问都是需要经过admin.guest中间件验证的
         * */
        $this->middleware('admin.guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|max:55',
            'code' => 'required|size:4',
            'email' => 'required|email|max:255|unique:'.$this->guard,
            'password' => 'required|confirmed|min:6',
        ];
        $messages = [
            'email.required' => '注册邮箱必须填写',
            'email.email' => '注册邮箱不满足邮箱基本格式',
            'email.unique' => '注册邮箱必须唯一（该邮箱已被注册过）',
            'name.required' => '用户名必填',
            'name.max' => '用户名不能超过55个字符',
            'code.size' => '验证码大小必须为4位',
            'code.required' => '验证码必填',
            'password.required' => '用户密码必填',
            'password.confirmed' => '两次输入密码不一致',
            'password.min' => '用户密码至少6位以上',
        ];
        return Validator::make($data,$rules,$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),// 使用了单向散列算法加密（不可解密） 默认使用这个较为安全
//            'password' => Crypt::encrypt($data['password']),// Crypt底层使用mcrypt_encrypt和mcrypt_decrypt进行加密和解密 mcrypt使用AES对称加密算法 支持解密
        ]);
    }

    /*
     * 登陆页
     * */
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /*
     * 提交登陆
     * */
    public function postLogin(Request $request)
    {
//        return $request->all();
        /*
         * 验证规则
         * */
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
            'code' => 'required',
        ];
        $messages = [
            'email.required' => '用户登录邮箱必须填写',
            'email.email' => '、用户登录名必须是邮箱格式',
            'password.required' => '用户密码必须填写',
            'code.required' => '验证码字段必须填写',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('admin/auth/login')
                ->withErrors($validator)
                ->withInput();
        }
        $in_code = $request->get('code');
        $code = $this->getCode();
        if (strtoupper($in_code) === $code) {
            $throttles = $this->isUsingThrottlesLoginsTrait();
            if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }
            $credentials = $this->getCredentials($request);
            if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
                return $this->handleUserWasAuthenticated($request, $throttles);
            }
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            if ($throttles && !$lockedOut) {
                $this->incrementLoginAttempts($request);
            }
            //返回错误的信息
            return redirect()->back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors("用户名或密码错误");
        } else {
            return back()->withErrors("验证码错误")->withInput();
        }

    }


    /*
     * 设置验证码
     * */
    public function getMakeCode()
    {
        $code = new \Code();
        return $code->make();
    }

    /*
     * 获取验证码
     * */
    public function getCode()
    {
        $code = new \Code();
        return $code->get();
    }

    /*
     * 注册页
     * */
    public function getRegister(){
        return view('admin.auth.register');
    }

    /*
     *提交注册
     * */
    public function postRegister(Request $request){
//        return $request->all();
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $in_code = $request->get('code');
        $code = $this->getCode();
        if(strtoupper($in_code)===$code){
            Auth::guard($this->guard)->login($this->create($request->all()));
            return redirect($this->redirectPath());
        }else{
            return back()->withErrors("验证码错误")->withInput($request->only('name', 'email'));
        }
    }

    /*
     * 退出登陆
     * */
    public function getLogout()
    {
//        dd('dsdas');
        Auth::guard($this->guard)->logout();
        return redirect('admin/auth/login');
    }



}
