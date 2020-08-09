<template>
    <div>
        <estado-popup 
            :dialog="create_popup_visible" 
            @close="create_popup_visible=false"
            @reload="getEstados(uri)"/>
        <v-container>

        <v-row no-gutters class="align-center">
            <v-col><span class="title">Estados ({{estados.length}})</span></v-col>
            <v-col>
                <v-text-field
                    v-on:keyup.enter="queryString = $event.target.value"
                    style="width: 350px;"
                    flat
                    solo-inverted
                    hide-details
                    prepend-inner-icon="mdi-magnify"
                    label="Procurar"
                ></v-text-field>
            </v-col>
            <v-col class="text-end">
            <span>
                <v-btn text @click="create_popup_visible=true">Adicionar</v-btn>
                <order-by-menu :items="orderByOptions" @order-by="setOrderBy"/>

            </span>
            </v-col>
        </v-row>

        </v-container>
        <v-divider></v-divider>
        
        <v-container>
            <v-row dense v-for="estado in estados" :key="estado._id">
                <v-col>
                    <EstadoCard :estado="estado" @reload="getEstados('/estado')" />
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
//import {api_get} from '../Api/api'
import EstadoCard from './EstadoCard'
import EstadoPopup from './EstadoPopup'
import OrderByMenu from '@/components/Utils/OrderByMenu'

export default {
    name: 'ListaEstados',
    components: {EstadoCard, EstadoPopup, OrderByMenu},
    data: () => ({
        create_popup_visible: false,
        estados: [],
        orderByOptions: [
            {title: 'Nome', value: 'name'},
            {title: 'Sigla', value: 'code'},
            {title: 'Criado', value: 'created_at'},
            {title: 'Atualizado', value: 'updated_at'},
        ],
        orderBy: {field: 'name', direction: 'ASC'},
        queryString: '',
    }),

    computed: {
        uri () {
            var resource = `/estado?order_by=${this.orderBy.field}&order_dir=${this.orderBy.direction}`
            if (this.queryString!='') {
                resource = resource+`&search=${this.queryString}`
            }
            return resource
        },
    },
  
  methods: {

      getEstados(uri){
        var self = this
        self.$root.$emit('loading')
        self.$http.get(uri).then(response => {
            self.estados = response.data
            self.$root.$emit('loading')
        }).catch(error => {
            self.$root.$emit('loading')
            alert('Algo deu errado: ' + error.data.message)
        })
      },
      setOrderBy(order){
          this.orderBy = order
      },
      create() {

      }
  },

    watch: {
        uri () {
            var self = this
            self.getEstados(self.uri)
            return self.estados
        }
    },

  mounted () {
    this.getEstados(this.uri)

  }
}
</script>