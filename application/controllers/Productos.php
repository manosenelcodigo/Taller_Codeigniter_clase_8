<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout("frontend");
    }
    
 
	public function index()
	{
		
        $datos=$this->productos_model->getTodos();
        //print_r($datos);exit;
        $this->layout->view("index",compact('datos'));
	}
    public function listado()
	{
		//zona de configuración inicial
        if($this->uri->segment(3))
        {
            $pagina=$this->uri->segment(3);
        }else
        {
            $pagina=0;
        }
        $porpagina=10;
        //zona de carga de los datos
        $datos=$this->productos_model->getTodosPaginacion($pagina,$porpagina,"limit");
        $cuantos=$this->productos_model->getTodosPaginacion($pagina,$porpagina,"cuantos");           //zona de configuración de la librería pagination
        $config['base_url']=base_url()."productos/listado";
        $config['total_rows']=$cuantos;
        $config['per_page']=$porpagina;
        $config['uri_segment']='3';
        $config['num_links']='4';
        $config['first_link']='Primero';
        $config['next_link']='Siguiente';
        $config['prev_link']='Anterior';
        $config['last_link']='Última';
        
        $config['full_tag_open']='<ul class="pagination">';
        
       
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        
        
        
        $config['full_tag_close']='</ul>';
        $this->pagination->initialize($config);
        $this->layout->view("listado",compact('datos','cuantos','pagina'));
	}
    public function add()
	{
		if($this->input->post())
        {
            if($this->form_validation->run('add_producto'))
            {
                $data=array
                (
                    'nombre'=>$this->input->post('nombre',true),
                    'precio'=>$this->input->post('precio',true),
                    'stock'=>$this->input->post('stock',true),
                    'fecha'=>date("Y-m-d"),
                );
                $insertar=$this->productos_model->insertar($data);
                //echo $insertar;exit;
                $this->session->set_flashdata('css','success');
                $this->session->set_flashdata('mensaje','El registro se ha creado exitosamente');
                redirect(base_url()."productos");
            }
        }
        $this->layout->view("add");
	}
    public function edit($id=null,$pagina=null)
    {
        if(!$id){show_404();}
        $datos=$this->productos_model->getTodosPorId($id);
        if(sizeof($datos)==0){show_404();}
        if($this->input->post())
        {
            if($this->form_validation->run('add_producto'))
            {
                $data=array
                (
                    'nombre'=>$this->input->post('nombre',true),
                    'precio'=>$this->input->post('precio',true),
                    'stock'=>$this->input->post('stock',true),
                );
                $this->productos_model->update($data,$this->input->post('id',true));
                 $this->session->set_flashdata('css','success');
                $this->session->set_flashdata('mensaje','El registro se ha modificado exitosamente');
                redirect(base_url()."productos");
            }
        }
        
        
        $this->layout->view('edit',compact('datos','id','pagina'));
    }
    public function fotos($id=null,$pagina=null)
    {
        if(!$id){show_404();}
        $datos=$this->productos_model->getTodosPorId($id);
        if(sizeof($datos)==0){show_404();}
        if($this->input->post())
        {
            //primero subimos el archivo
            $config['upload_path'] = './public/uploads/productos';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            //$config['max_size']	= '100';
            //$config['max_width'] = '1024';
            //$config['max_height'] = '768';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file'))
                {
                $error = array('error' => $this->upload->display_errors());
                   
                }
            
            //obtenemos el nombre del archivo
            $ima = $this->upload->data();
            $file_name = $ima['file_name'];
            //generamos el insert en la tabla respectiva
            $data=array
            (
                'id_producto'=>$this->input->post('id',true),
                'foto'=>$file_name,
            );
            $this->productos_model->insertarFoto($data);
            $this->session->set_flashdata('css','success');
            $this->session->set_flashdata('mensaje','El registro se ha insertado exitosamente');
            redirect(base_url()."productos/fotos/".$this->input->post('id',true)."/".$this->input->post('pagina',true));
            
        }
        
        $fotos=$this->productos_model->getFotosProductos($id);
        $this->layout->view('fotos',compact('datos','id','pagina','fotos'));
        
        
    }
    public function delete($id=null)
    {
        if(!$id){show_404();}
        $datos=$this->productos_model->getTodosPorId($id);
        if(sizeof($datos)==0){show_404();}
        $this->productos_model->delete($id);
        $this->session->set_flashdata('css','success');
        $this->session->set_flashdata('mensaje','El registro se ha eliminado exitosamente');
        redirect(base_url()."productos");
    }
}




