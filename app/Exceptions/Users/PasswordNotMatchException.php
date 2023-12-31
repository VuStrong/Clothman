<?php
 
namespace App\Exceptions\Users;
 
use Exception;
use Illuminate\Http\Request;

class PasswordNotMatchException extends Exception
{
    public function __construct()
    {
        parent::__construct("Mật khẩu không khớp");
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'message' => $this->getMessage()
            ], 400);
        }
    
        return false;
    }
}