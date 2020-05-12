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
        $groups = '';
        if (is_null(Auth::user()->id_docente) && is_null(Auth::user()->id_alumno) && Auth::user()->b_root == 0) {
            //superadministrador del colegio
            $colegio = App\Colegio_m::where([
                'id_superadministrador' => Auth::user()->id
            ])->first();
            $u_con_conversacion = array();
            $u_sin_conversacion = array();

            foreach ($colegio->docentes()->where('docente_d.estado', '=', 1)->get() as $docente) {
                $userDocente = App\User::where([
                    'id_docente' => $docente->id_docente
                ])->first();
                $userDocente->docente;
                $userDocente->is_online =  $userDocente->isOnline();
                $id_docente = $userDocente->id;
                $msg_docente = App\Message::where(function ($q) use ($id_docente) {
                    $q->where('emisor', Auth::user()->id);
                    $q->where('receptor', $id_docente);
                })->orWhere(function ($q) use ($id_docente) {
                    $q->where('emisor', $id_docente);
                    $q->where('receptor', Auth::user()->id);
                })->orderBy('created_at', 'DESC')->first();

                if (!is_null($msg_docente) && !empty($msg_docente)) {
                    $userDocente->ultimo_mensaje = $msg_docente->text;
                    $u_con_conversacion[] = $userDocente;
                } else {
                    $userDocente->ultimo_mensaje = '';
                    $u_sin_conversacion[] = $userDocente;
                }
            }
            foreach ($colegio->grados()->where('grado_m.estado', '=', 1)->get() as $grado) {
                foreach ($grado->secciones()->where('seccion_d.estado', '=', 1)->get() as $seccion) {
                    foreach ($seccion->alumnos()->where('alumno_d.estado', '=', 1)->get() as $alumno) {
                        $userAlumno = App\User::where([
                            'id_alumno' => $alumno->id_alumno
                        ])->first();
                        $userAlumno->alumno;
                        $userAlumno->is_online = $userAlumno->isOnline();

                        $id_alumno = $userAlumno->id;
                        $msg_alumno = App\Message::where(function ($q) use ($id_alumno) {
                            $q->where('emisor', Auth::user()->id);
                            $q->where('receptor', $id_alumno);
                        })->orWhere(function ($q) use ($id_alumno) {
                            $q->where('emisor', $id_alumno);
                            $q->where('receptor', Auth::user()->id);
                        })->orderBy('created_at', 'DESC')->first();

                        if (!is_null($msg_alumno) && !empty($msg_alumno)) {
                            $userAlumno->ultimo_mensaje = $msg_alumno->text;
                            $u_con_conversacion[] = $userAlumno;
                        } else {
                            $userAlumno->ultimo_mensaje = '';
                            $u_sin_conversacion[] = $userAlumno;
                        }
                    }
                }
            }
            $contacts = collect($u_con_conversacion);
            $friends = collect($u_sin_conversacion);
        } else if (!is_null(Auth::user()->id_docente)) {
            $docente = App\Docente_d::findOrFail(Auth::user()->id_docente);
            $userSuperAdmin = App\User::findOrFail($docente->colegio->id_superadministrador);
            $userSuperAdmin->colegio = $docente->colegio;
            $userSuperAdmin->is_online = $userSuperAdmin->isOnline();

            $u_con_conversacion = array();
            $u_sin_conversacion = array();

            $id_superadmin = $userSuperAdmin->id;
            $mensaje = App\Message::where(function ($q) use ($id_superadmin) {
                $q->where('emisor', Auth::user()->id);
                $q->where('receptor', $id_superadmin);
            })->orWhere(function ($q) use ($id_superadmin) {
                $q->where('emisor', $id_superadmin);
                $q->where('receptor', Auth::user()->id);
            })->orderBy('created_at', 'DESC')->first();
            if (!is_null($mensaje) && !empty($mensaje)) {
                $userSuperAdmin->ultimo_mensaje = $mensaje->text;
                $u_con_conversacion[] = $userSuperAdmin;
            } else {
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
                $id_colega = $userColega->id;
                $msg_colega = App\Message::where(function ($q) use ($id_colega) {
                    $q->where('emisor', Auth::user()->id);
                    $q->where('receptor', $id_colega);
                })->orWhere(function ($q) use ($id_colega) {
                    $q->where('emisor', $id_colega);
                    $q->where('receptor', Auth::user()->id);
                })->orderBy('created_at', 'DESC')->first();

                if (!is_null($msg_colega) && !empty($msg_colega)) {
                    $userColega->ultimo_mensaje = $msg_colega->text;
                    $u_con_conversacion[] = $userColega;
                } else {
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

                    $id_alumno = $userAlumno->id;
                    $msg_alumno = App\Message::where(function ($q) use ($id_alumno) {
                        $q->where('emisor', Auth::user()->id);
                        $q->where('receptor', $id_alumno);
                    })->orWhere(function ($q) use ($id_alumno) {
                        $q->where('emisor', $id_alumno);
                        $q->where('receptor', Auth::user()->id);
                    })->orderBy('created_at', 'DESC')->first();

                    if (!is_null($msg_alumno) && !empty($msg_alumno)) {
                        $userAlumno->ultimo_mensaje = $msg_alumno->text;
                        $u_con_conversacion[] = $userAlumno;
                    } else {
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
            $u_con_conversacion = array();
            $u_sin_conversacion = array();
            $superAdmin = App\User::findOrFail($colegio->id_superadministrador);
            $superAdmin->colegio = $colegio;
            $superAdmin->is_online = $superAdmin->isOnline();

            $id_superadmin = $superAdmin->id;
            $msg_super = App\Message::where(function ($q) use ($id_superadmin) {
                $q->where('emisor', Auth::user()->id);
                $q->where('receptor', $id_superadmin);
            })->orWhere(function ($q) use ($id_superadmin) {
                $q->where('emisor', $id_superadmin);
                $q->where('receptor', Auth::user()->id);
            })->orderBy('created_at', 'DESC')->first();

            if (!is_null($msg_super) && !empty($msg_super)) {
                $superAdmin->ultimo_mensaje = $msg_super->text;
                $u_con_conversacion[] = $superAdmin;
            } else {
                $superAdmin->ultimo_mensaje = '';
                $u_sin_conversacion[] = $superAdmin;
            }

            foreach ($alumno->seccion->docentes()->where('docente_d.estado', '=', 1)->get() as $value_docente) {
                $userDocente = App\User::where([
                    'id_docente' => $value_docente->id_docente
                ])->first();
                $userDocente->docente;
                $userDocente->is_online = $userDocente->isOnline();

                $id_docente = $userDocente->id;
                $msg_docente = App\Message::where(function ($q) use ($id_docente) {
                    $q->where('emisor', Auth::user()->id);
                    $q->where('receptor', $id_docente);
                })->orWhere(function ($q) use ($id_docente) {
                    $q->where('emisor', $id_docente);
                    $q->where('receptor', Auth::user()->id);
                })->orderBy('created_at', 'DESC')->first();

                if (!is_null($msg_docente) && !empty($msg_docente)) {
                    $userDocente->ultimo_mensaje = $msg_docente->text;
                    $u_con_conversacion[] = $userDocente;
                } else {
                    $userDocente->ultimo_mensaje = '';
                    $u_sin_conversacion[] = $userDocente;
                }
            }

            foreach ($alumno->seccion->alumnos()->where([
                ['alumno_d.estado', '=', 1],
                ['id_alumno', '<>', Auth::user()->id_alumno]
            ])->get() as $value_alumno) {
                $userAlumno =  App\User::where([
                    'id_alumno' => $value_alumno->id_alumno
                ])->first();
                $userAlumno->alumno;
                $userAlumno->is_online = $userAlumno->isOnline();

                $id_alumno = $userAlumno->id;
                $msg_alumno = App\Message::where(function ($q) use ($id_alumno) {
                    $q->where('emisor', Auth::user()->id);
                    $q->where('receptor', $id_alumno);
                })->orWhere(function ($q) use ($id_alumno) {
                    $q->where('emisor', $id_alumno);
                    $q->where('receptor', Auth::user()->id);
                })->orderBy('created_at', 'DESC')->first();

                if (!is_null($msg_alumno) && !empty($msg_alumno)) {
                    $userAlumno->ultimo_mensaje = $msg_alumno->text;
                    $u_con_conversacion[] = $userAlumno;
                } else {
                    $userAlumno->ultimo_mensaje = '';
                    $u_sin_conversacion[] = $userAlumno;
                }
            }
            $contacts = collect($u_con_conversacion);
            $friends = collect($u_sin_conversacion);
        }
        $unreadIds = App\Message::select(\DB::raw('`emisor` as sender_id,count(`emisor`) as messages_count'))
            ->where('receptor', Auth::user()->id)
            ->where('readmessage', false)
            ->groupBy('emisor')
            ->get();
        $contacts = $contacts->map(function ($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        //obteniendo los grupos del usuario
        $usuarioLogueado = App\User::findOrFail(Auth::user()->id);
        $groups = $usuarioLogueado->grupos;
        $datos = array(
            'contacts' => $contacts,
            'friends' => $friends,
            'groups' => $groups
        );
        return response()->json($datos);
    }

    public function getMessagesFor($id)
    {
        //marcar todos los mensajes cuando se selecciona un usuario
        App\Message::where('emisor', $id)->where('receptor', Auth::user()->id)->update(['readmessage' => true]);
        $messages = App\Message::where(function ($q) use ($id) {
            $q->where('emisor', Auth::user()->id);
            $q->where('receptor', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('emisor', $id);
            $q->where('receptor', Auth::user()->id);
        })->get();

        return response()->json($messages);
    }
    public function send(Request $request)
    {
        $message = App\Message::create([
            'emisor' => Auth::user()->id,
            'receptor' => $request->contact_id,
            'text' => $request->text
        ]);

        broadcast(new newMessage($message));
        return response()->json($message);
    }
}
