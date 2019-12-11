<template>
  <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Pedidos
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre_cliente">Nombre Cliente</option>
                                <option value="estado">Estado</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarPedido(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarPedido(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <!-- <th>Info Productos</th> -->
                                <th>Nombre Cliente</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Costo Final</th>
                                <!-- <th>Codigo Cliente</th> -->
                                <!-- <th>Puntos</th> -->
                                <th>Observaciones</th>
                                <th>Sala</th>
                                <th>Asiento</th>
                                <th>Procesar Pedido</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pedido in arrayPedido" :key="pedido.id">
              
                                <!-- <td v-text="pedido.productos"></td> -->
                                <td v-text="pedido.nombre_cliente"></td>
                                <td v-text="pedido.fecha"></td>
                                <td v-text="pedido.hora"></td>
                                <td v-text="pedido.costo_final"></td>
                                <!-- <td v-text="pedido.codigo_cliente"></td> -->
                                <!-- <td v-text="pedido.puntos"></td> -->
                                <td v-text="pedido.observaciones"></td>
                                <td v-text="pedido.sala"></td>
                                <td v-text="pedido.asiento"></td>
                                <td>
                                    <div v-if="pedido.estado == 'Pendiente'">
                                        <button type="button" @click="abrirModal('pedido','actualizar',pedido)" class="btn btn-warning btn-sm">
                                        <i class="icon-share-alt"></i>
                                        </button> &nbsp;
                                    </div>
                                    <!-- <template v-if="pedido.estado == 'Recibido'">
                                        <button type="button" class="btn btn-danger btn-sm" @click="actualizarProceso(pedido.id)">
                                            <i class="icon-share-alt"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" disabled>
                                            <i class="icon-check"></i>
                                        </button>
                                    </template> -->
                                </td>
                                <td>
                                    <div v-if="pedido.estado === 'Entregado'" >
                                    <span class="badge badge-pill badge-success">Recibido</span>
                                    </div>

                                    <div v-else-if="pedido.estado === 'Cancelado'" >
                                    <span class="badge badge-pill badge-danger">Cancelado</span>
                                    </div>

                                    <div v-else-if="pedido.estado === 'Pendiente'" >
                                    <span class="badge badge-pill badge-warning">Pendiente</span>
                                    </div>

                                    <div v-else-if="pedido.estado === 'En proceso'" >
                                    <span class="badge badge-pill badge-primary">En Proceso</span>
                                    </div>

                                    <div v-else >
                                    <span class="badge badge-pill badge-dark" v-text="pedido.estado"></span>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>

                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

                <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                <label class="col-md-3 form-control-label" for="text-input">Info Productos</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="productos" class="form-control" placeholder="Productos">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="fecha" class="form-control" placeholder="Fecha">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Hora</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="hora" class="form-control" placeholder="Hora">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Costo Fnal</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="costo_final" class="form-control" placeholder="Costo final">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Código Cliente</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="codigo_cliente" class="form-control" placeholder="Código cliente">                     
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Puntos</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="puntos" class="form-control" placeholder="Puntos">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre Cliente</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="nombre_cliente" class="form-control" placeholder="Nombre del cliente">     
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Observaciones</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="observaciones" class="form-control" placeholder="Observaciones">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Sala</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="sala" class="form-control" placeholder="Sala">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Asiento</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="asiento" class="form-control" placeholder="Asiento">                   
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                <div class="col-md-9">
                                    <input disabled type="text" v-model="estado" class="form-control" placeholder="Estado del pedido">   
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProceso()">Procesar Pedido</button>
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
            return{
                pedido_id: 0,
                productos : '',
                fecha : '',
                nombre_cliente : '',
                observaciones : '',
                sala : '',
                asiento : '',
                hora : '',
                estado : '',
                costo_final : 0,
                codigo_cliente : '',
                puntos : 0,
                arrayPedido : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorAlumno : 0,
                errorMostrarMsjAlumno : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0
                },
                offset : 3,
                criterio : 'nombre_cliente',
                buscar : '',
                productosJSON : ''
                

            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },


            
            //Calcula los elementos de la paginacion
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {

            
            listarPedido (page, buscar, criterio){
                //'alumno' es la route que nos regresa los alumnos
                let me = this;
                var url = 'https://serviciosalas.herokuapp.com/api/pedido?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayPedido = respuesta.pedidos.data;
                    me.pagination = respuesta.pagination;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },



            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina
                me.listarPedido(page, buscar, criterio);
            },
            
            actualizarProceso(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Estás seguro que quieres actualizar el estado?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        //actualizar estado de pedido de 'Recibido' a 'En Proceso'
                        let me = this;

                        axios.put('/pedido/proceso',{
                            'id': this.pedido_id
                        }).then(function (response) {
                            me.cerrarModal();
                            me.listarPedido(1, '', 'nombre_cliente');
                            swalWithBootstrapButtons.fire(
                                'En Proceso',
                                'El estado ha sido actualizado con éxito.',
                                'success'
                        )
                        }).catch(function (error) {
                            console.log(error);
                        });
                        
                        // productosJSON = JSON.parse(this.productos)
                        //Mandando informacion de pedido a dulcería/
                        var url = 'https://cafeteria-cine.herokuapp.com/ventas';
                        axios.post(url,{
                            'productos' :  JSON.parse(this.productos),
                            'costo_final' : this.costo_final,
                            'fecha' : this.fecha,
                            'codigo_cliente' : this.codigo_cliente,
                            'puntos' : this.puntos,
                            'estado' : 'En proceso'
                        }).then(function(response) {
                            console.log(response);
                        }).catch(function(error){
                            console.log(error);
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                    })
            },

            mandarPedidoTienda(){
                //Mandando informacion de pedido a dulcería/
                let me = this;
                // var url = 'https://cafeteria-cine.herokuapp.com/ventas';
                axios.post(url,{
                    'productos' : this.productos,
                    'costo_final' : this.costo_final,
                    'fecha' : this.fecha,
                    'codigo_cliente' : this.codigo_cliente,
                    'puntos' : this.puntos,
                    'estado' : this.estado
                }).then(function(response) {
                    console.log(response);
                }).catch(function(error){
                    console.log(error);
                });
            },

            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "pedido":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                
                            }
                            case 'actualizar':
                            {
                                //console.log(data);

                                this.modal = 1;
                                this.tituloModal = 'Procesar Pedido';
                                this.tipoAccion = 2;

                                this.pedido_id = data['id'];
                                this.productos = data['productos'];
                                this.puntos = data['puntos'];
                                this.asiento = data['asiento'];
                                this.codigo_cliente = data['codigo_cliente'];
                                this.costo_final = data['costo_final'];
                                this.estado = data['estado'];
                                this.fecha = data['fecha'];
                                this.hora = data['hora'];
                                this.nombre_cliente = data['nombre_cliente'];
                                this.observaciones = data['observaciones'];
                                this.sala = data['sala'];
                                // productosJSON = JSON.parse(this.productos)
                                
                                break;
                            }
                        }
                    }
                }
                
            },

            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                
                // this.idcategoria = 0;
                // this.nombre_categoria = '';
                // this.codigo = '';
                // this.nombre = '';
                // this.precio_venta = 0;
                // this.stock = 0;
                // this.descripcion = '';
                // this.errorArticulo = 0;

                this.pedido_id = 0;
                this.productos = '';
                this.puntos = 0;
                this.asiento = '';
                this.codigo_cliente = '';
                this.costo_final = 0;
                this.estado = '';
                this.fecha = '';
                this.hora = '';
                this.nombre_cliente = '';
                this.observaciones = '';
                this.sala = '';
            },

    },
    mounted() {
        this.listarPedido(1, this.buscar, this.criterio);
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
        color:red !important;
        font-weight: bold;
    }
</style>