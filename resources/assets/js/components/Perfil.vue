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
                <i class="fa fa-align-justify"></i> Perfiles
                <button type="button" @click="abrirModal('perfil','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="S00PerNom">Nombre</option>
                              <option value="S00PerDes">Descripción</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarPerfil(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarPerfil(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo empresa</th>
                            <th>Vigencia</th>
                            <th>Responsable</th>
                            <th>Estado</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="perfil in arrayPerfil" :key="perfil.PerCod">
                            <td>
                                <button type="button" @click="abrirModal('perfil','actualizar',perfil)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <template v-if="perfil.PerCon">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarPerfil(perfil.PerCod)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarPerfil(perfil.PerCod)">
                                        <i class="icon-check"></i>
                                    </button>
                                </template>
                            </td>
                            <td v-text="perfil.PerNom"></td>
                            <td v-text="perfil.PerDes"></td>
                            <td>
                                <div v-if="perfil.TipEmp">
                                    <span class="badge badge-success">Principal</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Contratista/SubContratista</span>
                                </div>                                 
                            </td>
                            <td>
                                <div v-if="perfil.PerVig">
                                    <span class="badge badge-success">Vigente</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">No Vigente</span>
                                </div>                                 
                            </td>
                            
                            <td v-text="perfil.ResTra"></td>

                            <td>
                                <div v-if="perfil.PerCon">
                                    <span class="badge badge-success">Activado</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Desactivado</span>
                                </div>                                 
                            </td>
                            
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
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" id="PerNom" v-model="PerNom" class="form-control" placeholder="Nombre del perfil">                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                            <div class="col-md-9">
                                <input type="text" v-model="PerDes" class="form-control" placeholder="Descripción el perfil">
                            </div>
                        </div>
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Tipo empresa</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="TipEmp" name="TipEmp" v-model="TipEmp">
                                      <option value="1">Principal</option>
                                      <option value="2">Contratista/SubContratista</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Vigencia</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="PerVig" name="PerVig" v-model="PerVig">
                                      <option value="1">Vigente</option>
                                      <option value="0">No Vigente</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                         <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Responsable</label>
                            <div class="col-md-9">
                                <input type="text" v-model="ResTra" class="form-control" placeholder="Codigo responsable">
                            </div>
                        </div>

                        <div v-show="errorPerfil" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjPerfil" :key="error" v-text="error">
                                    
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPerfil()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPerfil()">Actualizar</button>
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
                perfil_id : 0,              
                PerCod : '',
                PerNom : '',
                PerDes : '',
                TipEmp : '',
                PerVig : '',
                FecTra : '',
                FecMod : '',
                ResTra : '',
                PerCon : '',
                tituloModal : '',
                tipoAccion : 0,
                arrayPerfil : [],
                modal : 0,
                errorPerfil : 0,
                errorMostrarMsjPerfil : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,

                },
                offset : 3,
                criterio : 'PerNom',
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
            listarPerfil (page,buscar,criterio){
                let me = this;
                var url = '/perfil?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;                
                axios.get(url).then(function (response) {
                   var respuesta = response.data;
                   me.arrayPerfil = respuesta.perfil.data ;
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
                me.listarPerfil(page,buscar,criterio);
            },
            registrarPerfil (){

                if(this.validarPerfil())
                {
                    return;
                }

                let me = this;
                axios.post('/perfil/registrar',{
                    'PerNom' : this.PerNom,
                    'PerDes' : this.PerDes,
                    'TipEmp' : this.TipEmp,
                    'PerVig' : this.PerVig,
                    'ResTra' : this.ResTra,
                    'PerCon' : 1
                }).then(function (response) {
                  me.cerrarModal();
                  me.listarPerfil(1,'','PerNom');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarPerfil() {

                //if(this.validarPerfil())
                //{
                 //   return;
                //}

                let me = this;               
                axios.put('/perfil/actualizar/'+ me.perfil_id,{                    
                    'PerNom' : this.PerNom,
                    'PerDes' : this.PerDes,
                    'TipEmp' : this.TipEmp,
                    'PerVig' : this.PerVig,
                    'ResTra' : this.ResTra,
                    'PerCon' : this.PerCon
                    
                }).then(function (response) {                  
                  me.cerrarModal();
                  me.listarPerfil(1,'','PerNom');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarPerfil(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de desactivar este perfil?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/perfil/desactivar/'+ id,{                   
                        'PerCod' : id
                    }).then(function (response) {                     
                      me.listarPerfil(1,'','PerNom');
                      swalWithBootstrapButtons(
                      'Desactivado!',
                      'El perfil ha sido desactivado.',
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
              activarPerfil(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de activar este perfil?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/perfil/activar/'+ id,{                   
                        //'PerCon' : 1                
                    }).then(function (response) {                     
                      me.listarPerfil(1,'','PerNom');
                      swalWithBootstrapButtons(
                      'Activado!',
                      'El perfil ha sido activado.',
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
            validarPerfil(){
                this.validarPerfil = 0;
                this.errorMostrarMsjPerfil = [];

                if(!this.PerNom) this.errorMostrarMsjPerfil.push("El nombre del perfil no puede ser vacio");
                if(!this.PerDes) this.errorMostrarMsjPerfil.push("La descripción del perfil no puede ser vacia");
                if(!this.TipEmp) this.errorMostrarMsjPerfil.push("Falta seleccionar tipo de empresa");
                if(!this.PerVig) this.errorMostrarMsjPerfil.push("Falta seleccionar vigencia");
                if(!this.ResTra) this.errorMostrarMsjPerfil.push("El responsable del perfil no puede ser vacio");
                if(this.errorMostrarMsjPerfil.length) this.errorPerfil = 1;

                return this.errorPerfil;
            },
            cerrarModal (){
                this.modal=0;
                this.tituloModal='';
                this.PerCod = '';
                this.PerNom = '';
                this.PerDes = '';
                this.TipEmp = '';
                this.PerVig = '';
                this.FecTra = '';
                this.FecMod = '';
                this.ResTra = '';
            },
            abrirModal (modelo, accion, data = []){
                switch(modelo){
                    case "perfil":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Perfil';
                                this.PerCod = '';
                                this.PerNom = '';
                                this.PerDes = '';
                                this.TipEmp = '';
                                this.PerVig = '';
                                this.FecTra = '';
                                this.FecMod = '';
                                this.ResTra = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal = 1;
                                this.tituloModal = "Actualizar Perfil";                               
                                this.perfil_id = data['PerCod'];
                                this.PerNom = data['PerNom'];
                                this.PerDes = data['PerDes'];
                                this.TipEmp = data['TipEmp'];
                                this.PerVig = data['PerVig'];
                                this.ResTra = data['ResTra'];
                                this.tipoAccion = 2;
                                break;

                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarPerfil(1,this.buscar,this.criterio);
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
