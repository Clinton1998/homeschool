<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
use Illuminate\Support\Facades\DB;
class NuevaOrganizacionDeCursosParaDocente extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nuevaorganizacion:docentes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $colegios = App\Colegio_m::where([
            'estado' => 1
        ])->get();
        $count_general = 1;
        foreach($colegios as $colegio){
            echo "COLEGIO: ".$colegio->c_nombre."\n";
            $docentes = App\Docente_d::where([
                'estado' => 1,
                'id_colegio'=> $colegio->id_colegio
            ])->get();
            $fila = 1;
            foreach($docentes as $docente){
                        $cursos_del_docente = DB::table('docente_categoria_p')->where([
                            'id_docente' => $docente->id_docente,
                            'estado' => 1
                        ])->get();
                        $cursitos = '';
                        if($cursos_del_docente->count()>0){
                            foreach($cursos_del_docente as $curso){
                                $categoria = App\Categoria_d::where([
                                    'id_categoria' => $curso->id_categoria,
                                    'estado' => 1
                                ])->first();
                                if(!is_null($categoria) && !empty($categoria)){
                                    $cursitos .= '| '.$categoria->c_nombre;
                                    $secciones = $docente->secciones()->where('seccion_d.estado','=',1)->get();
                                    foreach($secciones as $seccion){
                                        $seccion_categoria = DB::table('seccion_categoria_p')->where([
                                            'id_seccion' => $seccion->id_seccion,
                                            'id_categoria' => $categoria->id_categoria,
                                            'estado'=> 1
                                        ])->first();
                                        if(!is_null($seccion_categoria) && !empty($seccion_categoria)){
                                            DB::table('seccion_categoria_docente_p')->insert(
                                                ['id_seccion_categoria' => $seccion_categoria->id_seccion_categoria, 'id_docente' => $docente->id_docente,'creador' => $colegio->id_superadministrador]
                                            );
                                        }
                                    }
                                }
                            }
                            echo $fila."-DNI: ".$docente->c_dni."|Cursos: ".$cursitos."\n";
                            $fila++;
                            $count_general++;
                        }
            }
            echo "\n\n\n";
        }
    }
}
