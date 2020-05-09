<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App;
use Auth;

class ContactsController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/
    
    public function get()
    {
        $contacts = '';
        $friends = '';
        if (is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root == 0) {
            //superadministrador del colegio
            $colegio = App\Colegio_m::where([
                'id_superadministrador' => Auth::user()->id
            ])->first();
            $arr_usuarios = array();
            $i = 0;
            foreach ($colegio->docentes()->where('docente_d.estado', '=', 1)->get() as $docente) {
                $userDocente = App\User::where([
                    'id_docente' => $docente->id_docente
                ])->first();
                $userDocente->docente;
                $userDocente->is_online =  $userDocente->isOnline();
                $userDocente->ultimo_mensaje = 'ultimo mensaje para el docente';
                $arr_usuarios[$i] =  $userDocente;
                $i++;
            }
            foreach ($colegio->grados()->where('grado_m.estado', '=', 1)->get() as $grado) {
                foreach ($grado->secciones()->where('seccion_d.estado', '=', 1)->get() as $seccion) {
                    foreach ($seccion->alumnos()->where('alumno_d.estado', '=', 1)->get() as $alumno) {
                        $userAlumno = App\User::where([
                            'id_alumno' => $alumno->id_alumno
                        ])->first();
                        $userAlumno->alumno;
                        $userAlumno->is_online = $userAlumno->isOnline();
                        $userAlumno->ultimo_mensaje = 'Ultimo mensaje para el alumno';
                        $arr_usuarios[$i] = $userAlumno;
                        $i++;
                    }
                }
            }
            $contacts = collect($arr_usuarios);
        } else if (!is_null(Auth::user()->id_docente)) {
            $docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
            $userSuperAdmin = App\User::findOrFail($docente->colegio->id_superadministrador);
            $userSuperAdmin->colegio = $docente->colegio;
            $userSuperAdmin->is_online = $userSuperAdmin->isOnline();

            $u_con_conversacion = array();
            $u_sin_conversacion = array();

            $mensaje = App\Message::where([
                'from'=> Auth::user()->id,
                'to' => $userSuperAdmin->id
            ])->orderBy('created_at','DESC')->first();
            if(!is_null($mensaje) && !empty($mensaje)){
                $userSuperAdmin->ultimo_mensaje = $mensaje->text;
                $u_con_conversacion[] = $userSuperAdmin;
            }else{
                $userSuperAdmin->ultimo_mensaje = '';
                $u_sin_conversacion[] = $userSuperAdmin;
            }

            $colegas = App\Docente_d::where([
                ['id_colegio', '=', $docente->colegio->id_colegio],
                ['estado', '=', 1],
                ['id_docente', '<>', $docente->id_docente]
            ])->get();

            foreach ($colegas as $colega) {
                $userColega = App\User::where([
                    'id_docente' => $colega->id_docente
                ])->first();
                $userColega->docente;
                $userColega->is_online = $userColega->isOnline();

                $msg_colega = App\Message::where([
                    'from' => Auth::user()->id,
                    'to' => $userColega->id
                ])->orderBy('created_at','DESC')->first();
                
                if(!is_null($msg_colega) && !empty($msg_colega)){
                    $userColega->ultimo_mensaje = $msg_colega->text;
                    $u_con_conversacion[] = $userColega;
                }else{
                    $userColega->ultimo_mensaje = '';
                    $u_sin_conversacion[] = $userColega;
                }
            }

            foreach ($docente->secciones()->where('seccion_d.estado', '=', 1)->get() as $seccion) {
                foreach ($seccion->alumnos()->where('alumno_d.estado', '=', 1)->get() as $alumno) {
                    $userAlumno = App\User::where([
                        'id_alumno' => $alumno->id_alumno
                    ])->first();
                    $userAlumno->alumno;
                    $userAlumno->is_online = $userAlumno->isOnline();
                    $msg_alumno = App\Message::where([
                        'from' => Auth::user()->id,
                        'to' => $userAlumno->id
                    ])->orderBy('created_at','DESC')->first();

                    if(!is_null($msg_alumno) && !empty($msg_alumno)){
                        $userAlumno->ultimo_mensaje = $msg_alumno->text;
                        $u_con_conversacion[] = $userAlumno;
                    }else{
                        $userAlumno->ultimo_mensaje = '';
                        $u_sin_conversacion[] = $userAlumno;
                    }
                }
            }

            $contacts = collect($u_con_conversacion);
            $friends = collect($u_sin_conversacion);

        } else if (!is_null(Auth::user()->id_alumno)) {
            //alumno de una seccion
            $alumno = App\Alumno_d::findOrFail(Auth::user()->id_alumno);
            $colegio = $alumno->seccion->grado->colegio;

            $superAdmin = App\User::findOrFail($colegio->id_superadministrador);
            $superAdmin->colegio = $colegio;
            $superAdmin->ultimo_mensaje = 'Ultimo mensaje para superadmin';
            $arr_usuarios = array($superAdmin);
            $i = 1;

            foreach ($alumno->seccion->docentes()->where('docente_d.estado', '=', 1)->get() as $value_docente) {
                $userDocente = App\User::where([
                    'id_docente' => $value_docente->id_docente
                ])->first();
                $userDocente->docente;
                $userDocente->ultimo_mensaje = 'Ultimo mensaje para docente';

                $arr_usuarios[$i] = $userDocente;
                $i++;
            }

            foreach ($alumno->seccion->alumnos()->where([
                ['alumno_d.estado', '=', 1],
                ['id_alumno', '<>', Auth::user()->id_alumno]
            ])->get() as $value_alumno) {
                $userAlumno =  App\User::where([
                    'id_alumno' => $value_alumno->id_alumno
                ])->first();
                $userAlumno->alumno;
                $userAlumno->ultimo_mensaje = 'Ultimo mensaje para alumno';
                $arr_usuarios[$i] = $userAlumno;
                $i++;
            }
            $contacts = collect($arr_usuarios);
        }
        $unreadIds = App\Message::select(\DB::raw('`from` as sender_id,count(`from`) as messages_count'))
            ->where('to', Auth::user()->id)
            ->where('readmessage', false)
            ->groupBy('from')
            ->get();
        $contacts = $contacts->map(function ($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            /*if (is_null($contact->id_alumno) && is_null($contact->id_docente) && $contact->b_root == 0) {
                $contact->email = (App\Colegio_m::where('id_superadministrador', '=', $contact->id)->first())->c_representante_legal;
            } else if (!is_null($contact->id_docente)) {
                $contact->email = $contact->docente->c_nombre;
            } else if (!is_null($contact->id_alumno)) {
                $contact->email = $contact->alumno->c_nombre;
            }*/
            return $contact;
        });
        $datos = array(
            'contacts' => $contacts,
            'friends' => $friends
        );

        return response()->json($datos);
    }

    public function getMessagesFor($id)
    {
        //marcar todos los mensajes cuando se selecciona un usuario
        App\Message::where('from', $id)->where('to', Auth::user()->id)->update(['readmessage' => true]);
        $messages = App\Message::where(function ($q) use ($id) {
            $q->where('from', Auth::user()->id);
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', Auth::user()->id);
        })->get();

        return response()->json($messages);
    }
    public function send(Request $request)
    {
        $message = App\Message::create([
            'from' => Auth::user()->id,
            'to' => $request->contact_id,
            'text' => $request->text
        ]);

        broadcast(new newMessage($message));
        return response()->json($message);
    }
}
