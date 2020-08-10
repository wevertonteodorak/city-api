<template>
    <div>
        <cidade-popup 
            :dialog="create_popup_visible"
            :cidade="cidade"
            @reload="getCidades(uri)"
            @close="create_popup_visible=false"/>
        <v-container>
        <v-row no-gutters class="align-center">
            <v-col><span class="title">Cidades ({{cidades.length}})</span></v-col>
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
                <v-btn text @click="add">Adicionar</v-btn>
                <order-by-menu :items="orderByOptions" @order-by="setOrderBy"/>

            </span>
            </v-col>
        </v-row>
        </v-container>
        <v-divider></v-divider>
        
        <v-container>
            <v-row dense v-for="cidade in cidades" :key="cidade.id">
                <v-col>
                    <CidadeCard :cidade="cidade" @reload="getCidades(uri)" />
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
//import {api_get} from '../Api/api'
import CidadeCard from './CidadeCard'
import CidadePopup from './CidadePopup'
import OrderByMenu from '@/components/Utils/OrderByMenu'
export default {
    name: 'ListaCidades',
    components: {CidadeCard, CidadePopup, OrderByMenu},
    data: () => ({
        create_popup_visible: false,
        orderByOptions: [
            {title: 'Nome', value: 'name'},
            {title: 'Estado', value: 'estado.name'},
            {title: 'Criado', value: 'created_at'},
            {title: 'Atualizado', value: 'updated_at'},
        ],
        queryString: '',
        orderBy: {field: 'name', direction: 'ASC'},
        cidades: [],
        cidade: {}
    }),

    computed: {
        uri () {
            var resource = `/cidade?order_by=${this.orderBy.field}&order_dir=${this.orderBy.direction}`
            if (this.queryString!='') {
                resource = resource+`&search=${this.queryString}`
            }
            return resource
        },
    },
  
    methods: {
      add(){
        this.cidade = {code: '', name: '', estado_id: ''}
        this.create_popup_visible = true
      },
      setOrderBy(order){
          this.orderBy = order
      },
      getCidades(uri){
        var self = this
        self.$root.$emit('loading')
        self.$http.get(uri).then(response => {
            self.cidades = response.data
            self.$root.$emit('loading')
        }).catch(error => {
            self.$root.$emit('loading')
            alert('Algo deu errado: ' + error.data.message)
        })
      },

      create() {

      }
  },

    watch: {
        uri () {
            var self = this
            self.getCidades(self.uri)
            return self.cidades
        }
    },
    mounted () {
        this.getCidades(this.uri)
        var self = this
        this.$root.$on('edit-cidade', (cidade) => {
            self.cidade = cidade
            self.create_popup_visible = true
        });
    }
}
</script>