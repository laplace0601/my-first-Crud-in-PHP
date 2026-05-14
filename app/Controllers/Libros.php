<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\libro;

class Libros extends Controller{
    public function index (){
      $libro = new Libro();
      $datos['libros'] = $libro->orderBy('id','ASC')->findAll();
      $datos['cabecera'] = view('template/cabecera');
      $datos['pie'] = view('template/piepagina');  
      return view('libros/listar', $datos);

    }
      public function crear (){
          $datos['cabecera'] = view('template/cabecera');
          $datos['pie'] = view('template/piepagina');  
          return view('libros/crear', $datos);
      }
      public function guardar (){
     
        $libro = new Libro();
        $nombre = $this->request->getVar('nombre');
          $validacion = $this->validate([
          'nombre' => 'required|min_length[3]',
          'imagen' => [
            'uploaded[imagen]',
            'mime_in[imagen,image/jpg,image/jpeg,image/png]',
            'max_size[imagen,4096]',
          ]
          ]);
          if(!$validacion){
            $_session = session();
            $_session->setFlashdata('mensaje', 'REVISE LA INFORMACION!');
             return redirect()->back()->withInput();

            return $this->response->redirect(site_url('/listar'));
           }  

          if($imagen = $this ->request->getFile('imagen')){
          $nuevoNombre = $imagen->getRandomName();
          $imagen->move('../public/uploads/', $nuevoNombre);
          $datos = [
            'nombre' => $nombre,
            'imagen' => $nuevoNombre
          ];
          $libro->insert($datos);

           };

    echo "datos guardados";
      
      }


    public function borrar($id = null){
      $libro = new Libro();
    
   
      $datoslibros = $libro->where('id', $id)->first();
    if ($datoslibros) {
        $nombreImagen = $datoslibros['imagen'];
        $ruta = '../public/uploads/' . $nombreImagen;

        
        if (!empty($nombreImagen) && file_exists($ruta)) {
            unlink($ruta);
        }

        
        $libro->where('id', $id)->delete();
    }

    
    return $this->response->redirect(site_url('listar'));
      }
    public function editar($id = null){
        $libro = new Libro();
        $datos['libro'] = $libro->where('id', $id)->first();
        
        $datos['cabecera'] = view('template/cabecera');
        $datos['pie'] = view('template/piepagina');  
        
        return view('libros/editar', $datos);
      }
   public function actualizar() {
    $libro = new Libro();
    $id = $this->request->getVar('id');
    $nombre = $this->request->getVar('nombre');

    $datos = ['nombre' => $nombre];



    $imagen = $this->request->getFile('imagen');
      $validacion = $this->validate([
            'nombre' => 'required|min_length[3]',
            'imagen' => [
              'mime_in[imagen,image/jpg,image/jpeg,image/png]',
              'max_size[imagen,4096]',
            ]
            ]);

    if(!$validacion){
            $_session = session();
            $_session->setFlashdata('mensaje', 'REVISE LA INFORMACION!');
             return redirect()->back()->withInput();
    }


    if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
        $validacion = $this->validate([
            'imagen' => [
                'mime_in[imagen,image/jpg,image/jpeg,image/png]',
                'max_size[imagen,4096]',
            ]
        ]);

      if ($validacion) {
            $datosLibro = $libro->find($id);
            $nombreViejo = $datosLibro['imagen'];
            $rutaAnterior = '../public/uploads/' . $nombreViejo;

            if (!empty($nombreViejo) && file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }

            $nuevoNombre = $imagen->getRandomName();
            $imagen->move('../public/uploads/', $nuevoNombre);
            $datos['imagen'] = $nuevoNombre;
        }
    }

    $libro->update($id, $datos);
    return $this->response->redirect(site_url('listar'));
   }
}