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
                                <th>Cambiar Estado</th>
                                <th>Info Productos</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Nombre Cliente</th>
                                <th>Observaciones</th>
                                <th>Sala</th>
                                <th>Asiento</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pedido in arrayPedido" :key="pedido.id">
                                <td>
                                    <template v-if="pedido.estado == 'Recibido'">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarArticulo(pedido.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarArticulo(pedido.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="pedido.productos"></td>
                                <td v-text="pedido.fecha"></td>
                                <td v-text="pedido.hora"></td>
                                <td v-text="pedido.nombre_cliente"></td>
                                <td v-text="pedido.observaciones"></td>
                                <td v-text="pedido.sala"></td>
                                <td v-text="pedido.asiento"></td>
                                <!-- <td v-text="pedido.estado"></td> -->
                                <td>
                                    <div v-if="pedido.estado == 'Recibido'" >
                                    <span class="badge badge-success">Recibido</span>
                                    </div>

                                    <div v-else >
                                    <span class="badge badge-primary">En proceso</span>
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
                buscar : ''

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
            
            desactivarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Estás seguro que quieres desactivar este articulo?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;

                        axios.put('/pedido/proceso',{
                            'id': id
                        }).then(function (response) {
                            me.listarPedido(1, '', 'nombre_cliente');
                            swalWithBootstrapButtons.fire(
                                'En Proceso!',
                                'El estado ha sido actualizado con éxito.',
                                'success'
                        )
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                    })
            },



            activarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false,
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Estás seguro que quieres activar este registro?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                    if (result.value) {

                        let me = this;

                        axios.put('/pedido/recibido',{
                            'id': id
                        }).then(function (response) {
                            me.listarPedido(1, '', 'nombre_cliente');
                            swalWithBootstrapButtons.fire(
                                'Activado!',
                                'El registro ha sido activado con éxito.',
                                'success'
                        )
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                 })
            },
    },
    mounted() {
        this.listarPedido(1, this.buscar, this.criterio);
    }
}
</script>