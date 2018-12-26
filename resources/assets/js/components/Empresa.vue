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
                <i class="fa fa-align-justify"></i> Empresa Principal
                <button type="button" @click="abrirModal('empresa','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="S05EmPNom">Nombre</option>
                              <option value="S05EmPRSo">Razón Social</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarEmpresa(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarEmpresa(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Razón Social</th>
                            <th>Vigencia</th>
                            <th>Responsable</th>
                            <th>Correo</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="empresa in arrayEmpresa" :key="empresa.EmPCod">
                            <td>
                                <button type="button" @click="abrirModal('empresa','actualizar',empresa)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;                               
                            </td>
                            <td v-text="empresa.EmPRut"></td>
                            <td v-text="empresa.EmPNom"></td>
                            <td v-text="empresa.EmPRSo"></td>
                            <td>
                                <div v-if="empresa.EmPVig">
                                    <span class="badge badge-success">Vigente</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">No Vigente</span>
                                </div>                                 
                            </td>
                            
                            <td v-text="empresa.EmPNor"></td>
                            <td v-text="empresa.EmPCor"></td>
                        </tr>                     
                       
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 0">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActive ? 'active' : '']">
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
                            <label class="col-md-3 form-control-label" for="text-input">Rut</label>
                            <div class="col-md-6">
                                <input type="text" id="EmPRut" v-model="EmPRut" class="form-control" placeholder="Rut de la empresa">                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" id="EmPNom" v-model="EmPNom" class="form-control" placeholder="Nombre de la empresa">                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Razón Social</label>
                            <div class="col-md-9">
                                <input type="text" v-model="EmPRSo" class="form-control" placeholder="Razón social de la empresa">
                            </div>
                        </div>
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Vigencia</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="EmPVig" name="EmPVig" v-model="EmPVig">
                                      <option value="1">Vigente</option>
                                      <option value="0">No Vigente</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Nombre Responsable</label>
                            <div class="col-md-9">
                                <input type="text" v-model="EmPNor" class="form-control" placeholder="Nombre responsable">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Apellido paterno</label>
                            <div class="col-md-9">
                                <input type="text" v-model="EmPApr" class="form-control" placeholder="Apellido paterno">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Apellido materno</label>
                            <div class="col-md-9">
                                <input type="text" v-model="EmPAmr" class="form-control" placeholder="Apellido materno">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Correo</label>
                            <div class="col-md-9">
                                <input type="text" v-model="EmPCor" class="form-control" placeholder="Correo">
                            </div>
                        </div>
                        <div v-show="errorEmpresa" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjEmpresa" :key="error" v-text="error">
                                    
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEmpresa()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEmpresa()">Actualizar</button>
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
                empresa_id : 0,              
                EmPCod : '',
                EmPRut : '',
                EmPNom : '',
                EmPRSo : '',
                EmPVig : '',
                EmPNor : '',
                EmPApr : '',
                EmPAmr : '',
                EmPCor : '',
                tituloModal : '',
                tipoAccion : 0,
                arrayEmpresa : [],
                modal : 0,
                errorEmpresa : 0,
                errorMostrarMsjEmpresa : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,

                },
                offset : 3,
                criterio : 'EmPNom',
                buscar : ''
                
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
            listarEmpresa(page,buscar,criterio){
                let me = this;
                var url = '/empresa?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;                
                axios.get(url).then(function (response) {
                   var respuesta = response.data;
                   me.arrayEmpresa = respuesta.empresa.data ;
                   me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });

            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarEmpresa(page,buscar,criterio);
            },
            registrarEmpresa (){

                if(this.validarEmpresa())
                {
                    return;
                }

                let me = this;
                axios.post('/empresa/registrar',{
                    'EmPRut' : this.EmPRut,
                    'EmPNom' : this.EmPNom,
                    'EmPRSo' : this.EmPRSo,
                    'EmPVig' : this.EmPVig,
                    'EmPNor' : this.EmPNor,
                    'EmPApr' : this.EmPApr,
                    'EmPAmr' : this.EmPAmr,
                    'EmPCor' : this.EmPCor
                    
                }).then(function (response) {
                  me.cerrarModal();
                  me.listarEmpresa(1,'','EmPNom');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarEmpresa() {

                //if(this.validarPerfil())
                //{
                 //   return;
                //}

                let me = this;               
                axios.put('/empresa/actualizar/'+ me.empresa_id,{                    
                    'EmPRut' : this.EmPRut,
                    'EmPNom' : this.EmPNom,
                    'EmPRSo' : this.EmPRSo,
                    'EmPVig' : this.EmPVig,
                    'EmPNor' : this.EmPNor,
                    'EmPApr' : this.EmPApr,
                    'EmPAmr' : this.EmPAmr,
                    'EmPCor' : this.EmPCor
                    
                }).then(function (response) {                  
                  me.cerrarModal();
                  me.listarEmpresa(1,'','EmPNom');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarEmpresa(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de desactivar esta empresa?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/empresa/desactivar/'+ id,{                   
                        //'PerCod' : id
                    }).then(function (response) {                     
                      me.listarEmpresa(1,'','EmPNom');
                      swalWithBootstrapButtons(
                      'Desactivado!',
                      'La empresa ha sido desactivada.',
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
              activarEmpresa(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de activar la empresa?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/empresa/activar/'+ id,{                   
                        //'PerCon' : 1                
                    }).then(function (response) {                     
                      me.listarEmpresa(1,'','EmPNom');
                      swalWithBootstrapButtons(
                      'Activado!',
                      'La empresa ha sido activada.',
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
            validarEmpresa(){
                this.validarEmpresa = 0;
                this.errorMostrarMsjEmpresa = [];

                if(!this.EmPRut) this.errorMostrarMsjEmpresa.push("El rut de la empresa no puede ser vacio");
                if(!this.EmPNom) this.errorMostrarMsjEmpresa.push("El nombrede la empresa no puede ser vacio");
                if(!this.EmPRSo) this.errorMostrarMsjEmpresa.push("La razón social de la empresa no puedo ser vacio");
                if(!this.EmPNor) this.errorMostrarMsjEmpresa.push("El nombre del responsable no puede ser vacio");
                if(!this.EmPApr) this.errorMostrarMsjEmpresa.push("El apellido paaterno del responsable no puede ser vacio");
                if(!this.EmPAmr) this.errorMostrarMsjEmpresa.push("El apellido materno del responsable no puede ser vacio");
                if(!this.EmPCor) this.errorMostrarMsjEmpresa.push("El correo  del responsable no puede ser vacio");
                if(this.errorMostrarMsjEmpresa.length) this.errorEmpresa = 1;

                return this.errorEmpresa;
            },
            cerrarModal (){
                this.modal=0;
                this.tituloModal='';
                this.EmPCod = '';
                this.EmPRut = '';
                this.EmPNom = '';
                this.EmPRSo = '';
                this.EmPVig = '';
                this.EmPNor = '';
                this.EmPApr = '';
                this.EmPAmr = '';
                this.EmPCor = '';
            },
            abrirModal (modelo, accion, data = []){
                switch(modelo){
                    case "empresa":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Empresa Principal';
                                this.EmPCod = '';
                                this.EmPRut = '';
                                this.EmPNom = '';
                                this.EmPRSo = '';
                                this.EmPVig = '';
                                this.EmPNor = '';
                                this.EmPApr = '';
                                this.EmPAmr = '';
                                this.EmPCor = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal = 1;
                                this.tituloModal = "Actualizar Empresa Principal";                               
                                this.empresa_id = data['EmPCod'];
                                this.EmPRut = data['EmPRut'];
                                this.EmPNom = data['EmPNom'];
                                this.EmPRSo = data['EmPRSo'];
                                this.EmPVig = data['EmPVig'];
                                this.EmPNor = data['EmPNor'];
                                this.EmPApr = data['EmPApr'];
                                this.EmPAmr = data['EmPAmr'];
                                this.EmPCor = data['EmPCor'];
                                this.tipoAccion = 2;
                                break;

                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarEmpresa(1,this.buscar,this.criterio);
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