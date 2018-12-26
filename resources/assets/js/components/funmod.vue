<template>
    <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Funcionalidad Módulo
                <button type="button" @click="abrirModal('funcionalidad','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="S03FunDes">Nombre</option>
                              <option value="S03FunDes">Descripción</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarFuncionalidad(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarFuncionalidad(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Módulo</th>
                            <th>Descripción</th>
                            <th>Vigencia</th>
                            <th>Controlador</th>        
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="funcionalidad in arrayFuncionalidad" :key="funcionalidad.FunCod">
                            <td>
                                <button type="button" @click="abrirModal('funcionalidad','actualizar',funcionalidad)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;                                
                            </td>
                            <td v-text="funcionalidad.ModCod"></td>
                            <td v-text="funcionalidad.FunDes"></td>                            
                            <td>
                                <div v-if="funcionalidad.FunVig">
                                    <span class="badge badge-success">Vigente</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">No Vigente</span>
                                </div>                                 
                            </td> 
                            <td v-text="funcionalidad.FunAcc"></td>
                        </tr>                     
                       
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 0">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>                       
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" :class="{'mostrar' : modal}"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Módulo</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="modulo_id">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="modulo in arrayModulo" :key="modulo.ModCod" :value="modulo.ModCod" v-text="modulo.ModDes"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                            <div class="col-md-9">
                                <input type="text"  v-model="FunDes" class="form-control" placeholder="Descripción de la funcionalidad">                               
                            </div>
                        </div>                       
                        
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Vigencia</label>
                                <div class="col-md-9">
                                    <select class="form-control"  v-model="FunVig">
                                      <option value="1">Vigente</option>
                                      <option value="0">No Vigente</option>
                                    </select>                                    
                                </div>
                           
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Controlador</label>
                            <div class="col-md-9">
                                <input type="text"  v-model="FunAcc" class="form-control" placeholder="Nombre del controlador">                               
                            </div>
                        </div>  
                        
                        <div v-show="errorFuncionalidad" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjFuncionalidad" :key="error" v-text="error">
                                    
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarFuncionalidad()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarFuncionalidad()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
   
</main>
</template>

<script>
    export default {
        data (){
            return {  
                funcionalidad_id : 0,   
                modulo_id : 0,           
                ModCod : '',
                FunCod : '',
                FunDes : '',                
                FunVig : '',
                FunAcc : '',
                FecTra : '',
                FecMod : '',                
                tituloModal : '',
                tipoAccion : 0,
                arrayFuncionalidad : [],
                modal : 0,
                errorFuncionalidad : 0,
                errorMostrarMsjFuncionalidad : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,

                },
                offset : 3,
                criterio : 'FunDes',
                buscar : '',
                arrayModulo : []
                
            }
            
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return []
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page)
                {
                    to = this.pagination.last_page;
                }

                var pagesArrray = [];
                while (from <= to) {
                    pagesArrray.push(from)
                    from++;
                }
                return pagesArrray;
            } 
        },
        methods :  {
            listarFuncionalidad (page,buscar,criterio){
                let me = this;
                var url = '/funcionalidad?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;                
                axios.get(url).then(function (response) {
                   var respuesta = response.data;
                   me.arrayFuncionalidad = respuesta.funcionalidad.data;
                   me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });

            },
            selectModulo() {
                let me = this;
                var url = '/modulo/selectModulo';                
                axios.get(url).then(function (response) {
                   var respuesta = response.data;
                   me.arrayModulo = respuesta.modulos.data;
                   console.log(respuesta);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarFuncionalidad(page,buscar,criterio);
            },
            registrarFuncionalidad (){

                if(this.validarFuncionalidad())
                {
                    return;
                }

                let me = this;                
                axios.post('/funcionalidad/registrar',{
                    'ModCod' : this.modulo_id,
                    'FunDes' : this.FunDes,                    
                    'FunVig' : this.FunVig,
                    'FunAcc' : this.FunAcc                   
                }).then(function (response) {
                  me.cerrarModal();
                  me.listarFuncionalidad(1,'','FunDes');
                })
                .catch(function (error) {
                   console.log(error);
                });
            },
            actualizarFuncionalidad() {

                //if(this.validarModulo())
                //{
                 //  return;
                //}

                let me = this;               
                axios.put('/funcionalidad/actualizar/' + me.funcionalidad_id,{  
                    'ModCod' : this.modulo_id,                  
                    'FunDes' : this.FunDes,                    
                    'FunVig' : this.FunVig,
                    'FunAcc' : this.FunAcc                    
                }).then(function (response) {                  
                  me.cerrarModal();
                  me.listarFuncionalidad(1,'','FunDes');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarFuncionalidad(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de desactivar este modulo?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/funcinalidad/desactivar/'+ me.funcionalidad_id,{                   
                        'FunCod' : me.funcionalidad_id
                    }).then(function (response) {                     
                      me.listarFuncionalidad(1,'','FunDes');
                      swalWithBootstrapButtons(
                      'Desactivado!',
                      'El modulo ha sido desactivado.',
                      'success'

                    )
                    })                   
                    .catch(function (error) {
                        // handle error
                        
                    });
                    
                  } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                  ) {
                    
                  }
                })
            },
              activarFuncionalidad(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de activar este modulo?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/funcionalidad/activar/'+ me.funcionalidad_id,{                   
                        //'PerCon' : 1                
                    }).then(function (response) {                     
                      me.listarFuncionalidad(1,'','FunDes');
                      swalWithBootstrapButtons(
                      'Activado!',
                      'El modulo ha sido activado.',
                      'success'
                    )
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(id);
                    });
                    
                  } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                  ) {
                    
                  }
                })
            },
            validarFuncionalidad(){
                this.validarFuncionalidad = 0;
                this.errorMostrarMsjFuncionalidad = [];

                if(this.modulo_id==0) this.errorMostrarMsjFuncionalidad.push("Seleccione un módulo");                   
                if(!this.FunDes) this.errorMostrarMsjFuncionalidad.push("La descripción de la funcionalidad no puede ser vacio");                
                if(!this.FunVig) this.errorMostrarMsjFuncionalidad.push("Falta seleccionar vigencia");
                if(!this.FunAcc) this.errorMostrarMsjFuncionalidad.push("El nombre del controlador no puede ser vacio");
                
                if(this.errorMostrarMsjFuncionalidad.length) this.errorFuncionalidad = 1;

                return this.errorFuncionalidad;
            },
            cerrarModal (){
                this.modal=0;
                this.tituloModal='';
                this.FunCod = '';                
                this.ModCod = '';
                this.FunDes = '';                
                this.FunVig = '';
                this.FunAcc = '';
                this.FecTra = '';
                this.FecMod = '';
                this.modulo_id = 0;
                
            },
            abrirModal (modelo, accion, data = []){
                switch(modelo){
                    case "funcionalidad":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar funcionalidad módulo';
                                this.modulo_id = 0;
                                this.FunCod = '';
                                this.ModCod = '';
                                this.FunDes = '';                                
                                this.FunVig = '';
                                this.FunAcc = '';
                                this.FecTra = '';
                                this.FecMod = '';                                
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log(data);
                                this.modal = 1;
                                this.tituloModal = "Actualizar funcionalidad módulo";                               
                                this.tipoAccion = 2;
                                this.funcionalidad_id = data['FunCod'];
                                this.ModCod = data['ModCod'];
                                this.FunDes = data['FunDes'];                                
                                this.FunVig = data['FunVig'];
                                this.FunAcc = data['FunAcc'];
                                break;

                            }
                        }
                    }
                }
                this.selectModulo();
            }
        },
        mounted() {
            this.listarFuncionalidad(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
