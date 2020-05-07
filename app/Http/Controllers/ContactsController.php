<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        if (is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root == 0) {
            //superadministrador del colegio
            $colegio = App\Colegio_m::where([
                'id_superadministrador' => Auth::user()->id
            ])->first();
            $arr_usuarios = array();
            $i = 0;
            foreach ($colegio->docentes()->where('docente_d.estado', '=', 1)->get() as $docente) {
                $arr_usuarios[$i] = App\User::where([
                    'id_docente' => $docente->id_docente
                ])->first();
                $i++;
            }
            foreach ($colegio->grados()->where('grado_m.estado', '=', 1) as $grado) {
                foreach ($grado->secciones()->where('seccion_d.estado', '=', 1)->get() as $seccion) {
                    foreach ($seccion->alumnos()->where('alumno_d.estado', '=', 1)->get() as $alumno) {
                        $arr_usuarios[$i] = App\User::where([
                            'id_alumno' => $alumno->id_alumno
                        ])->first();
                        $i++;
                    }
                }
            }
            $contacts = collect($arr_usuarios);
        } else if (!is_null(Auth::user()->id_docente)) {
            $docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
            $arr_usuarios = array(App\User::findOrFail($docente->colegio->id_superadministrador));
            $i = 1;
            $colegas = App\Docente_d::where([
                ['id_colegio', '=', $docente->colegio->id_colegio],
                ['estado', '=', 1],
                ['id_docente', '<>', $docente->id_docente]
            ])->get();
            foreach ($colegas as $colega) {
                $arr_usuarios[$i] = App\User::where([
                    'id_docente' => $colega->id_docente
                ])->first();
                $i++;
            }

            foreach ($docente->secciones()->where('seccion_d.estado', '=', 1)->get() as $seccion) {
                foreach ($seccion->alumnos()->where('alumno_d.estado', '=', 1)->get() as $alumno) {
                    $arr_usuarios[$i] = App\User::where([
                        'id_alumno' => $alumno->id_alumno
                    ])->first();
                    $i++;
                }
            }

            $contacts = collect($arr_usuarios);
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

        return response()->json($contacts);
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
