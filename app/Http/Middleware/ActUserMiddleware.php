<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use App\Helpers\EventlogRegister;

class ActUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=$request->user();
        if($user->tipo_usuario_id!=6){
            $idreq=(int) $request->route()->parameter('user');
            if($idreq==$user->id){
                return $next($request);
            }
            $msj='No permitido. Usuario solo debe modificar su información. Usuario indenta modificar a id='.$idreq;
            $ev=new EventlogRegister;
            $ev->registro(0,$msj,$user->id);
            return response()->json(['msj'=>$msj]);
        }else{
            return $next($request);
        }
    }
}
