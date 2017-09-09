<?php

class Admin extends Controller {

    function __construct() {
        parent::__construct();
        Auth::handleLogin();
    }

    public function index() {
        $this->view->title = 'Dashboard';
        $this->view->render('admin/header');
        $this->view->render('admin/index/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function contacto() {
        $this->view->public_css = array("plugins/datatables/dataTables.bootstrap.css");
        $this->view->public_js = array("plugins/datatables/jquery.dataTables.min.js", "plugins/datatables/dataTables.bootstrap.min.js");
        $this->view->title = 'Contacto';
        $this->view->render('admin/header');
        $this->view->render('admin/contacto/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function unidades_negocio() {
        $this->view->public_css = array("plugins/datatables/dataTables.bootstrap.css");
        $this->view->public_js = array("plugins/ckeditor/ckeditor.js", "plugins/datatables/jquery.dataTables.min.js", "plugins/datatables/dataTables.bootstrap.min.js");
        $this->view->title = 'Contacto';
        $this->view->render('admin/header');
        $this->view->render('admin/unidades_negocio/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function cargarDTContacto() {
        header('Content-type: application/json; charset=utf-8');
        $data = $this->model->cargarDTContacto();
        echo $data;
    }

    public function cargarDTUnidades() {
        header('Content-type: application/json; charset=utf-8');
        $data = $this->model->cargarDTUnidades();
        echo $data;
    }

    public function modalVerContacto() {
        header('Content-type: application/json; charset=utf-8');
        $data = array(
            'id' => $this->helper->cleanInput($_POST['id'])
        );
        $datos = $this->model->modalVerContacto($data);
        echo $datos;
    }

    public function quienes_somos() {
        $this->view->public_css = array("plugins/html5fileupload/html5fileupload.css");
        $this->view->publicHeader_js = array("plugins/html5fileupload/html5fileupload.min.js");
        $this->view->public_js = array("plugins/ckeditor/ckeditor.js", "plugins/html5fileupload/html5fileupload.min.js");
        $this->view->quienesSomos = $this->model->quienesSomos();
        $this->view->elEquipo = $this->model->elEquipo();
        $this->view->title = 'Quiénes Somos';
        $this->view->render('admin/header');
        $this->view->render('admin/quienes_somos/index');
        $this->view->render('admin/footer');
        if (!empty($_SESSION['message']))
            unset($_SESSION['message']);
    }

    public function editQuienesSomos() {
        header('Content-type: application/json; charset=utf-8');
        $data = array(
            'quiene_somos' => $this->helper->cleanInput($_POST['quieneSomos'])
        );
        $datos = $this->model->editQuienesSomos($data);
        echo $datos;
    }

    public function editElEquipo() {
        header('Content-type: application/json; charset=utf-8');
        $data = array(
            'el_equipo' => $this->helper->cleanInput($_POST['elEquipo'])
        );
        $datos = $this->model->editElEquipo($data);
        echo $datos;
    }

    public function upload_img_equipo() {
        if (!empty($_POST)) {
            $this->model->unlinkImgEquipo();
            $error = false;
            $absolutedir = dirname(__FILE__);
            $dir = 'public/assets/img/';
            $serverdir = $dir;
            $tmp = explode(',', $_POST['file']);
            $file = base64_decode($tmp[1]);
            $ext = explode('.', $_POST['filename']);
            $extension = strtolower(end($ext));
            $name = $_POST['name'];
            $filename = $this->helper->cleanUrl($name);
            $filename = $filename . '.' . $extension;
            //$filename				= $file.'.'.substr(sha1(time()),0,6).'.'.$extension;
            $handle = fopen($serverdir . $filename, 'w');
            fwrite($handle, $file);
            fclose($handle);
            #############
            #SE REDIMENSIONA LA IMAGEN
            #############
            # ruta de la imagen a redimensionar 
            $imagen = $serverdir . $filename;
            # ruta de la imagen final, si se pone el mismo nombre que la imagen, esta se sobreescribe 
            $imagen_final = $filename;
            $ancho = 960;
            $alto = 639;
            $this->helper->redimensionar($imagen, $imagen_final, $ancho, $alto, $serverdir);
            #############
            header('Content-type: application/json; charset=utf-8');
            $data = array(
                'img' => $filename
            );
            $response = $this->model->uploadImgEquipo($data);
            echo json_encode($response);
            //echo json_encode(array('result'=>true));
        } else {
            $filename = basename($_SERVER['QUERY_STRING']);
            $file_url = '/public/archivos/' . $filename;
            header('Content-Type: 				application/octet-stream');
            header("Content-Transfer-Encoding: 	Binary");
            header("Content-disposition: 		attachment; filename=\"" . basename($file_url) . "\"");
            readfile($file_url);
            exit();
        }
    }

    public function modalAgregarUnidad() {
        header('Content-type: application/json; charset=utf-8');
        $datos = $this->model->modalAgregarUnidad();
        echo $datos;
    }

    public function frmAddUnidad() {
        if (!empty($_POST)) {
            $data = array(
                'titulo' => $this->helper->cleanInput($_POST['unidad']['titulo']),
                'contenido' => $_POST['unidad']['contenido'],
                'estado' => (!empty($_POST['unidad']['estado'])) ? $_POST['unidad']['estado'] : 0
            );
            $datos = $this->model->frmAddUnidad($data);
            if (!empty($datos)) {
                Session::set('message', array(
                    'type' => 'success',
                    'mensaje' => 'Se ha agregado correctamente la Unidad de Negocio'
                ));
            } else {
                Session::set('message', array(
                    'type' => 'error',
                    'mensaje' => 'Lo sentimos ha ocurrido un error...'
                ));
            }
            header('Location:' . URL . 'admin/unidades_negocio/');
        }
    }

    public function modalEditarUnidad() {
        header('Content-type: application/json; charset=utf-8');
        $data = array(
            'id' => $this->helper->cleanInput($_POST['id'])
        );
        $datos = $this->model->modalEditarUnidad($data);
        echo $datos;
    }

    public function editUnidad() {
        header('Content-type: application/json; charset=utf-8');
        $data = array(
            'id' => $this->helper->cleanInput($_POST['unidad']['id']),
            'titulo' => $this->helper->cleanInput($_POST['unidad']['titulo']),
            'contenido' => $_POST['unidad']['contenido'],
            'estado' => (!empty($_POST['unidad']['estado'])) ? $this->helper->cleanInput($_POST['unidad']['estado']) : 0
        );
        $data = $this->model->editUnidad($data);
        echo json_encode($data);
    }

    public function modalEliminarUnidad() {
        header('Content-type: application/json; charset=utf-8');
        $data = array(
            'id' => $this->helper->cleanInput($_POST['id'])
        );
        $datos = $this->model->modalEliminarUnidad($data);
        echo $datos;
    }
    
    public function deleteUnidad() {
        header('Content-type: application/json; charset=utf-8');
        $data = array(
            'id' => $this->helper->cleanInput($_POST['id'])
        );
        $data = $this->model->deleteUnidad($data);
        echo json_encode($data);
    }
    

}